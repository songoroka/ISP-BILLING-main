# SKYTECH INFRANET — Portal, Roles & Domains

## Production domains

- `https://skytech.it.com` — public homepage and public site content.
- `https://portal.skytech.it.com` — administrative portal for Super Admin, Admin and Reseller accounts.
- `https://hotel.skytech.it.com` — dedicated Hotel User workspace for guest registration and voucher printing only.
- `https://demo.skytech.it.com` — controlled demo portal. Super Admin enables demo access per user.

The old `billing.*` administrative domain is no longer the primary portal domain.

## Roles

### Super Admin

- Full system access.
- Manages Admin users and system permissions.
- Adds/removes/configures MikroTik routers.
- Monitors router/traffic/log operations.
- Creates and manages resellers.
- Assigns reseller permissions and packages.
- Can enter any active reseller account using **Access Reseller Portal**.
- Can enable/disable a user's demo access.

### Admin

- Full operational access to the ISP system using the complete permission set.
- Can operate customer/service/billing/payment modules, MikroTik configuration, reports, site settings and operational support modules.
- Cannot assign or edit the Super Admin role.

### Reseller

- Access is limited to permissions selected by Super Admin.
- Reseller customer records remain system records used by billing, PPPoE and service management; this is not a customer login panel.
- The reseller portal shows SKYTECH INFRANET first, followed by the reseller company/name and contact information.

## Reseller first-login password

When Super Admin creates a reseller, the account is marked `must_change_password = true`.

The reseller can sign in using the supplied initial password, but is redirected to the portal password-change page before accessing operational pages. If Super Admin resets the reseller password later, the same forced-change rule is applied again.

## Customer panel removal

The PPP customer-facing Filament panel has been retired. Customer records, PPPoE secrets, billing, payments, vouchers and service data remain in the application because they are core ISP records managed by Admin/Reseller operations.

Public payment callbacks/webhooks and voucher redemption routes remain where required for payment processing.

## Help Desk

- `+255622221464`
- `+255754448446`

These are stored as the site Help Desk contact and used by the public/support-facing templates.

## Demo access

Super Admin can enable **Demo Portal Access** for a web user. Only users explicitly granted `demo_access` (plus Super Admin) can enter the demo host.
