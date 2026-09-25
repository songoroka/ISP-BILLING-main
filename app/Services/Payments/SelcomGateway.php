<?php

namespace App\Services\Payments;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SelcomGateway implements TanzaniaPaymentGateway
{
    public function initiate(array $payment): array
    {
        $transid = $payment['merchant_reference'];
        $payload = [
            'transid' => $transid,
            'currency' => 'TZS',
            'amount' => (string) (int) round($payment['amount']),
            'payment_method' => 'MOBILEMONEY',
            'msisdn' => $payment['phone'],
            'invoice_no' => $transid,
        ];

        $response = $this->request('POST', siteUrlSettings('payment_selcom_initiate_path') ?: config('services.selcom.initiate_path', '/v1/checkout/initiate-pos-payment'), $payload);
        return $this->normalize($response, $transid);
    }

    public function query(string $merchantReference): array
    {
        $response = $this->request('GET', siteUrlSettings('payment_selcom_status_path') ?: config('services.selcom.status_path', '/v1/checkout/pos-payment-status'), ['invoice_no' => $merchantReference]);
        return $this->normalize($response, $merchantReference);
    }

    private function request(string $method, string $path, array $payload): array
    {
        $timestamp = now()->format('Y-m-d\TH:i:sP');
        $signedFields = implode(',', array_keys($payload));
        $signing = 'timestamp='.$timestamp;
        foreach ($payload as $key => $value) { $signing .= '&'.$key.'='.$value; }
        $algorithm = strtoupper(siteUrlSettings('payment_selcom_digest_method') ?: config('services.selcom.digest_method', 'HS256'));
        if ($algorithm === 'RS256') {
            $privateKey = siteUrlSettings('payment_selcom_private_key') ?: config('services.selcom.private_key');
            if (!$privateKey) throw new \RuntimeException('SELCOM_PRIVATE_KEY is required for RS256.');
            openssl_sign($signing, $signature, $privateKey, OPENSSL_ALGO_SHA256);
            $digest = base64_encode($signature);
        } else {
            $digest = base64_encode(hash_hmac('sha256', $signing, siteUrlSettings('payment_selcom_api_secret') ?: config('services.selcom.api_secret'), true));
        }
        $headers = [
            'Authorization' => 'SELCOM '.base64_encode(siteUrlSettings('payment_selcom_api_key') ?: config('services.selcom.api_key')),
            'Digest-Method' => $algorithm,
            'Digest' => $digest,
            'Timestamp' => $timestamp,
            'Signed-Fields' => $signedFields,
            'Accept' => 'application/json',
        ];
        $url = rtrim(siteUrlSettings('payment_selcom_base_url') ?: config('services.selcom.base_url'), '/').'/'.ltrim($path, '/');
        $request = Http::timeout((int) config('services.selcom.timeout', 30))->withHeaders($headers);
        return $method === 'GET' ? $request->get($url, $payload)->throw()->json() : $request->post($url, $payload)->throw()->json();
    }

    private function normalize(array $response, string $merchantReference): array
    {
        $result = strtoupper((string)($response['result'] ?? ''));
        $code = (string)($response['resultcode'] ?? '');
        $data = is_array($response['data'] ?? null) ? ($response['data'][0] ?? []) : [];
        $status = match (true) {
            $result === 'SUCCESS' || $code === '000' => 'paid',
            in_array($result, ['INPROGRESS','PENDING']) || in_array($code, ['111','927','999']) => 'pending',
            in_array($result, ['CANCELLED','USERCANCELED','REJECTED','FAIL']) => 'failed',
            default => 'pending',
        };
        return [
            'status' => $status,
            'merchant_reference' => $merchantReference,
            'provider_transaction_id' => $data['transid'] ?? $response['transid'] ?? null,
            'provider_reference' => $data['reference'] ?? $response['reference'] ?? null,
            'redirect_url' => null,
            'raw' => $response,
        ];
    }
}
