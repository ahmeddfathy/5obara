<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // أساسيات الأمان
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // سياسة أمان المحتوى - محسّنة
        $cspDirectives = [
            "default-src 'self'",
            "script-src 'self' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://cdn.quilljs.com https://www.gstatic.com https://*.gstatic.com https://*.googleapis.com https://firebase.googleapis.com 'unsafe-inline'",
            "style-src 'self' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://fonts.googleapis.com https://cdn.quilljs.com 'unsafe-inline'",
            "img-src 'self' data: blob:",
            "font-src 'self' https://fonts.gstatic.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://cdn.quilljs.com",
            "connect-src 'self' https://*.googleapis.com https://*.firebase.googleapis.com https://*.gstatic.com https://fcm.googleapis.com",
            "media-src 'self'",
            "object-src 'none'",
            "frame-src 'self' https://www.google.com https://*.google.com https://*.gstatic.com",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'self'",
        ];
        $response->headers->set('Content-Security-Policy', implode('; ', $cspDirectives));

        // حماية ضد التتبع وسياسات الخصوصية
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), interest-cohort=()');

        // منع كشف معلومات الخادم
        $response->headers->set('Server', '');
        $response->headers->set('X-Powered-By', '');

        // ختم HSTS لإجبار اتصالات HTTPS
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');

        // حماية ضد هجمات MIME Sniffing
        $response->headers->set('X-Download-Options', 'noopen');

        // سياسة أصول عبر المواقع المختلفة
        $response->headers->set('Cross-Origin-Embedder-Policy', 'unsafe-none');
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');
        $response->headers->set('Cross-Origin-Resource-Policy', 'cross-origin');

        return $response;
    }
}
