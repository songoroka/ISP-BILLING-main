<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictHotelUserPortal
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user?->hasRole('Hotel User')) {
            $path = ltrim($request->path(), '/');
            $allowed = [
                'hotel/guests',
                'change-password',
                'livewire',
                'user/profile',
                'user/profile-information',
                'user/password',
                'user/two-factor-authentication',
                'user/two-factor-qr-code',
                'user/two-factor-recovery-codes',
                'user/confirmed-two-factor-authentication',
                'user/other-browser-sessions',
                'logout',
            ];

            $isAllowed = false;
            foreach ($allowed as $prefix) {
                if ($path === $prefix || str_starts_with($path, $prefix.'/')) {
                    $isAllowed = true;
                    break;
                }
            }

            if (! $isAllowed) {
                return redirect()->route('hotel.guests');
            }
        }

        return $next($request);
    }
}
