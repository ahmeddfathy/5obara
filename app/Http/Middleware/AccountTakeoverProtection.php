<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AccountTakeoverProtection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('login') && $request->isMethod('post')) {
            // تخزين بيانات الطلب للفحص
            $email = $request->input('email');
            $ipAddress = $request->ip();
            $userAgent = $request->header('User-Agent');
            $country = $this->getCountryFromIP($ipAddress);

            // مفتاح فريد للمستخدم
            $userKey = 'user_profile:' . md5($email);

            // مراقبة النمط المعتاد للمستخدم
            $userProfile = Cache::get($userKey, [
                'ips' => [],
                'user_agents' => [],
                'countries' => [],
                'last_login_at' => null,
                'successful_logins' => 0
            ]);

            // تسجيل استجابة الوسيط التالي
            $response = $next($request);

            // التحقق مما إذا كان تسجيل الدخول ناجحًا
            if ($response instanceof \Illuminate\Http\RedirectResponse && $response->getStatusCode() === 302) {
                // المستخدم تم تسجيل دخوله بنجاح

                // فحص إذا كان هناك سلوك غير طبيعي
                $suspicious = $this->detectSuspiciousActivity($userProfile, $ipAddress, $userAgent, $country);

                // إذا كان السلوك مشبوهًا جدًا، اتخذ إجراءً
                if ($suspicious > 0.7) {
                    // تسجيل الحدث
                    Log::warning('محاولة اختطاف حساب محتملة', [
                        'email' => $email,
                        'ip' => $ipAddress,
                        'user_agent' => $userAgent,
                        'country' => $country,
                        'confidence' => $suspicious
                    ]);

                    // لاحظ - خيارات الحماية:
                    // 1. إجراء خفيف: طلب تحقق إضافي (مثل OTP أو رمز تحقق)
                    // 2. إجراء متوسط: تقييد وصول المستخدم إلى وظائف حساسة
                    // 3. إجراء شديد: إجبار تسجيل الخروج وطلب إعادة تعيين كلمة المرور

                    // هنا تنفذ الإجراء المناسب - مثال للإجراء الخفيف:
                    if ($suspicious > 0.9) {
                        // تسجيل الخروج للمستخدم في حالة الشك القوي
                        Auth::logout();

                        // إعادة التوجيه إلى صفحة تسجيل الدخول مع رسالة
                        return redirect()->route('login')
                            ->with('warning', 'تم اكتشاف نشاط مشبوه في حسابك. الرجاء إعادة تسجيل الدخول وتأكيد هويتك.');
                    }
                }

                // تحديث ملف تعريف المستخدم بعد تسجيل الدخول الناجح
                $this->updateUserProfile($userProfile, $ipAddress, $userAgent, $country);
                Cache::put($userKey, $userProfile, now()->addMonths(3)); // الاحتفاظ بالملف الشخصي لمدة 3 أشهر
            }

            return $response;
        }

        return $next($request);
    }

    /**
     * اكتشاف النشاط المشبوه بناءً على سلوك المستخدم السابق
     * يعيد قيمة بين 0 و 1 تمثل مستوى الشك
     */
    private function detectSuspiciousActivity(array $userProfile, string $ip, string $userAgent, string $country): float
    {
        // إذا كان هذا أول تسجيل دخول، فلا يمكن اعتباره مشبوهًا
        if (empty($userProfile['ips']) || $userProfile['successful_logins'] < 3) {
            return 0;
        }

        $suspiciousScore = 0;

        // التحقق من عنوان IP
        if (!in_array($ip, $userProfile['ips'])) {
            $suspiciousScore += 0.4;
        }

        // التحقق من وكيل المستخدم
        $foundSimilarUserAgent = false;
        foreach ($userProfile['user_agents'] as $knownUserAgent) {
            if (similar_text($knownUserAgent, $userAgent) / strlen($userAgent) > 0.8) {
                $foundSimilarUserAgent = true;
                break;
            }
        }
        if (!$foundSimilarUserAgent) {
            $suspiciousScore += 0.3;
        }

        // التحقق من البلد
        if (!in_array($country, $userProfile['countries'])) {
            $suspiciousScore += 0.5;
        }

        // التحقق من وقت تسجيل الدخول (إذا كان وقت غير عادي)
        if ($userProfile['last_login_at']) {
            $lastLoginTime = new \DateTime($userProfile['last_login_at']);
            $currentTime = new \DateTime();
            $hourDiff = abs($lastLoginTime->format('H') - $currentTime->format('H'));

            // إذا كان الوقت مختلفًا كثيرًا عن آخر تسجيل دخول
            if ($hourDiff > 12) {
                $suspiciousScore += 0.2;
            }
        }

        return min(1, $suspiciousScore); // ضمان عدم تجاوز القيمة 1
    }

    /**
     * تحديث ملف تعريف المستخدم بعد تسجيل الدخول الناجح
     */
    private function updateUserProfile(array &$userProfile, string $ip, string $userAgent, string $country): void
    {
        // تحديث قائمة عناوين IP (حفظ آخر 5 عناوين)
        if (!in_array($ip, $userProfile['ips'])) {
            $userProfile['ips'][] = $ip;
            $userProfile['ips'] = array_slice($userProfile['ips'], -5);
        }

        // تحديث قائمة وكلاء المستخدم (حفظ آخر 5)
        if (!in_array($userAgent, $userProfile['user_agents'])) {
            $userProfile['user_agents'][] = $userAgent;
            $userProfile['user_agents'] = array_slice($userProfile['user_agents'], -5);
        }

        // تحديث قائمة البلدان (حفظ آخر 3)
        if (!in_array($country, $userProfile['countries'])) {
            $userProfile['countries'][] = $country;
            $userProfile['countries'] = array_slice($userProfile['countries'], -3);
        }

        // تحديث وقت آخر تسجيل دخول
        $userProfile['last_login_at'] = now()->toDateTimeString();

        // زيادة عدد عمليات تسجيل الدخول الناجحة
        $userProfile['successful_logins']++;
    }

    /**
     * الحصول على رمز البلد من عنوان IP
     * هذه نسخة بسيطة - في الإنتاج استخدم خدمة GeoIP حقيقية
     */
    private function getCountryFromIP(string $ip): string
    {
        // في بيئة الإنتاج الفعلية، استخدم خدمة GeoIP
        // مثال: geoip()->getLocation($ip)->iso_code
        // لأغراض هذا المثال، نعود ببساطة برمز البلد الافتراضي
        return 'EG'; // مصر كمثال
    }
}
