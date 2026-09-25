# SKYTECH INFRANET — Updated Deployment Plan

## Day 1 — Pre-Deployment Preparation

1. Confirm Ubuntu 24.04 LTS, 4 CPU, 7–8 GB RAM and swap.
2. Point all domains/subdomains to the VPS.
3. Obtain production credentials for M-Pesa Tanzania, Selcom, AzamPesa/AzamPay and Beem as required.
4. Prepare SSL certificates.
5. Create the production database and database user.
6. Upload the updated project package.
7. Confirm the deployment package includes the Hotel migration and updated settings panel.

## Day 1–2 — Server Setup & Security

1. Update Ubuntu packages.
2. Install PHP 8.3+, required PHP extensions, Composer, Nginx, Node.js and Git.
3. Configure UFW for SSH/HTTP/HTTPS.
4. Create a non-root deployment user and correct application ownership.
5. Configure timezone, hostname, PHP limits and swap.
6. Enable Fail2Ban where appropriate.
7. Disable unnecessary services.
8. Schedule security updates and database backups.

## Day 2–3 — Application Installation

1. Upload/extract the project.
2. Configure `.env` with database, mail, application URL and core infrastructure values.
3. Install PHP dependencies with Composer.
4. Install/build frontend assets.
5. Configure Nginx for `skytech.it.com`, `portal.skytech.it.com`, `demo.skytech.it.com` and the dedicated Hotel workspace `hotel.skytech.it.com`.
6. Run:

```bash
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan optimize
```

7. Verify that the `Hotel User` role and hotel permissions exist.
8. Verify that the `api_integrations` setting exists.

## Day 3 — SSL & Domains

Configure and verify:

- `https://skytech.it.com`
- `https://portal.skytech.it.com`
- `https://demo.skytech.it.com`
- `https://hotel.skytech.it.com` — dedicated Hotel User workspace

Confirm valid TLS certificates and DNS records.

## Day 3–4 — Super Admin System Configuration

### Branding

1. Open **Site Settings → Theme & Colors**.
2. Keep the default SKYTECH blue/green palette or select a custom palette.
3. Upload logo/favicon assets.
4. Configure company and portal information.

### Flexible APIs

Open **Site Settings → API Integrations** and add required providers.

For each provider configure:

- Name
- Integration key
- Base URL
- Authentication
- API credentials
- Headers
- Endpoint paths
- Webhook details
- Enabled state

Use HTTPS for production endpoints.

### Payment gateways

Configure dedicated M-Pesa, Selcom, AzamPesa/AzamPay, Beem and any existing gateway settings using the provider credentials.

## Day 4 — Hotel Module Configuration

1. Open **Site Settings → Hotel Module**.
2. Enter the hotel name and official address.
3. Enter phone/email/website.
4. Enter registration/licence number if applicable.
5. Upload the hotel voucher logo.
6. Set the voucher prefix, for example `HTL-`.
7. Set voucher footer text.
8. Save the configuration.

### Create Hotel User

1. Open **Admin → Users**.
2. Create the hotel staff account.
3. Assign **Hotel User** as the standalone role.
4. Only Super Admin should perform this assignment.
5. Verify that the account is redirected to `https://hotel.skytech.it.com/hotel/guests` after login.
6. Verify that the account sees only the Hotel workspace and not ISP billing menus.

## Day 4–5 — Integration Testing

Test:

- M-Pesa payment initiation/status/webhook
- Selcom payment flow/webhook
- AzamPesa/AzamPay flow/webhook
- Beem SMS delivery
- MikroTik connection and synchronization
- Custom API registry configuration
- API authentication and endpoint resolution

## Day 5–6 — Hotel Acceptance Testing

Test with a non-production Hotel User:

1. Login to the portal.
2. Open `https://hotel.skytech.it.com` and confirm it redirects to the Hotel Guest workspace.
3. Register a guest.
4. Verify voucher number generation.
5. Search the guest by name/document/room/phone.
6. Edit a guest record.
7. Print the voucher / open PDF.
8. Verify hotel name, logo, address and contacts on the voucher.
9. Confirm there are no billing/payment menus in the Hotel User workspace.
10. Confirm Hotel User cannot assign roles or modify hotel settings.
11. Confirm unauthorized users receive HTTP 403 for hotel routes.

## Day 6–7 — Security & QA

1. Test all roles and permissions.
2. Test portal password-change rules.
3. Test domain access and SSL.
4. Test API credentials and webhook verification.
5. Review application, authentication and router logs.
6. Test backup and restore.
7. Run application tests and PHP syntax checks.
8. Confirm production `.env` is not publicly accessible.

## Day 7 — Go-Live

1. Create a final database/files backup.
2. Put the application into production mode.
3. Run cache/config/route optimization.
4. Confirm queue workers and scheduler are active.
5. Monitor payment and SMS logs.
6. Monitor server CPU/RAM/disk.
7. Confirm hotel voucher printing from the production portal.
8. Officially open the portal.

## Ongoing Support

- 24/7 system monitoring as agreed.
- Regular database and file backups.
- Payment/SMS delivery monitoring.
- User activity and security log review.
- API credential rotation when required.
- Hotel voucher configuration changes through Super Admin settings.
- Training for Super Admin, Admin, Reseller and Hotel User staff.

## Success Criteria

- All configured domains have valid SSL.
- ISP billing/payment integrations operate correctly.
- SMS notifications operate correctly.
- MikroTik integrations operate correctly.
- Super Admin can add/configure API integrations from the settings panel.
- Hotel users can access the dedicated `hotel.skytech.it.com` workspace, register guests and print vouchers.
- Hotel users cannot access billing functionality.
- Hotel voucher identity matches the hotel information configured by Super Admin.
- Role/permission boundaries are enforced.
- Backups, logs and security controls are operational.
