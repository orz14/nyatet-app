<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\HttpFoundation\Response;

class HandleCsrfToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            $cache_name = 'csrf_' . str_replace('.', '', $request->ip());
            $cachedData = Cache::get($cache_name);
            $csrfToken = $request->header('X-CSRF-TOKEN');

            if (!$cachedData || !$csrfToken) {
                return response()->json([
                    'status' => false,
                    'statusCode' => 419,
                    'message' => 'CSRF token mismatch.'
                ], 419);
            }

            $decryptedToken = Crypt::decryptString($csrfToken);
            if ($decryptedToken != $cachedData['csrf_token']) {
                return response()->json([
                    'status' => false,
                    'statusCode' => 419,
                    'message' => 'CSRF token not valid.'
                ], 419);
            }

            $cachedData['usage'] += 1;
            Cache::put($cache_name, $cachedData, Carbon::now()->addDays(1));
        }
        return $response;
    }
}
