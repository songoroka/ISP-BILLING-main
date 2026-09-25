# SKYTECH INFRANET ISP Billing API v1

The application exposes a REST/JSON API that can be consumed by websites, Android/iOS apps, POS systems, CRM/ERP software, accounting systems, reseller platforms, or other ISP software.

## Base URL

Production example:

`https://billing.example.com/api/v1`

All authenticated requests use:

`Authorization: Bearer YOUR_TOKEN`

`Accept: application/json`

## 1. Get an API token

Use an existing billing/admin user account to obtain a Sanctum token:

```http
POST /api/v1/auth/token
Content-Type: application/json
Accept: application/json

{
  "email": "admin@example.com",
  "password": "YOUR_PASSWORD",
  "device_name": "external-erp"
}
```

The response contains `access_token`. Store it securely. Do not put it in browser JavaScript or public source code.

## 2. Endpoints

| Method | Endpoint | Purpose |
|---|---|---|
| GET | `/health` | API health check |
| GET | `/user` | Current API user |
| GET | `/packages` | Internet packages |
| GET | `/customers` | List/search customers |
| GET | `/customers/{customer_unique_id}` | Customer details |
| GET | `/customers/{customer_unique_id}/billing` | Current bill/due information |
| GET | `/customers/{customer_unique_id}/payments` | Payment history |
| POST | `/payments` | Start Selcom or M-Pesa Tanzania payment |
| GET | `/payments/{merchant_reference}` | Get payment transaction |
| POST | `/payments/{merchant_reference}/check` | Query provider and refresh status |
| POST | `/auth/revoke` | Revoke current API token |

## 3. Start a payment

```http
POST /api/v1/payments
Authorization: Bearer YOUR_TOKEN
Content-Type: application/json
Accept: application/json

{
  "customer_unique_id": "CUST000123",
  "amount": 25000,
  "provider": "selcom",
  "phone": "255712345678"
}
```

Supported providers:

- `selcom`
- `mpesa_tz`

The API returns a unique `merchant_reference`. The external application should store this reference and poll the status endpoint or receive provider callbacks through the configured payment integration.

## 4. Check payment

```http
POST /api/v1/payments/ISP260922ABC123/check
Authorization: Bearer YOUR_TOKEN
Accept: application/json
```

When the payment becomes `paid`, the existing billing engine processes it and updates the collection, billing balance, customer status and MikroTik access according to the application's existing rules.

## 5. Customer billing

```http
GET /api/v1/customers/CUST000123/billing
Authorization: Bearer YOUR_TOKEN
Accept: application/json
```

This is suitable for an external mobile app or customer portal that needs to show the current amount due.

## 6. Customer payment history

```http
GET /api/v1/customers/CUST000123/payments?per_page=25
Authorization: Bearer YOUR_TOKEN
Accept: application/json
```

## 7. Search customers

```http
GET /api/v1/customers?search=0712345678&per_page=25
Authorization: Bearer YOUR_TOKEN
Accept: application/json
```

## Security

- API authentication uses Laravel Sanctum bearer tokens.
- API routes are rate-limited at 60 requests/minute per authenticated user/IP.
- Never expose `.env`, payment API secrets, private keys or Sanctum tokens to clients.
- Use HTTPS in production.
- Give external software its own API user/token rather than sharing the main administrator's token.
- Revoke a token immediately when the external integration is decommissioned.

## Deployment

After uploading the project:

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize
php artisan route:list --path=api
```

The external developer can then integrate against `/api/v1` without needing direct database access.

## Example JavaScript

```javascript
const response = await fetch('https://billing.example.com/api/v1/customers/CUST000123/billing', {
  headers: {
    'Authorization': `Bearer ${API_TOKEN}`,
    'Accept': 'application/json'
  }
});

const result = await response.json();
console.log(result.data.billing);
```

## Example cURL

```bash
curl -X GET \
  'https://billing.example.com/api/v1/customers/CUST000123/billing' \
  -H 'Authorization: Bearer YOUR_TOKEN' \
  -H 'Accept: application/json'
```
