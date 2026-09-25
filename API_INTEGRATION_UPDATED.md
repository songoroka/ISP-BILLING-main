# Flexible API Integration Registry

The SKYTECH INFRANET system now supports a Super Admin-managed API registry in addition to the existing dedicated payment gateways.

## Location

**Portal → Site Settings → API Integrations**

## Configuration fields

| Field | Purpose |
|---|---|
| Provider / API Name | Human-readable provider name |
| Integration Key | Unique key used by application code |
| Base URL | API root URL |
| Authentication | None, Bearer, Basic, API Key Header or Custom Header |
| API Key / Username | Provider key or username |
| API Secret / Password | Provider secret or password |
| Auth Header | Header used by API-key/custom-header authentication |
| Additional Headers | JSON object of extra headers |
| Endpoints | JSON endpoint map |
| Webhook URL | Provider callback destination, if applicable |
| Webhook Secret | Callback verification secret |
| Enabled | Controls whether the integration may be consumed |

## Example

```json
{
  "name": "Example CRM",
  "key": "example_crm",
  "base_url": "https://api.example.com",
  "auth_type": "bearer",
  "api_key": "YOUR_TOKEN",
  "headers": "{\"Accept\":\"application/json\"}",
  "endpoints": "{\"default\":\"/\",\"customers\":\"/v1/customers\"}",
  "enabled": 1
}
```

Application code can use:

```php
$api = app(\App\Services\ConfigurableApiService::class);
$response = $api->request('example_crm', 'customers')->get('');
```

This registry is intentionally generic. Provider-specific payment behavior remains implemented in the dedicated gateway services so existing payment flows are not replaced by a generic abstraction.
