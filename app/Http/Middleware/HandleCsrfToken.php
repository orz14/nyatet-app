<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
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
        if ((env('APP_ENV') != 'local') && in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            $get_ip = $request->header('User-Ip') ?? $request->ip();
            $cache_name = 'csrf_' . str_replace(['.', '='], '', $get_ip);
            $cachedData = Cache::get($cache_name);
            $csrfToken = $request->header('X-CSRF-TOKEN');

            if (!$cachedData || !$csrfToken) {
                return response()->json([
                    'status' => false,
                    'statusCode' => 419,
                    'message' => 'CSRF token mismatch.'
                ], 419);
            }

            try {
                $decryptedToken = Crypt::decryptString($csrfToken);
            } catch (\Exception $err) {
                Log::error($err->getMessage());

                return response()->json([
                    'status' => false,
                    'statusCode' => 419,
                    'message' => 'CSRF token invalid.'
                ], 419);
            }

            if ($decryptedToken != $cachedData['csrf_token']) {
                return response()->json([
                    'status' => false,
                    'statusCode' => 419,
                    'message' => 'CSRF token invalid.'
                ], 419);
            }

            $cachedData['usage'] += 1;
            Cache::put($cache_name, $cachedData, Carbon::now()->addDays(1));
        }
        return $next($request);
    }
}
