<?php

namespace App\Services;

use App\Models\MainSiteData;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class ConfigurableApiService
{
    /**
     * Build a request for an integration configured by Super Admin.
     * The integration is stored in MainSiteData::api_integrations so a new
     * provider can be added without a code deployment.
     */
    public function request(string $integrationKey, string $endpoint = 'default'): PendingRequest
    {
        $integration = collect(MainSiteData::getValue('api_integrations', []))
            ->first(fn (array $item) => ($item['key'] ?? null) === $integrationKey && filter_var($item['enabled'] ?? false, FILTER_VALIDATE_BOOL));

        if (! $integration) {
            throw new RuntimeException("API integration [{$integrationKey}] is not configured or disabled.");
        }

        $baseUrl = rtrim((string) ($integration['base_url'] ?? ''), '/');
        $endpoints = $this->decodeJson($integration['endpoints'] ?? '{}');
        $path = $endpoints[$endpoint] ?? ($endpoint === 'default' ? '' : $endpoint);

        $request = Http::baseUrl($baseUrl)->acceptJson();

        $headers = $this->decodeJson($integration['headers'] ?? '{}');
        if (is_array($headers) && $headers) {
            $request = $request->withHeaders($headers);
        }

        return $this->applyAuthentication($request, $integration);
    }

    public function url(string $integrationKey, string $endpoint = 'default'): string
    {
        $integration = collect(MainSiteData::getValue('api_integrations', []))
            ->first(fn (array $item) => ($item['key'] ?? null) === $integrationKey);

        if (! $integration) {
            throw new RuntimeException("API integration [{$integrationKey}] is not configured.");
        }

        $baseUrl = rtrim((string) ($integration['base_url'] ?? ''), '/');
        $endpoints = $this->decodeJson($integration['endpoints'] ?? '{}');
        $path = $endpoints[$endpoint] ?? ($endpoint === 'default' ? '' : $endpoint);

        return $baseUrl.'/'.ltrim((string) $path, '/');
    }

    protected function applyAuthentication(PendingRequest $request, array $integration): PendingRequest
    {
        $type = strtolower((string) ($integration['auth_type'] ?? 'none'));
        $key = (string) ($integration['api_key'] ?? '');
        $secret = (string) ($integration['api_secret'] ?? '');
        $header = (string) ($integration['auth_header'] ?? 'Authorization');

        return match ($type) {
            'bearer' => $request->withToken($key),
            'basic' => $request->withBasicAuth($key, $secret),
            'api_key' => $request->withHeaders([$header => $key]),
            'custom_header' => $request->withHeaders([$header => $key]),
            default => $request,
        };
    }

    protected function decodeJson(mixed $value): array
    {
        if (is_array($value)) {
            return $value;
        }

        $decoded = json_decode((string) $value, true);

        return is_array($decoded) ? $decoded : [];
    }
}
