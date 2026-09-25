<?php

namespace App\Services\Payments;

use App\Models\HotspotPurchaseRequest;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HotspotPaymentService
{
    public function gateway(string $provider): TanzaniaPaymentGateway
    {
        return match ($provider) {
            'selcom' => app(SelcomGateway::class),
            'mpesa_tz' => app(VodacomMpesaTzGateway::class),
            'beem_bpay' => app(BeemBpayGateway::class),
            'azampesa' => app(AzamPesaGateway::class),
            default => throw new \InvalidArgumentException(
                'Unsupported Tanzania payment provider: '.$provider
            ),
        };
    }

    public function initiate(
        HotspotPurchaseRequest $purchase,
        string $provider
    ): PaymentTransaction {
        if ($purchase->payment_status === 'paid') {
            $existing = $purchase->paymentTransaction;

            if ($existing) {
                return $existing;
            }

            $existing = PaymentTransaction::where(
                'merchant_reference',
                $purchase->merchant_reference
            )->first();

            if ($existing) {
                $purchase->update([
                    'payment_transaction_id' => $existing->id,
                ]);

                return $existing->refresh();
            }

            throw new \RuntimeException(
                'Hotspot purchase is already marked paid but has no payment transaction.'
            );
        }

        $existing = PaymentTransaction::where(
            'merchant_reference',
            $purchase->merchant_reference
        )->first();

        if ($existing) {
            if ((float) $existing->amount !== (float) $purchase->amount) {
                throw new \RuntimeException(
                    'Payment transaction amount does not match Hotspot purchase amount.'
                );
            }

            $purchase->update([
                'payment_gateway' => $provider,
                'payment_transaction_id' => $existing->id,
            ]);

            return $existing->refresh();
        }

        $phone = $this->normalizePhone($purchase->phone);

        $tx = PaymentTransaction::create([
            'provider' => $provider,
            'channel' => 'MOBILEMONEY',
            'customer_unique_id' => 'HOTSPOT-'.$purchase->id,
            'merchant_reference' => $purchase->merchant_reference,
            'phone' => $phone,
            'amount' => (float) $purchase->amount,
            'currency' => $purchase->currency ?: 'TZS',
            'status' => 'pending',
        ]);

        $purchase->update([
            'payment_gateway' => $provider,
            'payment_transaction_id' => $tx->id,
        ]);

        try {
            $result = $this->gateway($provider)->initiate([
                'merchant_reference' => $purchase->merchant_reference,
                'phone' => $phone,
                'amount' => (float) $purchase->amount,
            ]);

            $tx->update([
                'status' => $result['status'],
                'provider_transaction_id' =>
                    $result['provider_transaction_id'],
                'provider_reference' =>
                    $result['provider_reference'],
                'redirect_url' =>
                    $result['redirect_url'] ?? null,
                'response_payload' =>
                    $result['raw'],
                'paid_at' =>
                    $result['status'] === 'paid' ? now() : null,
            ]);

            if ($result['status'] === 'paid') {
                $this->markPaid($tx);
            }

            return $tx->refresh();
        } catch (\Throwable $e) {
            $tx->update([
                'status' => 'failed',
                'failure_message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public function isHotspotTransaction(?PaymentTransaction $tx): bool
    {
        if (! $tx) {
            return false;
        }

        return str_starts_with(
            strtoupper((string) $tx->merchant_reference),
            'HSP-'
        );
    }

    public function finalizeCallback(
        PaymentTransaction $tx,
        ?string $providerTransactionId = null,
        ?string $providerReference = null,
        array $payload = []
    ): PaymentTransaction {
        if (! $this->isHotspotTransaction($tx)) {
            throw new \InvalidArgumentException(
                'The supplied transaction is not a Hotspot transaction.'
            );
        }

        return $this->markPaid(
            $tx,
            $providerTransactionId,
            $providerReference,
            $payload
        );
    }

    public function purchaseFromTransaction(
        PaymentTransaction $tx
    ): ?HotspotPurchaseRequest {
        if (! $this->isHotspotTransaction($tx)) {
            return null;
        }

        return HotspotPurchaseRequest::where(
            'merchant_reference',
            $tx->merchant_reference
        )->first();
    }

    public function query(PaymentTransaction $tx): PaymentTransaction
    {
        if ($tx->status === 'paid') {
            $this->markPaid($tx);

            return $tx->refresh();
        }

        $queryReference = $tx->provider === 'azampesa'
            ? ($tx->provider_transaction_id ?: $tx->merchant_reference)
            : $tx->merchant_reference;

        $result = $this->gateway($tx->provider)->query($queryReference);

        $tx->update([
            'status' => $result['status'],
            'provider_transaction_id' =>
                $result['provider_transaction_id']
                ?: $tx->provider_transaction_id,
            'provider_reference' =>
                $result['provider_reference']
                ?: $tx->provider_reference,
            'response_payload' => $result['raw'],
            'last_checked_at' => now(),
            'paid_at' =>
                $result['status'] === 'paid'
                    ? ($tx->paid_at ?: now())
                    : $tx->paid_at,
        ]);

        if ($result['status'] === 'paid') {
            $this->markPaid($tx->refresh());
        }

        return $tx->refresh();
    }

    public function markPaid(
        PaymentTransaction $tx,
        ?string $providerTransactionId = null,
        ?string $providerReference = null,
        array $payload = []
    ): PaymentTransaction {
        /*
         * First commit the successful payment.
         *
         * IMPORTANT:
         * Hotspot router activation happens only AFTER this transaction
         * commits. Therefore a router outage can never roll back a payment
         * that has already been verified as successful.
         */
        $paidTransaction = DB::transaction(function () use (
            $tx,
            $providerTransactionId,
            $providerReference,
            $payload
        ) {
            $tx = PaymentTransaction::query()
                ->lockForUpdate()
                ->findOrFail($tx->id);

            $tx->update([
                'status' => 'paid',
                'provider_transaction_id' =>
                    $providerTransactionId
                    ?: $tx->provider_transaction_id,
                'provider_reference' =>
                    $providerReference
                    ?: $tx->provider_reference,
                'response_payload' =>
                    $payload ?: $tx->response_payload,
                'paid_at' => $tx->paid_at ?: now(),
            ]);

            $purchase = HotspotPurchaseRequest::where(
                'merchant_reference',
                $tx->merchant_reference
            )
                ->lockForUpdate()
                ->first();

            if (! $purchase) {
                throw new \RuntimeException(
                    'Hotspot purchase request was not found for payment transaction '.$tx->id.'.'
                );
            }

            if ((float) $purchase->amount !== (float) $tx->amount) {
                throw new \RuntimeException(
                    'Hotspot payment amount does not match purchase amount.'
                );
            }

            if ($purchase->payment_status !== 'paid') {
                $purchase->update([
                    'payment_status' => 'paid',
                    'paid_at' => $purchase->paid_at ?: now(),
                    'payment_transaction_id' => $tx->id,
                ]);
            } elseif (! $purchase->payment_transaction_id) {
                $purchase->update([
                    'payment_transaction_id' => $tx->id,
                ]);
            }

            return $tx->fresh();
        });

        /*
         * Payment is now safely committed.
         *
         * Activation failure is deliberately isolated from payment success.
         * The purchase remains PAID and the activation service records the
         * activation failure so that a retry can be performed later.
         */
        try {
            $purchase = HotspotPurchaseRequest::where(
                'merchant_reference',
                $paidTransaction->merchant_reference
            )->first();

            if ($purchase && $purchase->activation_status !== 'activated') {
                app(\App\Services\Hotspot\HotspotActivationService::class)
                    ->activate($purchase);
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error(
                'Hotspot activation could not be started after successful payment.',
                [
                    'payment_transaction_id' => $paidTransaction->id,
                    'merchant_reference' => $paidTransaction->merchant_reference,
                    'error' => $e->getMessage(),
                ]
            );
        }

        return $paidTransaction->refresh();
    }

    private function normalizePhone(?string $phone): string
    {
        $phone = preg_replace('/\D+/', '', (string) $phone);

        if (str_starts_with($phone, '0')) {
            $phone = '255'.substr($phone, 1);
        }

        if (str_starts_with($phone, '+')) {
            $phone = ltrim($phone, '+');
        }

        if (! str_starts_with($phone, '255')) {
            throw new \InvalidArgumentException(
                'Tanzania mobile number must use 255XXXXXXXXX format.'
            );
        }

        return $phone;
    }
}
