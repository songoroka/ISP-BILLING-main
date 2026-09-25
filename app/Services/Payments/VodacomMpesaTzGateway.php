<?php

namespace App\Services\Payments;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class VodacomMpesaTzGateway implements TanzaniaPaymentGateway
{
    public function initiate(array $payment): array
    {
        $session = $this->sessionKey();
        $payload = [
            'input_Amount' => (string) (int) round($payment['amount']),
            'input_Country' => 'TZN',
            'input_Currency' => 'TZS',
            'input_CustomerMSISDN' => $payment['phone'],
            'input_ServiceProviderCode' => $this->setting('payment_mpesa_tz_service_provider_code', 'service_provider_code'),
            'input_ThirdPartyConversationID' => $payment['merchant_reference'],
            'input_TransactionReference' => $payment['merchant_reference'],
            'input_PurchasedItemsDesc' => 'ISP Internet Bill',
        ];
        $url = $this->url($this->setting('payment_mpesa_tz_c2b_path', 'c2b_path'));
        $response = Http::timeout((int) config('services.mpesa_tz.timeout', 30))
            ->withHeaders($this->authHeaders($session))
            ->acceptJson()->post($url, $payload)->throw()->json();
        return $this->normalize($response, $payment['merchant_reference']);
    }

    public function query(string $merchantReference): array
    {
        $session = $this->sessionKey();
        $payload = [
            'input_QueryReference' => $merchantReference,
            'input_ServiceProviderCode' => $this->setting('payment_mpesa_tz_service_provider_code', 'service_provider_code'),
            'input_ThirdPartyConversationID' => $merchantReference,
            'input_Country' => 'TZN',
        ];
        $url = $this->url($this->setting('payment_mpesa_tz_query_path', 'query_path'));
        $response = Http::timeout((int) config('services.mpesa_tz.timeout', 30))
            ->withHeaders($this->authHeaders($session))->acceptJson()->get($url, $payload)->throw()->json();
        return $this->normalize($response, $merchantReference);
    }

    private function sessionKey(): string
    {
        $cacheKey = 'mpesa_tz_session_key_'.md5((string)$this->setting('payment_mpesa_tz_api_key', 'api_key'));
        return Cache::remember($cacheKey, now()->addMinutes(20), function () {
            $apiKey = $this->setting('payment_mpesa_tz_api_key', 'api_key');
            $publicKey = $this->setting('payment_mpesa_tz_public_key', 'public_key');
            if (!$apiKey || !$publicKey) throw new \RuntimeException('M-Pesa Tanzania API key and public key are required.');
            $encryptedApiKey = $this->rsaEncrypt($apiKey, $publicKey);
            $response = Http::timeout((int) config('services.mpesa_tz.timeout', 30))
                ->withHeaders(['Authorization' => 'Bearer '.$encryptedApiKey, 'Origin' => $this->setting('payment_mpesa_tz_origin', 'origin') ?: '*'])
                ->acceptJson()->get($this->url($this->setting('payment_mpesa_tz_session_path', 'session_path')))->throw()->json();
            $session = $response['output_SessionID'] ?? $response['SessionID'] ?? null;
            if (!$session) throw new \RuntimeException('Vodacom M-Pesa session key was not returned.');
            return $session;
        });
    }

    private function authHeaders(string $session): array
    {
        $publicKey = $this->setting('payment_mpesa_tz_public_key', 'public_key');
        return [
            'Authorization' => 'Bearer '.$this->rsaEncrypt($session, $publicKey),
            'Origin' => $this->setting('payment_mpesa_tz_origin', 'origin') ?: '*',
        ];
    }

    private function rsaEncrypt(string $value, string $publicKey): string
    {
        $encrypted = '';
        $key = $publicKey;
        if (!str_contains($key, 'BEGIN')) $key = "-----BEGIN PUBLIC KEY-----\n".chunk_split(preg_replace('/\s+/', '', $key), 64, "\n")."-----END PUBLIC KEY-----";
        if (!openssl_public_encrypt($value, $encrypted, $key, OPENSSL_PKCS1_PADDING)) {
            throw new \RuntimeException('Unable to encrypt M-Pesa Open API credential.');
        }
        return base64_encode($encrypted);
    }

    private function url(?string $path): string
    {
        return rtrim($this->setting('payment_mpesa_tz_base_url', 'base_url'), '/').'/'.ltrim((string)$path, '/');
    }

    private function setting(string $siteKey, string $configKey): ?string
    {
        return siteUrlSettings($siteKey) ?: config('services.mpesa_tz.'.$configKey);
    }

    private function normalize(array $response, string $merchantReference): array
    {
        $code = strtoupper((string)($response['output_ResponseCode'] ?? $response['ResponseCode'] ?? ''));
        $statusText = strtoupper((string)($response['output_ResponseTransactionStatus'] ?? $response['ResponseTransactionStatus'] ?? ''));
        $success = $code === 'INS-0' || in_array($statusText, ['COMPLETED','SUCCESS'], true);
        $failed = in_array($statusText, ['FAILED','FAIL','CANCELLED','REJECTED'], true);
        return [
            'status' => $success ? 'paid' : ($failed ? 'failed' : 'pending'),
            'merchant_reference' => $merchantReference,
            'provider_transaction_id' => $response['output_TransactionID'] ?? $response['TransactionID'] ?? $response['output_OriginalTransactionID'] ?? null,
            'provider_reference' => $response['output_ThirdPartyConversationID'] ?? $response['ThirdPartyConversationID'] ?? null,
            'redirect_url' => null,
            'raw' => $response,
        ];
    }
}
