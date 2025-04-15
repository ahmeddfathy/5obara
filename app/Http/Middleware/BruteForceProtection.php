<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class BruteForceProtection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): SymfonyResponse
    {
        // تحقق مما إذا كانت محاولة تسجيل دخول
        if (($request->is('login') || $request->route() && $request->route()->uri == 'login') && $request->isMethod('post')) {
            $email = $request->input('email');
            $ipAddress = $request->ip();

            // مفتاح فريد لتتبع محاولات تسجيل الدخول (الإيميل + آي بي)
            $key = $this->generateKey($email, $ipAddress);

            // عدد المحاولات الفاشلة
            $attempts = Cache::get($key, 0);

            // الحد الأقصى للمحاولات
            $maxAttempts = 3; // تقليل عدد المحاولات المسموح بها

            // مدة الحظر بالدقائق
            $decayMinutes = 5;

            // زيادة مدة الحظر تدريجياً
            if ($attempts >= $maxAttempts) {
                // مضاعفة فترة الحظر مع كل زيادة في المحاولات
                $multiplier = floor($attempts / $maxAttempts);
                $decayMinutes = $decayMinutes * ($multiplier + 1);

                // الحد الأقصى للحظر هو 24 ساعة
                $decayMinutes = min($decayMinutes, 1440);

                // تسجيل محاولة اختراق في السجل
                \Illuminate\Support\Facades\Log::warning('محاولة اختراق محتملة', [
                    'email' => $email,
                    'ip' => $ipAddress,
                    'attempts' => $attempts,
                    'user_agent' => $request->header('User-Agent')
                ]);

                // استجابة JSON للطلبات AJAX
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'error' => 'تم تجاوز الحد الأقصى من المحاولات',
                        'message' => 'تم إيقاف الحساب مؤقتاً بسبب محاولات متعددة لتسجيل الدخول. يرجى المحاولة مرة أخرى بعد ' . $decayMinutes . ' دقيقة.'
                    ], 429);
                }

                // استجابة HTML للطلبات العادية
                // إعادة التوجيه إلى صفحة تسجيل الدخول مع رسالة خطأ
                return redirect()->route('login')
                    ->withErrors(['email' => 'تم إيقاف الحساب مؤقتاً بسبب محاولات متعددة لتسجيل الدخول. يرجى المحاولة مرة أخرى بعد ' . $decayMinutes . ' دقيقة.']);
            }

            // تسجيل استجابة الوسيط التالي
            $response = $next($request);

            // إذا فشل تسجيل الدخول (رمز الاستجابة ليس تحويلًا ناجحًا)
            if (!($response instanceof \Illuminate\Http\RedirectResponse && $response->getStatusCode() === 302)) {
                // زيادة عدد المحاولات
                Cache::put($key, $attempts + 1, now()->addMinutes($decayMinutes));

                // تسجيل محاولة الوصول الفاشلة في السجل
                \Illuminate\Support\Facades\Log::warning('فشل محاولة تسجيل الدخول', [
                    'email' => $email,
                    'ip' => $ipAddress,
                    'attempts' => $attempts + 1,
                    'user_agent' => $request->header('User-Agent')
                ]);
            } else {
                // إعادة تعيين العداد عند نجاح تسجيل الدخول
                Cache::forget($key);
            }

            return $response;
        }

        return $next($request);
    }

    /**
     * إنشاء مفتاح تشفير فريد لعنوان البريد الإلكتروني وعنوان IP
     */
    protected function generateKey(string $email, string $ip): string
    {
        return 'login_attempts:' . md5($email . $ip);
    }
}
