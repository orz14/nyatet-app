<?php

namespace App\Http\Middleware;

use App\Helpers\Response as HelpersResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanctumIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check() || $request->user()->role_id != 1) {
            return HelpersResponse::error('Anda Tidak Memiliki Akses.', null, 403);
        }

        return $next($request);
    }
}
