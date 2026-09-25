<?php

namespace App\Services\Payments;

use Illuminate\Support\Facades\Http;

class BeemBpayGateway implements TanzaniaPaymentGateway
{
    public function initiate(array $payment): array
    {
        $url = config('services.beem.bpay_checkout_url');
        if (! $url) {
            throw new \RuntimeException('BEEM_BPAY_CHECKOUT_URL is required. Configure the Beem BPay/Checkout URL supplied for your merchant account.');
        }

        $transactionId = $payment['merchant_reference'];
        $payload = [
            'amount' => (string) (int) round($payment['amount']),
            'transaction_id' => $transactionId,
            'reference_number' => $transactionId,
        ];
        if (! empty($payment['phone'])) {
            $payload['mobile'] = $payment['phone'];
        }

        $response = $this->request($url, $payload);
        $redirectUrl = $response['src'] ?? $response['checkout_url'] ?? $response['redirect_url'] ?? null;

        if (! $redirectUrl && isset($response['status']) && (string) $response['status'] === '200') {
            $redirectUrl = $response['url'] ?? null;
        }

        return [
            'status' => 'pending',
            'merchant_reference' => $transactionId,
            'provider_transaction_id' => $response['transaction_id'] ?? $response['transactionId'] ?? null,
            'provider_reference' => $response['reference_number'] ?? $response['referenceNumber'] ?? null,
            'redirect_url' => $redirectUrl,
            'raw' => $response,
        ];
    }

    public function query(string $merchantReference): array
    {
        $url = config('services.beem.bpay_status_url');
        if (! $url) {
            return [
                'status' => 'pending',
                'provider_transaction_id' => null,
                'provider_reference' => null,
                'raw' => ['message' => 'Beem BPay status endpoint is not configured; wait for the Beem webhook.'],
            ];
        }

        $response = $this->request($url, ['reference_number' => $merchantReference, 'transaction_id' => $merchantReference]);
        $status = $this->normalizeStatus($response);

        return [
            'status' => $status,
            'provider_transaction_id' => $response['transaction_id'] ?? $response['transactionId'] ?? null,
            'provider_reference' => $response['reference_number'] ?? $response['referenceNumber'] ?? null,
            'raw' => $response,
        ];
    }

    private function request(string $url, array $payload): array
    {
        $apiKey = config('services.beem.api_key');
        $secretKey = config('services.beem.secret_key');
        if (! $apiKey || ! $secretKey) {
            throw new \RuntimeException('BEEM_API_KEY and BEEM_SECRET_KEY are required for Beem BPay.');
        }

        return Http::timeout((int) config('services.beem.bpay_timeout', 30))
            ->withBasicAuth($apiKey, $secretKey)
            ->acceptJson()
            ->post($url, $payload)
            ->throw()
            ->json();
    }

    public function normalizeWebhook(array $data): array
    {
        $successful = filter_var($data['successful'] ?? false, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        $status = $successful === true ? 'paid' : ($successful === false ? 'failed' : 'pending');

        return [
            'status' => $status,
            'transaction_id' => $data['transaction_id'] ?? $data['remote_transaction_id'] ?? null,
            'reference_number' => $data['reference_number'] ?? null,
            'amount' => $data['amount_collected'] ?? null,
            'phone' => $data['subscriber_msisdn'] ?? null,
            'network' => $data['network_name'] ?? null,
            'raw' => $data,
        ];
    }

    private function normalizeStatus(array $response): string
    {
        $status = strtolower((string) ($response['status'] ?? $response['payment_status'] ?? 'pending'));
        if (in_array($status, ['paid', 'success', 'successful', 'completed', 'complete'], true)) return 'paid';
        if (in_array($status, ['failed', 'failure', 'cancelled', 'canceled', 'rejected'], true)) return 'failed';
        return 'pending';
    }
}
