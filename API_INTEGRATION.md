# External Software Integration

This ISP Billing system now exposes a versioned REST API under `/api/v1`.

An external system can authenticate with a Sanctum bearer token and consume customer, billing, package and payment functions without direct database access.

See `docs/API.md` for the full endpoint reference and `docs/postman/SKYTECH-INFRANET-API-v1.postman_collection.json` for a ready-to-import Postman collection.


## AzamPesa / AzamPay (Tanzania)

The payment engine supports `azampesa` as a Tanzania provider. It uses the AzamPay MNO checkout flow, stores the merchant reference and provider transaction ID, supports transaction status checks, and accepts a provider callback at:

`POST /payment/tanzania/azampesa/webhook`

The REST payment endpoint accepts `provider=azampesa`. Configure `AZAMPAY_APP_NAME`, `AZAMPAY_CLIENT_ID`, `AZAMPAY_CLIENT_SECRET`, and the sandbox/live URLs issued for the merchant account.
