<?php

namespace App\Services;

use App\Models\HotspotSale;
use App\Models\PlatformTransaction;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SuperAdminPlatformFeeService
{
    private const FEE_PERCENTAGE = 10.00;

    /**
     * Record the 10% platform fee for a successful Hotspot sale.
     *
     * The Hotspot sale remains at its full gross amount.
     * Only the platform accounting entry is created here.
     */
    public function recordForHotspotSale(HotspotSale $sale): ?PlatformTransaction
    {
        if ((float) $sale->amount <= 0) {
            Log::warning("Platform fee skipped for Hotspot sale {$sale->id}: sale amount is zero.");
            return null;
        }

        // Idempotency check.
        $existing = PlatformTransaction::where('hotspot_sale_id', $sale->id)->first();

        if ($existing) {
            return $existing;
        }

        $superAdmin = User::role('Super Admin')
            ->orderBy('id')
            ->first();

        if (! $superAdmin) {
            throw new \RuntimeException(
                'Cannot record Hotspot platform fee: no Super Admin user was found.'
            );
        }

        $grossAmount = round((float) $sale->amount, 2);
        $feePercentage = self::FEE_PERCENTAGE;
        $feeAmount = round($grossAmount * ($feePercentage / 100), 2);

        $resellerId = null;

        // Hotspot vouchers carry the reseller ownership.
        if ($sale->voucher_code) {
            $voucher = \App\Models\HotspotVoucher::where(
                'code',
                $sale->voucher_code
            )->first();

            if ($voucher) {
                $resellerId = $voucher->reseller_id;
            }
        }

        try {
            return DB::transaction(function () use (
                $sale,
                $superAdmin,
                $resellerId,
                $grossAmount,
                $feePercentage,
                $feeAmount
            ) {
                // Check again inside the transaction.
                $existing = PlatformTransaction::where(
                    'hotspot_sale_id',
                    $sale->id
                )->first();

                if ($existing) {
                    return $existing;
                }

                return PlatformTransaction::create([
                    'super_admin_user_id' => $superAdmin->id,
                    'hotspot_sale_id' => $sale->id,
                    'reseller_id' => $resellerId,
                    'type' => 'platform_fee',
                    'gross_amount' => $grossAmount,
                    'fee_percentage' => $feePercentage,
                    'fee_amount' => $feeAmount,
                    'currency' => 'TZS',
                    'description' => sprintf(
                        '10%% platform fee from Hotspot sale #%d (%s)',
                        $sale->id,
                        $sale->voucher_code ?: $sale->username
                    ),
                ]);
            });
        } catch (QueryException $e) {
            // The unique hotspot_sale_id constraint protects against
            // concurrent duplicate callbacks/sync operations.
            if (str_contains(strtolower($e->getMessage()), 'duplicate')
                || str_contains(strtolower($e->getMessage()), 'unique')) {
                return PlatformTransaction::where(
                    'hotspot_sale_id',
                    $sale->id
                )->first();
            }

            throw $e;
        }
    }

    public function calculateFee(float $amount): float
    {
        return round($amount * (self::FEE_PERCENTAGE / 100), 2);
    }
}
