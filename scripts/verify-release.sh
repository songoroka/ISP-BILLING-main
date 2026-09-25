#!/usr/bin/env bash
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT"

command -v php >/dev/null || { echo "ERROR: PHP is not installed."; exit 1; }
php -v | head -n 1

if [[ ! -f .env ]]; then
  echo "WARNING: .env is missing. Create it from .env.example before production."
fi

php artisan --version
php artisan route:list >/tmp/skytech-route-list.txt
php artisan config:clear >/dev/null
php artisan view:clear >/dev/null

for required in \
  public/images/skytech-infranet-logo.png \
  public/images/skytech-login-network.jpg \
  resources/views/filament/pages/auth/login.blade.php \
  docs/API.md; do
  [[ -f "$required" ]] || { echo "ERROR: missing $required"; exit 1; }
done

echo "SKYTECH INFRANET release checks completed."
