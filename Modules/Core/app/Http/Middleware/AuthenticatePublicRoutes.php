<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Container\Attributes\Config;
use Illuminate\Http\Request;

final class AuthenticatePublicRoutes
{
    public function __construct(
        #[Config('auth.public-token')] private string $publicToken,
        #[Config('auth.public-token-header')] private string $publicTokenHeader,
    ) {}

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $headers = $request->headers;

        if (!$headers->has($this->publicTokenHeader)) {
            return api()->forbidden('Public token is required');
        }

        if ($headers->get($this->publicTokenHeader) !== $this->publicToken) {
            return api()->forbidden('Public token is required');
        }

        return $next($request);
    }
}
