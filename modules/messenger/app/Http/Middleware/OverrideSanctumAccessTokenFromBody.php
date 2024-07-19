<?php

namespace Modules\messenger\app\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;

class OverrideSanctumAccessTokenFromBody
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Sanctum::getAccessTokenFromRequestUsing(fn ($request) => $request->auth_token);

        return $next($request);
    }
}
