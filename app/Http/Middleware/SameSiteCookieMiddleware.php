<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;

class SameSiteCookieMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Modifikasi cookie XSRF-TOKEN
        if ($response->headers->has('Set-Cookie')) {
            $cookies = $response->headers->getCookies();

            foreach ($cookies as $cookie) {
                if ($cookie->getName() === 'XSRF-TOKEN') {
                    $response->headers->setCookie(
                        new \Symfony\Component\HttpFoundation\Cookie(
                            $cookie->getName(),
                            $cookie->getValue(),
                            $cookie->getExpiresTime(),
                            $cookie->getPath(),
                            $cookie->getDomain(),
                            $cookie->isSecure(),
                            $cookie->isHttpOnly(),
                            false, // Raw
                            'None' // SameSite attribute
                        )
                    );
                }
            }
        }

        return $response;
    }
}
