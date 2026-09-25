# Tanzania Mobile Money Billing Integration

This project now contains a Tanzania-oriented payment layer for ISP bill collection. It keeps the existing billing engine and adds provider adapters for Selcom and Vodacom M-Pesa Tanzania.

## Internal flow

Customer Portal → Pay Bill → Provider Adapter → Mobile Money Prompt → Webhook/Status Query → `payment_transactions` → `PaymentService` → `collection_summaries` + `billing_infos` → MikroTik activation.

## Selcom

The Selcom adapter follows the documented signed-request model and supports mobile-money initiation, status query and webhook handling. Selcom's current developer documentation describes `Authorization`, `Digest-Method`, `Digest`, `Timestamp` and `Signed-Fields` headers and the `/v1/checkout/initiate-pos-payment` and `/v1/checkout/pos-payment-status` checkout endpoints.

Official references:
- https://developers.selcommobile.com/
- https://developer.selcom.business/

## Vodacom M-Pesa Tanzania

The adapter targets the Vodacom M-Pesa Open API Tanzania market (`vodacomTZN`) using the C2B single-stage flow, session key caching, transaction status querying and webhook handling. The exact production credentials and environment paths must come from the M-Pesa Open API portal/merchant onboarding.

The project defaults to the sandbox market paths and keeps all paths configurable.

## Important production notes

- Do not commit API keys, API secrets or private keys.
- Use HTTPS for the portal and webhook endpoints.
- Configure the provider's required IP allowlist / callback security.
- Test duplicate callbacks: the same successful transaction must not create a second collection.
- Test amount mismatch, failed, pending and timeout cases.
- Confirm production endpoint paths and credentials with the provider before enabling live payments.


## Beem Africa BPay + SMS

The project also supports Beem Africa for Tanzania billing workflows. Beem's official mobile-payments documentation describes BPay as a payment-collection API: a merchant requests a bill-pay number, integrates the BPay API, and receives real-time payment notifications. The callback payload includes fields such as `transaction_id`, `amount_collected`, `subscriber_msisdn`, `reference_number`, `paybill_number`, and `network_name`.

The Laravel integration adds:
- `beem_bpay` as a payment provider in the billing/payment transaction layer.
- Beem BPay callback handling at `/payment/tanzania/beem-bpay/webhook` (and the API equivalent `/api/v1/payment/beem/bpay/webhook`).
- Amount validation and duplicate-safe finalization through the existing `PaymentService`.
- Optional Beem checkout/status URLs through `.env`; Beem supplies the exact merchant endpoints during onboarding.
- Beem SMS for bill reminders, payment confirmations, disconnection alerts, support-ticket replies and bulk SMS.

Beem SMS uses the documented endpoint `https://apisms.beem.africa/v1/send` with the Beem API key/secret and configured Sender ID.

Production setup:
1. Create/activate the Beem merchant account and BPay product.
2. Obtain `BEEM_API_KEY` and `BEEM_SECRET_KEY`.
3. Obtain/approve the SKYTECH Sender ID for SMS.
4. Obtain the BPay/Checkout endpoint(s) supplied for the merchant account and set `BEEM_BPAY_CHECKOUT_URL` and, if provided, `BEEM_BPAY_STATUS_URL`.
5. Configure the Beem BPay callback URL to `https://portal.skytech.it.com/payment/tanzania/beem-bpay/webhook`.
6. Configure `BEEM_WEBHOOK_SECRET` if your Beem account supports a callback secret and configure the same secret on the Beem side.
7. Run migrations and test pending, paid, failed, amount-mismatch and duplicate-callback cases before production.

Official references: https://beem.africa/mobile-payments-api/ and https://beem.africa/sms-api/
