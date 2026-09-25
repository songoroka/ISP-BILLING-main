<?php

use App\Http\Middleware\CheckSiteStatus;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(function ($request) {
            $host = $request->getHost();

            if (str_starts_with($host, 'reseller.')) {
                return route('filament.reseller.auth.login');
            }

            if (str_starts_with($host, 'demo.')) {
                return route('filament.demo.auth.login');
            }

            if (str_starts_with($host, 'hotel.')) {
                return route('hotel.login');
            }

            return route('filament.portal.auth.login');
        });
        $middleware->web(append: [
            \App\Http\Middleware\SetLocaleFromSession::class,
        ]);
        $middleware->append(CheckSiteStatus::class);
        $middleware->alias([
            'reseller'           => \App\Http\Middleware\EnsureUserIsReseller::class,
            'force.portal.password' => \App\Http\Middleware\ForcePortalPasswordChange::class,
            'demo.access'        => \App\Http\Middleware\EnsureDemoAccess::class,
            'restrict.profile'   => \App\Http\Middleware\RestrictToProfileIfNoPermissions::class,
            'hotel.portal'       => \App\Http\Middleware\RestrictHotelUserPortal::class,
            'permission'         => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role'               => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            '/payment/bkash/callback',
            '/payment/nagad/callback',
            '/payment/sslcommerz/callback',
            '/payment/mock/submit',
            '/payment/tanzania/selcom/webhook',
            '/payment/tanzania/mpesa/webhook',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
