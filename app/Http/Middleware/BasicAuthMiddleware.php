<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BasicAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // بيانات المصادقة المحددة مسبقًا
        $username = env('BASIC_AUTH_USERNAME', 'khobara');
        $password = env('BASIC_AUTH_PASSWORD', 'admin2025');

        if ($request->getUser() != $username || $request->getPassword() != $password) {
            $headers = ['WWW-Authenticate' => 'Basic'];
            return response('غير مصرح بالدخول', 401, $headers);
        }

        return $next($request);
    }
}
