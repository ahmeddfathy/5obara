<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SuspiciousBehaviorDetection
{
    /**
     * قائمة بأنماط الطلبات المشبوهة
     */
    protected $suspiciousPatterns = [
        '/eval\(/i',
        '/system\(/i',
        '/exec\(/i',
        '/passthru\(/i',
        '/base64_decode\(/i',
        '/gzinflate\(/i',
        '/PHNjcmlwdD/i', // <script مشفر بنظام base64
        '/document\.write\(/i',
        '/execCommand\(/i',
        '/\.\.\/\.\.\/\.\.\//i', // محاولات تجاوز المسار
        '/\/etc\/passwd/i',
        '/SELECT\s+.*\s+FROM/i', // أنماط SQL قد تكون مشبوهة في بعض السياقات
        '/UNION\s+SELECT/i',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // توليد معرف فريد للمستخدم
        $userIdentifier = md5($request->ip() . ($request->header('User-Agent') ?? ''));

        // سجل أنماط الاستخدام والطلبات
        $this->trackUserBehavior($request, $userIdentifier);

        // فحص محتوى الطلب للبحث عن أنماط مشبوهة
        if ($this->containsSuspiciousPatterns($request)) {
            $this->blockRequest($request);
            return response('تم اكتشاف سلوك مشبوه. تم منع طلبك.', 403);
        }

        // فحص معدل الطلبات للكشف عن السلوك المشبوه
        if ($this->hasAbnormalRequestRate($userIdentifier)) {
            $this->limitRequests($userIdentifier);
            return response('تجاوزت الحد الأقصى من الطلبات. الرجاء المحاولة لاحقًا.', 429);
        }

        // مراقبة تسلسل الطلبات غير العادية
        if ($this->hasAbnormalRequestSequence($userIdentifier, $request)) {
            Log::warning('تم اكتشاف تسلسل طلبات غير طبيعي', [
                'ip' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                'path' => $request->path(),
                'request_sequence' => Cache::get('request_sequence:' . $userIdentifier, [])
            ]);
        }

        return $next($request);
    }

    /**
     * تتبع سلوك المستخدم وأنماط الطلبات
     */
    private function trackUserBehavior(Request $request, string $userIdentifier): void
    {
        $requestPath = $request->path();
        $requestTime = now()->getTimestamp();

        // تخزين آخر 10 طلبات للمستخدم
        $requestSequence = Cache::get('request_sequence:' . $userIdentifier, []);
        $requestSequence[] = [
            'path' => $requestPath,
            'method' => $request->method(),
            'timestamp' => $requestTime
        ];

        // الاحتفاظ بآخر 10 طلبات فقط
        if (count($requestSequence) > 10) {
            $requestSequence = array_slice($requestSequence, -10);
        }

        Cache::put('request_sequence:' . $userIdentifier, $requestSequence, now()->addHours(1));

        // تخزين عدد الطلبات في فترة زمنية
        $minuteKey = 'requests_per_minute:' . $userIdentifier;
        $hourKey = 'requests_per_hour:' . $userIdentifier;

        $requestsPerMinute = Cache::get($minuteKey, 0);
        $requestsPerHour = Cache::get($hourKey, 0);

        Cache::put($minuteKey, $requestsPerMinute + 1, now()->addMinute());
        Cache::put($hourKey, $requestsPerHour + 1, now()->addHour());
    }

    /**
     * التحقق من معدل الطلبات غير الطبيعي
     */
    private function hasAbnormalRequestRate(string $userIdentifier): bool
    {
        $requestsPerMinute = Cache::get('requests_per_minute:' . $userIdentifier, 0);
        $requestsPerHour = Cache::get('requests_per_hour:' . $userIdentifier, 0);

        // عتبات لاعتبار معدل الطلبات غير طبيعي
        // يمكن تعديل هذه القيم حسب طبيعة التطبيق
        $maxRequestsPerMinute = 60; // مثال: حد أقصى 60 طلب في الدقيقة
        $maxRequestsPerHour = 500; // مثال: حد أقصى 500 طلب في الساعة

        return $requestsPerMinute > $maxRequestsPerMinute || $requestsPerHour > $maxRequestsPerHour;
    }

    /**
     * فحص تسلسل الطلبات غير العادية
     */
    private function hasAbnormalRequestSequence(string $userIdentifier, Request $request): bool
    {
        $requestSequence = Cache::get('request_sequence:' . $userIdentifier, []);

        // إذا كان عدد الطلبات قليلًا جدًا، لا يمكننا تحديد نمط
        if (count($requestSequence) < 5) {
            return false;
        }

        // فحص لمحاولات تخمين المسارات
        return $this->detectPathGuessing($requestSequence);
    }

    /**
     * اكتشاف محاولات تخمين المسارات
     */
    private function detectPathGuessing(array $requestSequence): bool
    {
        $adminPaths = 0;
        $apiPaths = 0;
        $restrictedPaths = 0;

        foreach ($requestSequence as $request) {
            $path = $request['path'];

            // عد طلبات المسارات الإدارية
            if (Str::startsWith($path, 'admin') || Str::contains($path, '/admin/')) {
                $adminPaths++;
            }

            // عد طلبات API
            if (Str::startsWith($path, 'api') || Str::contains($path, '/api/')) {
                $apiPaths++;
            }

            // عد طلبات المسارات المقيدة
            if (Str::contains($path, ['config', 'settings', 'users', 'login', 'password'])) {
                $restrictedPaths++;
            }
        }

        // إذا كان المستخدم يحاول الوصول إلى العديد من المسارات الإدارية أو المقيدة
        // في فترة زمنية قصيرة، فقد يكون ذلك مؤشرًا على محاولة الاستكشاف
        return ($adminPaths > 3 || $apiPaths > 5 || $restrictedPaths > 4);
    }

    /**
     * فحص محتوى الطلب للبحث عن أنماط مشبوهة
     */
    private function containsSuspiciousPatterns(Request $request): bool
    {
        // جمع جميع المدخلات بما في ذلك المتغيرات والـ JSON
        $inputs = $request->all();
        $inputString = json_encode($inputs);

        // فحص في عنوان URL والمدخلات
        $url = $request->fullUrl();

        foreach ($this->suspiciousPatterns as $pattern) {
            if (preg_match($pattern, $url) || preg_match($pattern, $inputString)) {
                // تسجيل الحدث المشبوه
                Log::warning('تم اكتشاف نمط مشبوه في الطلب', [
                    'pattern' => $pattern,
                    'url' => $url,
                    'ip' => $request->ip(),
                    'user_agent' => $request->header('User-Agent')
                ]);

                return true;
            }
        }

        return false;
    }

    /**
     * تقييد الطلبات للمستخدم المشبوه
     */
    private function limitRequests(string $userIdentifier): void
    {
        // زيادة وقت التقييد مع كل محاولة متكررة
        $blockCount = Cache::get('block_count:' . $userIdentifier, 0);
        $blockDuration = min(60 * 24, 15 * pow(2, $blockCount)); // زيادة مدة الحظر تصاعديًا (بالدقائق)

        Cache::put('blocked:' . $userIdentifier, true, now()->addMinutes($blockDuration));
        Cache::put('block_count:' . $userIdentifier, $blockCount + 1, now()->addHours(24));

        Log::warning('تم تقييد طلبات المستخدم بسبب معدل طلبات غير طبيعي', [
            'user_identifier' => $userIdentifier,
            'block_duration' => $blockDuration . ' minutes',
            'block_count' => $blockCount + 1
        ]);
    }

    /**
     * حظر الطلب وتسجيل معلوماته
     */
    private function blockRequest(Request $request): void
    {
        Log::warning('تم حظر طلب مشبوه', [
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'inputs' => $request->all()
        ]);
    }
}
