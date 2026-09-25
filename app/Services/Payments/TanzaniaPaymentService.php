<?php

namespace App\Services\Payments;

use App\Models\CustomersInfo;
use App\Models\PaymentTransaction;
use App\Services\PaymentService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TanzaniaPaymentService
{
    public function gateway(string $provider): TanzaniaPaymentGateway
    {
        return match ($provider) {
            'selcom' => app(SelcomGateway::class),
            'mpesa_tz' => app(VodacomMpesaTzGateway::class),
            'beem_bpay' => app(BeemBpayGateway::class),
            'azampesa' => app(AzamPesaGateway::class),
            default => throw new \InvalidArgumentException('Unsupported Tanzania payment provider: '.$provider),
        };
    }

    public function initiate(CustomersInfo $customer, float $amount, string $provider, ?string $phone = null): PaymentTransaction
    {
        $reference = 'ISP'.now()->format('ymdHis').strtoupper(Str::random(6));
        $phone = $this->normalizePhone($phone ?: $customer->mobile);
        $tx = PaymentTransaction::create([
            'provider' => $provider,
            'channel' => 'MOBILEMONEY',
            'customer_unique_id' => $customer->customer_unique_id,
            'merchant_reference' => $reference,
            'phone' => $phone,
            'amount' => $amount,
            'currency' => 'TZS',
            'status' => 'pending',
        ]);
        try {
            $result = $this->gateway($provider)->initiate(['merchant_reference'=>$reference,'phone'=>$phone,'amount'=>$amount]);
            $tx->update([
                'status' => $result['status'],
                'provider_transaction_id' => $result['provider_transaction_id'],
                'provider_reference' => $result['provider_reference'],
                'redirect_url' => $result['redirect_url'] ?? null,
                'response_payload' => $result['raw'],
                'paid_at' => $result['status'] === 'paid' ? now() : null,
            ]);
            if ($result['status'] === 'paid') $this->finalize($tx);
            return $tx->refresh();
        } catch (\Throwable $e) {
            $tx->update(['status'=>'failed','failure_message'=>$e->getMessage()]);
            throw $e;
        }
    }

    public function query(PaymentTransaction $tx): PaymentTransaction
    {
        $queryReference = $tx->provider === 'azampesa'
            ? ($tx->provider_transaction_id ?: $tx->merchant_reference)
            : $tx->merchant_reference;
        $result = $this->gateway($tx->provider)->query($queryReference);
        $tx->update([
            'status'=>$result['status'],
            'provider_transaction_id'=>$result['provider_transaction_id'] ?: $tx->provider_transaction_id,
            'provider_reference'=>$result['provider_reference'] ?: $tx->provider_reference,
            'response_payload'=>$result['raw'],
            'last_checked_at'=>now(),
            'paid_at'=>$result['status']==='paid' ? ($tx->paid_at ?: now()) : $tx->paid_at,
        ]);
        if ($result['status'] === 'paid') $this->finalize($tx->refresh());
        return $tx->refresh();
    }

    public function markPaid(PaymentTransaction $tx, ?string $providerTransactionId = null, ?string $providerReference = null, array $payload = []): PaymentTransaction
    {
        $tx->update([
            'status'=>'paid',
            'provider_transaction_id'=>$providerTransactionId ?: $tx->provider_transaction_id,
            'provider_reference'=>$providerReference ?: $tx->provider_reference,
            'response_payload'=>$payload ?: $tx->response_payload,
            'paid_at'=>$tx->paid_at ?: now(),
        ]);
        $this->finalize($tx->refresh());
        return $tx->refresh();
    }

    private function finalize(PaymentTransaction $tx): void
    {
        if ($tx->status !== 'paid') return;
        $already = DB::table('collection_summaries')->where('transaction_id', $tx->provider_transaction_id ?: $tx->merchant_reference)->exists();
        if ($already) return;
        $customer = CustomersInfo::where('customer_unique_id', $tx->customer_unique_id)->firstOrFail();
        app(PaymentService::class)->processSuccessPayment($customer, (float)$tx->amount, $tx->provider, $tx->provider_transaction_id ?: $tx->merchant_reference);
    }

    private function normalizePhone(?string $phone): string
    {
        $phone = preg_replace('/\D+/', '', (string)$phone);
        if (str_starts_with($phone, '0')) $phone = '255'.substr($phone, 1);
        if (str_starts_with($phone, '+')) $phone = ltrim($phone, '+');
        if (!str_starts_with($phone, '255')) throw new \InvalidArgumentException('Tanzania mobile number must use 255XXXXXXXXX format.');
        return $phone;
    }
}
