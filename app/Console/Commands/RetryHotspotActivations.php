<?php

namespace App\Console\Commands;

use App\Models\HotspotPurchaseRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class RetryHotspotActivations extends Command
{
    protected $signature = 'app:retry-hotspot-activations';

    protected $description = 'Retry paid Hotspot purchases that have not yet been activated';

    public function handle(): int
    {
        $purchases = HotspotPurchaseRequest::query()
            ->where('payment_status', 'paid')
            ->where('activation_status', '!=', 'activated')
            ->where(function ($query) {
                $query
                    ->where('activation_status', 'failed')
                    ->orWhere('activation_status', 'pending')
                    ->orWhere('activation_status', 'processing');
            })
            ->orderBy('id')
            ->limit(20)
            ->get();

        if ($purchases->isEmpty()) {
            $this->info('No paid Hotspot activations require retry.');

            return self::SUCCESS;
        }

        $this->info(
            'Found '.$purchases->count().' paid Hotspot activation(s) to process.'
        );

        foreach ($purchases as $purchase) {
            /*
             * Re-read the record before activating so a previous worker
             * cannot cause a duplicate activation.
             */
            $purchase->refresh();

            if ($purchase->payment_status !== 'paid') {
                continue;
            }

            if ($purchase->activation_status === 'activated') {
                continue;
            }

            try {
                $this->line(
                    'Activating purchase #'.$purchase->id.
                    ' '.$purchase->merchant_reference.
                    ' on '.$purchase->router_name.'...'
                );

                $result = app(
                    \App\Services\Hotspot\HotspotActivationService::class
                )->activate($purchase);

                if ($result->activation_status === 'activated') {
                    $this->info(
                        '  SUCCESS: purchase #'.$purchase->id.' activated.'
                    );
                } else {
                    $this->warn(
                        '  NOT ACTIVATED: purchase #'.$purchase->id.
                        ' status='.$result->activation_status.
                        ' error='.($result->activation_error ?: 'unknown')
                    );
                }
            } catch (Throwable $e) {
                Log::error(
                    'Hotspot activation retry failed.',
                    [
                        'purchase_id' => $purchase->id,
                        'merchant_reference' => $purchase->merchant_reference,
                        'router_name' => $purchase->router_name,
                        'error' => $e->getMessage(),
                    ]
                );

                $this->error(
                    '  FAILED: purchase #'.$purchase->id.
                    ' '.$e->getMessage()
                );
            }
        }

        return self::SUCCESS;
    }
}
