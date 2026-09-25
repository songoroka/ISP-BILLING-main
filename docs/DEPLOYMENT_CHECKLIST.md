# SKYTECH INFRANET — Deployment Checklist

## Before upload
- [ ] PHP 8.3+ is installed.
- [ ] MySQL/MariaDB is available.
- [ ] Nginx or Apache is configured with the Laravel `public/` directory as the document root.
- [ ] HTTPS certificate is installed.
- [ ] `.env` contains production values and a unique `APP_KEY`.
- [ ] Selcom and Vodacom M-Pesa Tanzania credentials are supplied separately and are not committed to Git/ZIP.

## After upload
```bash
composer install --no-dev --optimize-autoloader
cp .env.example .env   # only if .env does not already exist
php artisan key:generate
php artisan storage:link
php artisan migrate --force
php artisan optimize:clear
php artisan optimize
```

Set permissions for Laravel runtime directories:
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

## Frontend assets
If this deployment builds assets on the server:
```bash
npm ci
npm run build
```
If a pre-built `public/build` directory is supplied by the release process, do not rebuild unnecessarily.

## Login branding
- `public/images/skytech-infranet-logo.png` — official SKYTECH INFRANET logo supplied for this release.
- `public/images/skytech-login-network.jpg` — network/router visual used by the custom login page.
- `resources/views/filament/pages/auth/login.blade.php` — responsive two-column login UI.
- Authentication remains username/PPPoE based; the visual redesign does not change credential validation.

## API
Base URL:
```text
https://YOUR-DOMAIN/api/v1
```
Use the API documentation in `docs/API.md` and the Postman collection in `docs/postman/`.

## Payment providers
Configure provider credentials and callback URLs in the environment/settings before testing:
- Selcom
- Vodacom M-Pesa Tanzania

Run sandbox tests for:
- successful payment
- failed payment
- pending payment
- duplicate callback
- invalid signature/token
- amount mismatch
- status query

## Security release note
The source package contained an obfuscated runtime `eval()` payload in two application files. Those payloads were removed from this release because they are not required by Laravel/Filament application functionality and should not execute hidden code during application boot/request handling.


## Hotel subdomain

- DNS A record: `hotel.skytech.it.com` → VPS public IP.
- Nginx `server_name`: `hotel.skytech.it.com`.
- Include `hotel.skytech.it.com` in the production TLS certificate.
- Confirm Hotel User login redirects to `https://hotel.skytech.it.com/hotel/guests`.
