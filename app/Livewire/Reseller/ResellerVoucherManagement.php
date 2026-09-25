<?php

namespace App\Livewire\Reseller;

use App\Http\Controllers\MikrotikController;
use App\Models\HotspotVoucher;
use App\Models\PackageList;
use App\Services\ResellerWalletService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class ResellerVoucherManagement extends Component
{
    use WithPagination;

    public int $count = 5;
    public ?int $package_id = null;
    public string $expiry_date = '';
    public int $length = 6;
    public string $prefix = '';
    public string $batch_name = '';
    public bool $user_equals_password = true;
    public string $validity_type = 'uptime';
    public string $limit_uptime = '';
    public bool $push_to_router = true;
    public string $voucherSearch = '';

    protected $paginationTheme = 'bootstrap';

    public function mount(): void
    {
        $this->expiry_date = now()->addMonths(3)->format('Y-m-d');
    }

    public function rules(): array
    {
        return [
            'count' => 'required|integer|min:1|max:500',
            'package_id' => 'required|integer|exists:package_lists,id',
            'expiry_date' => 'required|date|after:today',
            'length' => 'required|integer|min:3|max:20',
            'prefix' => 'nullable|string|max:20',
            'batch_name' => 'nullable|string|max:100',
            'user_equals_password' => 'boolean',
            'validity_type' => 'required|in:uptime,realtime',
            'limit_uptime' => 'nullable|string|max:50',
            'push_to_router' => 'boolean',
        ];
    }

    /**
     * Packages available to this reseller:
     * - master packages assigned by Super Admin
     * - custom packages created by this reseller
     */
    protected function availablePackages()
    {
        $reseller = currentReseller();

        if (! $reseller) {
            return collect();
        }

        $assignedIds = $reseller->assignedPackages()
            ->pluck('package_lists.id');

        return PackageList::query()
            ->where(function ($query) use ($reseller, $assignedIds) {
                $query
                    ->whereIn('id', $assignedIds)
                    ->orWhere('reseller_id', $reseller->id);
            })
            ->orderBy('package')
            ->get();
    }

    protected function selectedPackage(): ?PackageList
    {
        if (! $this->package_id) {
            return null;
        }

        return $this->availablePackages()
            ->firstWhere('id', (int) $this->package_id);
    }

    protected function generateVoucherString(int $length): string
    {
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

        return substr(
            str_shuffle(str_repeat($chars, 5)),
            0,
            $length
        );
    }

    public function generate(): void
    {
        $this->validate();

        $reseller = currentReseller();

        if (! $reseller) {
            flash()->error('Unauthorized.');
            return;
        }

        $package = $this->selectedPackage();

        if (! $package) {
            $this->addError(
                'package_id',
                'Selected package is not assigned to your reseller account.'
            );
            return;
        }

        if (! $package->router_name) {
            $this->addError(
                'package_id',
                'This package is not linked to a MikroTik router.'
            );
            return;
        }

        if (! $package->package) {
            $this->addError(
                'package_id',
                'This package does not have a valid MikroTik hotspot profile.'
            );
            return;
        }

        $routerName = $package->router_name;
        $profile = $package->package;
        $price = (float) $package->price;

        $batch = trim($this->batch_name);

        if ($batch === '') {
            $batch = 'RS-'.$reseller->id.'-'.strtoupper(Str::random(6));
        }

        $this->batch_name = $batch;

        /*
         * Expiry date applies to the voucher inventory.
         * Store it as the end of the selected day.
         */
        $expiresAt = Carbon::parse($this->expiry_date)->endOfDay();

        /*
         * Build unique voucher codes.
         */
        $existingCodes = HotspotVoucher::pluck('code')->flip();

        $created = [];
        $attempts = 0;

        while (
            count($created) < $this->count
            && $attempts < 5000
        ) {
            $attempts++;

            $code = strtoupper(trim($this->prefix))
                .$this->generateVoucherString($this->length);

            if (
                isset($existingCodes[$code])
                || collect($created)->contains('code', $code)
            ) {
                continue;
            }

            $password = $this->user_equals_password
                ? $code
                : $this->generateVoucherString($this->length);

            $comment = 'Reseller: '
                .($reseller->company
                    ?: $reseller->user?->name
                    ?: 'Reseller');

            $created[] = [
                'router_name' => $routerName,
                'code' => $code,
                'profile' => $profile,
                'username' => $code,
                'password' => $password,
                'price' => $price,
                'batch_name' => $batch,
                'status' => 'unused',
                'expires_at' => $expiresAt,
                'comment' => $comment,
                'validity_type' => $this->validity_type,
                'validity_duration' => $this->limit_uptime ?: null,
                'created_by' => auth()->id(),
                'reseller_id' => $reseller->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (count($created) !== $this->count) {
            flash()->error(
                'Unable to generate the requested number of unique vouchers.'
            );
            return;
        }

        /*
         * Reseller wallet pricing.
         */
        $commissionPercentage = (float) $reseller->commission_percentage;

        $payDiscountedUpfront = (bool) $reseller->getSetting(
            'pay_discounted_upfront',
            false
        );

        $costPerVoucher = $price;

        if ($payDiscountedUpfront) {
            $costPerVoucher = $price
                * (1 - ($commissionPercentage / 100));
        }

        $totalCost = $this->count * $costPerVoucher;

        if ((float) $reseller->balance < $totalCost) {
            flash()->error(
                'Insufficient wallet balance. You need TZS '
                .number_format($totalCost, 2)
                .' but only have TZS '
                .number_format((float) $reseller->balance, 2)
            );
            return;
        }

        DB::beginTransaction();

        try {
            $walletService = app(ResellerWalletService::class);

            $walletService->debit(
                $reseller,
                $totalCost,
                'Generated '.$this->count
                .' hotspot vouchers for package '
                .$package->package
                .'. Total cost TZS '
                .number_format($totalCost, 2),
                'hotspot_voucher_generation'
            );

            HotspotVoucher::insert($created);

            $pushErrors = [];

            if ($this->push_to_router) {
                $users = array_map(
                    fn ($voucher) => [
                        'name' => $voucher['username'],
                        'password' => $voucher['password'],
                        'profile' => $voucher['profile'],
                        'comment' => $voucher['comment'],
                        'limit-uptime' =>
                            $this->validity_type === 'uptime'
                                ? $this->limit_uptime
                                : '',
                    ],
                    $created
                );

                $results = app(MikrotikController::class)
                    ->pushHotspotUserBatch(
                        $routerName,
                        $users
                    );

                $pushErrors = array_filter(
                    $results,
                    fn ($result) =>
                        str_starts_with($result, 'Error')
                );
            }

            DB::commit();

            activity()
                ->performedOn($reseller)
                ->causedBy(auth()->user())
                ->log(
                    'Generated '.$this->count
                    .' hotspot vouchers for package '
                    .$package->package
                    .'. Batch '.$batch
                    .'. Total cost TZS '
                    .number_format($totalCost, 2)
                );

            if ($pushErrors) {
                flash()->warning(
                    count($pushErrors)
                    .' voucher(s) were saved but failed to push to MikroTik.'
                );
            } else {
                flash()->success(
                    $this->count
                    .' hotspot vouchers generated successfully. '
                    .'Total cost: TZS '
                    .number_format($totalCost, 2)
                );
            }

            $this->resetFields();
            $this->resetPage();

        } catch (\Throwable $e) {
            DB::rollBack();

            report($e);

            flash()->error(
                'Failed to generate hotspot vouchers: '
                .$e->getMessage()
            );
        }
    }

    public function cancelVoucher(int $id): void
    {
        $reseller = currentReseller();

        if (! $reseller) {
            flash()->error('Unauthorized.');
            return;
        }

        /*
         * Ownership is checked using reseller_id, not created_by.
         * This also works when Super Admin is operating in reseller context.
         */
        $voucher = HotspotVoucher::query()
            ->where('id', $id)
            ->where('reseller_id', $reseller->id)
            ->firstOrFail();

        if ($voucher->status !== 'unused') {
            flash()->error(
                'Only unused vouchers can be cancelled.'
            );
            return;
        }

        DB::beginTransaction();

        try {
            /*
             * The existing hotspot_vouchers status enum does not contain
             * "cancelled", so use "expired" for now.
             */
            $voucher->update([
                'status' => 'expired',
            ]);

            $walletService = app(ResellerWalletService::class);

            $walletService->credit(
                $reseller,
                (float) $voucher->price,
                'Refunded cancelled hotspot voucher: '
                .$voucher->code,
                'hotspot_voucher_cancellation',
                $voucher->id
            );

            DB::commit();

            flash()->success(
                'Voucher '.$voucher->code
                .' cancelled and TZS '
                .number_format((float) $voucher->price, 2)
                .' refunded.'
            );

        } catch (\Throwable $e) {
            DB::rollBack();

            report($e);

            flash()->error(
                'Failed to cancel voucher: '
                .$e->getMessage()
            );
        }
    }

    public function render()
    {
        $reseller = currentReseller();

        if (! $reseller) {
            abort(403);
        }

        $packages = $this->availablePackages();

        /*
         * Only vouchers belonging to this reseller are visible.
         */
        $vouchers = HotspotVoucher::query()
            ->where('reseller_id', $reseller->id)
            ->when(
                $this->voucherSearch,
                function ($query) {
                    $search = trim($this->voucherSearch);

                    $query->where(function ($q) use ($search) {
                        $q->where(
                            'code',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'profile',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'batch_name',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'router_name',
                            'like',
                            "%{$search}%"
                        );
                    });
                }
            )
            ->latest()
            ->paginate(20);

        return view(
            'livewire.reseller.voucher-management',
            compact(
                'packages',
                'vouchers',
                'reseller'
            )
        );
    }

    protected function resetFields(): void
    {
        $this->count = 5;
        $this->package_id = null;
        $this->expiry_date = now()
            ->addMonths(3)
            ->format('Y-m-d');
        $this->length = 6;
        $this->prefix = '';
        $this->batch_name = '';
        $this->user_equals_password = true;
        $this->validity_type = 'uptime';
        $this->limit_uptime = '';
        $this->push_to_router = true;

        $this->resetValidation();
    }
}
