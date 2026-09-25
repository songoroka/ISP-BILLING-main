# SKYTECH INFRANET — AzamPesa Update

Added AzamPesa / AzamPay Tanzania support to the common payment engine.

### Added
- `AzamPesaGateway` provider adapter.
- Access-token generation and cache.
- AzamPesa MNO checkout.
- Transaction status checking.
- Webhook/callback processing with amount validation.
- Duplicate-safe final payment processing through the existing billing service.
- REST API provider `azampesa`.
- Web and API webhook routes.
- Main Site Setup configuration panel.
- `.env.example` variables.
- AzamPesa payment option in the existing payment view.
- Integration documentation.

### Existing providers preserved
- Selcom
- Vodacom M-Pesa Tanzania
- Beem BPay
- Beem SMS

### Verification
- Modified PHP files pass `php -l` syntax validation.
- Full live payment testing still requires valid AzamPay sandbox/production merchant credentials.
