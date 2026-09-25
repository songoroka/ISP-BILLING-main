<?php

namespace App\Services\Beem;

use Illuminate\Support\Facades\Http;

class BeemSmsService
{
    public function send(string $recipient, string $message, ?string $senderId = null): BeemSmsResponse
    {
        try {
            $recipient = $this->normalizePhone($recipient);
        } catch (\Throwable $e) {
            return new BeemSmsResponse(false, $e->getMessage());
        }
        $senderId = $senderId ?: config('services.beem.sms_sender_id');

        if (! $senderId) {
            return new BeemSmsResponse(false, 'BEEM_SMS_SENDER_ID is not configured.');
        }

        $apiKey = config('services.beem.api_key');
        $secretKey = config('services.beem.secret_key');
        if (! $apiKey || ! $secretKey) {
            return new BeemSmsResponse(false, 'BEEM_API_KEY and BEEM_SECRET_KEY are required for Beem SMS.');
        }

        $payload = [
            'source_addr' => $senderId,
            'encoding' => 0,
            'schedule_time' => '',
            'message' => $message,
            'recipients' => [
                [
                    'recipient_id' => '1',
                    'dest_addr' => $recipient,
                ],
            ],
        ];

        try {
            $response = Http::timeout((int) config('services.beem.sms_timeout', 30))
                ->withBasicAuth($apiKey, $secretKey)
                ->acceptJson()
                ->post(config('services.beem.sms_url', 'https://apisms.beem.africa/v1/send'), $payload);

            $data = $response->json() ?: [];
            $successful = $response->successful() && (bool) ($data['successful'] ?? false);

            return new BeemSmsResponse(
                $successful,
                (string) ($data['message'] ?? ($successful ? 'Message submitted successfully.' : 'Beem SMS request failed.')),
                $data,
            );
        } catch (\Throwable $e) {
            report($e);
            return new BeemSmsResponse(false, $e->getMessage());
        }
    }

    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D+/', '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '255'.substr($phone, 1);
        }
        if (! str_starts_with($phone, '255')) {
            throw new \InvalidArgumentException('Tanzania mobile number must use 255XXXXXXXXX format.');
        }
        return $phone;
    }
}
