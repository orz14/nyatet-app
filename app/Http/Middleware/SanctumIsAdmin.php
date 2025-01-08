<?php

namespace App\Http\Middleware;

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
            return response()->json([
                'status' => false,
                'statusCode' => 403,
                'message' => 'Anda Tidak Memiliki Akses.'
            ], 403);
        }

        return $next($request);
    }
}
