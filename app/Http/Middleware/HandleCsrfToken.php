<?php

namespace App\Http\Middleware;

use App\Helpers\Generate;
use App\Helpers\Response as HelpersResponse;
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
            $get_fingerprint = $request->header('Fingerprint_');
            $cache_name = "csrf_$get_fingerprint";
            $cachedData = Cache::get($cache_name);
            $csrfToken = $request->header('X-CSRF-TOKEN');

            if (!$cachedData || !$csrfToken) {
                return HelpersResponse::error('CSRF token mismatch.', null, 419);
            }

            try {
                $decryptedToken = Crypt::decryptString($csrfToken);
            } catch (\Exception $err) {
                Log::error($err->getMessage());

                return HelpersResponse::error('CSRF token invalid.', null, 419);
            }

            if ($decryptedToken != $cachedData['csrf_token']) {
                return HelpersResponse::error('CSRF token invalid.', null, 419);
            }
        }
        return $next($request);
    }

    public function terminate($request, $response)
    {
        if ((env('APP_ENV') != 'local') && in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            $get_fingerprint = $request->header('Fingerprint_');
            $cache_name = "csrf_$get_fingerprint";

            Cache::put($cache_name, [
                'csrf_token' => Generate::randomString(32)
            ], Carbon::now()->addDays(1));
        }
    }
}
