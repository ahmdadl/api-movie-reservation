<?php

namespace Modules\Users\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!auth()->check()) {
            return api()->unauthorized();
        }

        $user = user();

        if (!$user->role->value === $role) {
            return api()->forbidden();
        }

        return $next($request);
    }
}
