# AzamPesa / AzamPay Integration

SKYTECH INFRANET now includes an `azampesa` provider in the common Tanzania payment engine.

## Supported flow

1. Customer/API requests payment with `provider=azampesa`.
2. SKYTECH creates a unique merchant reference.
3. AzamPay access token is obtained and cached.
4. SKYTECH submits an AzamPay MNO checkout request for provider `Azampesa`.
5. The payment remains pending until callback or status confirmation.
6. The callback/status result is checked against the expected amount.
7. A confirmed payment is recorded and passed to the existing billing success flow.
8. Existing duplicate protection prevents the same payment from being finalized twice.

## Configuration

Required credentials:

- `AZAMPAY_APP_NAME`
- `AZAMPAY_CLIENT_ID`
- `AZAMPAY_CLIENT_SECRET`

Default sandbox endpoints are configurable through `.env` or the Main Site Setup payment settings.

## Webhooks

Web routes:

- `POST /payment/tanzania/azampesa/webhook`

API route:

- `POST /api/v1/payment/azampesa/webhook`

Set `AZAMPAY_WEBHOOK_SECRET` if the merchant account/provider configuration supplies a shared webhook secret.

## REST API

Use the existing authenticated endpoint:

`POST /api/v1/payments`

with:

```json
{
  "customer_unique_id": "CUSTOMER-ID",
  "amount": 25000,
  "provider": "azampesa",
  "phone": "2557XXXXXXXX"
}
```

## Important

Use the sandbox credentials and endpoints for testing first. Before production, replace them with the live credentials and exact live URLs issued for the SKYTECH merchant account.
