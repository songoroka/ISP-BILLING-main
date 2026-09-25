<?php

namespace App\Services\Payments;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * AzamPay / AzamPesa Tanzania gateway adapter.
 *
 * Uses AzamPay's MNO checkout flow for AzamPesa. All URLs and credentials
 * are configurable so sandbox/live account details can be changed without
 * changing billing logic.
 */
class AzamPesaGateway implements TanzaniaPaymentGateway
{
    public function initiate(array $payment): array
    {
        $token = $this->accessToken();
        $url = $this->url(siteUrlSettings('payment_azampesa_checkout_path') ?: config('services.azampay.mno_checkout_path', '/azampay/mno/checkout'));
        $externalId = $payment['merchant_reference'];

        $payload = [
            'accountNumber' => $payment['phone'],
            'additionalProperties' => new \stdClass(),
            'amount' => (string) (int) round($payment['amount']),
            'currency' => 'TZS',
            'externalId' => $externalId,
            'provider' => siteUrlSettings('payment_azampesa_provider') ?: config('services.azampay.mno_provider', 'Azampesa'),
        ];

        $response = Http::timeout((int) config('services.azampay.timeout', 30))
            ->withToken($token)
            ->acceptJson()
            ->post($url, $payload)
            ->throw()
            ->json();

        $success = filter_var($response['success'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $providerTx = $response['transactionId']
            ?? $response['data']['transactionId']
            ?? $response['data']['pgReferenceId']
            ?? $response['pgReferenceId']
            ?? null;

        return [
            'status' => $success ? 'pending' : 'failed',
            'merchant_reference' => $externalId,
            'provider_transaction_id' => $providerTx,
            'provider_reference' => $response['data']['referenceId'] ?? $response['referenceId'] ?? null,
            'redirect_url' => null,
            'raw' => $response,
        ];
    }

    public function query(string $merchantReference): array
    {
        $token = $this->accessToken();
        $url = $this->url(siteUrlSettings('payment_azampesa_status_path') ?: config('services.azampay.transaction_status_path', '/azampay/gettransactionstatus'));

        $response = Http::timeout((int) config('services.azampay.timeout', 30))
            ->withToken($token)
            ->acceptJson()
            ->get($url, [
                'bankName' => siteUrlSettings('payment_azampesa_provider') ?: config('services.azampay.mno_provider', 'Azampesa'),
                'pgReferenceId' => $merchantReference,
            ])
            ->throw()
            ->json();

        return [
            'status' => $this->normalizeStatus($response),
            'provider_transaction_id' => $response['transactionId'] ?? $response['data']['transactionId'] ?? $response['pgReferenceId'] ?? null,
            'provider_reference' => $response['referenceId'] ?? $response['data']['referenceId'] ?? null,
            'raw' => $response,
        ];
    }

    public function normalizeWebhook(array $data): array
    {
        $success = filter_var(
            data_get($data, 'success', data_get($data, 'successful', data_get($data, 'data.success'))),
            FILTER_VALIDATE_BOOLEAN,
            FILTER_NULL_ON_FAILURE
        );
        $statusText = strtoupper((string) (
            data_get($data, 'status')
            ?? data_get($data, 'paymentStatus')
            ?? data_get($data, 'data.status')
            ?? ''
        ));

        $status = $success === true || in_array($statusText, ['SUCCESS','SUCCESSFUL','COMPLETE','COMPLETED','PAID'], true)
            ? 'paid'
            : ($success === false || in_array($statusText, ['FAILED','FAIL','CANCELLED','CANCELED','REJECTED'], true) ? 'failed' : 'pending');

        return [
            'status' => $status,
            'transaction_id' => data_get($data, 'transactionId') ?? data_get($data, 'data.transactionId') ?? data_get($data, 'pgReferenceId'),
            'reference' => data_get($data, 'referenceId') ?? data_get($data, 'externalId') ?? data_get($data, 'data.externalId'),
            'merchant_reference' => data_get($data, 'externalId') ?? data_get($data, 'data.externalId') ?? data_get($data, 'referenceId'),
            'amount' => data_get($data, 'amount') ?? data_get($data, 'data.amount'),
            'phone' => data_get($data, 'accountNumber') ?? data_get($data, 'data.accountNumber'),
            'raw' => $data,
        ];
    }

    private function accessToken(): string
    {
        $appName = siteUrlSettings('payment_azampesa_app_name') ?: config('services.azampay.app_name');
        $clientId = siteUrlSettings('payment_azampesa_client_id') ?: config('services.azampay.client_id');
        $clientSecret = siteUrlSettings('payment_azampesa_client_secret') ?: config('services.azampay.client_secret');
        if (!$appName || !$clientId || !$clientSecret) {
            throw new \RuntimeException('AZAMPAY_APP_NAME, AZAMPAY_CLIENT_ID and AZAMPAY_CLIENT_SECRET are required.');
        }

        $cacheKey = 'azampay_access_token_' . sha1($appName.'|'.$clientId);
        return Cache::remember($cacheKey, now()->addMinutes(25), function () use ($appName, $clientId, $clientSecret) {
            $authUrl = rtrim(siteUrlSettings('payment_azampesa_auth_base_url') ?: config('services.azampay.auth_base_url'), '/') . '/' . ltrim(siteUrlSettings('payment_azampesa_token_path') ?: config('services.azampay.token_path', '/AppRegistration/GenerateToken'), '/');
            $response = Http::timeout((int) config('services.azampay.timeout', 30))
                ->acceptJson()
                ->post($authUrl, [
                    'appName' => $appName,
                    'clientId' => $clientId,
                    'clientSecret' => $clientSecret,
                ])
                ->throw()
                ->json();

            $token = $response['data']['accessToken'] ?? $response['accessToken'] ?? null;
            if (!$token) throw new \RuntimeException('AzamPay access token was not returned.');
            return $token;
        });
    }

    private function url(string $path): string
    {
        return rtrim(siteUrlSettings('payment_azampesa_api_base_url') ?: config('services.azampay.api_base_url'), '/') . '/' . ltrim($path, '/');
    }

    private function normalizeStatus(array $response): string
    {
        $success = filter_var($response['success'] ?? $response['data']['success'] ?? null, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        $status = strtoupper((string) ($response['status'] ?? $response['paymentStatus'] ?? $response['data']['status'] ?? ''));
        if ($success === true || in_array($status, ['SUCCESS','SUCCESSFUL','COMPLETE','COMPLETED','PAID'], true)) return 'paid';
        if ($success === false || in_array($status, ['FAILED','FAIL','CANCELLED','CANCELED','REJECTED'], true)) return 'failed';
        return 'pending';
    }
}
