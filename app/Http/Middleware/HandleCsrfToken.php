<?php

namespace App\Http\Middleware;

use App\Models\CsrfSession;
use Closure;
use Illuminate\Http\Request;
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
        $csrfToken = $request->header('X-CSRF-TOKEN');

        if (!$csrfToken) {
            return response()->json([
                'status' => false,
                'statusCode' => 419,
                'message' => 'CSRF token mismatch.'
            ], 419);
        } else {
            $decryptedToken = Crypt::decryptString($csrfToken);
            $csrf = CsrfSession::where('csrf_token', $decryptedToken)->first();
            if (!$csrf) {
                return response()->json([
                    'status' => false,
                    'statusCode' => 419,
                    'message' => 'CSRF token not valid.'
                ], 419);
            } else {
                $csrf->update(['usage' => (int)$csrf->usage + 1]);
                return $response;
            }
        }
    }
}
