<?php

namespace App\Filament\Pages\Auth;

class SuperAdminLogin extends Login
{
    protected string $view = 'filament.pages.auth.super-admin-login';

    protected function getRedirectUrl(): ?string
    {
        $baseDomain = parse_url(config('app.url'), PHP_URL_HOST)
            ?: config('app.url');

        $adminDomain = env(
            'ADMIN_PORTAL_DOMAIN',
            'admin.' . $baseDomain
        );

        return 'https://' . $adminDomain . '/';
    }
}
