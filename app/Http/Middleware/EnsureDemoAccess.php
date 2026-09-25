<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDemoAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        if ($user->hasRole('Super Admin') || $user->demo_access) {
            return $next($request);
        }

        abort(403, 'Demo access has not been enabled for this account.');
    }
}
