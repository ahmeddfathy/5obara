<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class CredentialLeakProtection
{
    /**
     * قائمة بالكلمات المفتاحية الحساسة التي يجب مراقبتها وإخفائها
     */
    protected $sensitiveKeywords = [
        'password', 'pass', 'secret', 'credential', 'token', 'api_key', 'apikey',
        'key', 'auth', 'authorization', 'pwd', 'كلمة_المرور', 'كلمة_السر', 'المرور',
        'credit_card', 'card_number', 'cvv', 'cvc', 'expiry', 'ssn', 'social_security',
        'passport', 'license', 'private_key', 'secret_key'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // إجراء الطلب الأصلي
        $response = $next($request);

        // فحص الاستجابة لإخفاء أي معلومات حساسة
        $this->sanitizeResponse($response);

        // تأمين JSON في الاستجابة
        if ($response->headers->get('Content-Type') === 'application/json') {
            $content = $response->getContent();
            $sanitizedContent = $this->sanitizeJson($content);
            $response->setContent($sanitizedContent);
        }

        // تأمين HTML في الاستجابة
        if (Str::contains($response->headers->get('Content-Type') ?? '', 'text/html')) {
            $content = $response->getContent();
            $sanitizedContent = $this->sanitizeHtml($content);
            $response->setContent($sanitizedContent);
        }

        return $response;
    }

    /**
     * إخفاء البيانات الحساسة في استجابات JSON
     */
    private function sanitizeJson(string $content): string
    {
        if (empty($content)) {
            return $content;
        }

        try {
            $data = json_decode($content, true);

            if (!is_array($data)) {
                return $content;
            }

            $sanitized = $this->sanitizeArray($data);
            return json_encode($sanitized);
        } catch (\Exception $e) {
            // إذا حدث خطأ في معالجة JSON، عد بالمحتوى الأصلي
            return $content;
        }
    }

    /**
     * تنظيف مصفوفة من البيانات الحساسة
     */
    private function sanitizeArray(array $data): array
    {
        foreach ($data as $key => $value) {
            // إذا كان المفتاح يتضمن كلمات حساسة
            if ($this->isSensitiveKey($key)) {
                if (is_string($value) && !empty($value)) {
                    $data[$key] = '[REDACTED]';
                }
            } elseif (is_array($value)) {
                // التكرار للمصفوفات المتداخلة
                $data[$key] = $this->sanitizeArray($value);
            }
        }

        return $data;
    }

    /**
     * إخفاء البيانات الحساسة في استجابات HTML
     * ملاحظة: هذا أسلوب بسيط قد لا يغطي جميع الحالات
     */
    private function sanitizeHtml(string $content): string
    {
        // إخفاء قيم حقول كلمات المرور المعروضة (أحيانًا تظهر في إعادة الطباعة للنماذج)
        $pattern = '/<input[^>]*type=["\']password["\'][^>]*value=["\'](.*?)["\']/i';
        $replacement = '<input type="password" value="[REDACTED]"';

        return preg_replace($pattern, $replacement, $content);
    }

    /**
     * تنظيف هيكل الاستجابة من البيانات الحساسة
     */
    private function sanitizeResponse(Response $response): void
    {
        // إزالة الرؤوس الحساسة إن وجدت
        $sensitiveHeaders = ['Authorization', 'X-API-Key', 'X-Auth-Token'];

        foreach ($sensitiveHeaders as $header) {
            if ($response->headers->has($header)) {
                $response->headers->set($header, '[REDACTED]');
            }
        }

        // تأكد من عدم تخزين البيانات الحساسة في ذاكرة التخزين المؤقت
        if ($this->containsSensitiveData($response)) {
            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
        }
    }

    /**
     * التحقق من وجود بيانات حساسة في الاستجابة
     */
    private function containsSensitiveData(Response $response): bool
    {
        $content = $response->getContent();

        foreach ($this->sensitiveKeywords as $keyword) {
            if (Str::contains(strtolower($content), strtolower($keyword))) {
                return true;
            }
        }

        return false;
    }

    /**
     * التحقق مما إذا كان المفتاح يحتوي على كلمات حساسة
     */
    private function isSensitiveKey(string $key): bool
    {
        $lowerKey = strtolower($key);

        foreach ($this->sensitiveKeywords as $keyword) {
            if (Str::contains($lowerKey, strtolower($keyword))) {
                return true;
            }
        }

        return false;
    }
}
