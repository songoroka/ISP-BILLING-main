<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsReseller
{
    public function handle(Request $request, Closure $next): Response
    {
        $guard = Auth::guard('web');

        if (! $guard->check()) {
            return redirect()->route('filament.reseller.auth.login');
        }

        $user = $guard->user();

        if (
            ! $user->hasRole('Reseller') ||
            ! $user->reseller ||
            ! $user->reseller->isActive()
        ) {
            $guard->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('filament.reseller.auth.login')
                ->with(
                    'error',
                    'Your reseller account is suspended or not initialized.'
                );
        }

        return $next($request);
    }
}
