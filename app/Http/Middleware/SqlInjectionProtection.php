<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SqlInjectionProtection
{
    /**
     * قائمة أنماط حقن SQL الشائعة للبحث عنها
     *
     * @var array
     */
    protected $patterns = [
        '/\bUNION\b/i',
        '/\bSELECT\b.*\bFROM\b/i',
        '/\bINSERT\b.*\bINTO\b/i',
        '/\bDROP\b.*\bTABLE\b/i',
        '/\bALTER\b.*\bTABLE\b/i',
        '/\bDELETE\b.*\bFROM\b/i',
        '/\bUPDATE\b.*\bSET\b/i',
        '/\bCREATE\b.*\bTABLE\b/i',
        '/\bTRUNCATE\b.*\bTABLE\b/i',
        '/\bEXEC\b/i',
        '/\bOR\b\s+\d+\s*=\s*\d+\b/i',
        '/\'\s+OR\s+[\'"]/i',
        '/;\s*$/',
        '/--\s/i',
        '/\bXOR\b/i',
        '/\/\*.*\*\//i'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // لا نريد تطبيق الحماية على ملفات التحميل
        if ($request->isMethod('post') && $request->hasFile('*')) {
            return $next($request);
        }

        // جمع كل القيم من الطلب
        $inputs = $request->all();

        // التحقق من كل مدخل
        foreach ($inputs as $key => $value) {
            // تجاهل القيم غير النصية
            if (!is_string($value)) {
                continue;
            }

            // التحقق من وجود أنماط حقن SQL
            foreach ($this->patterns as $pattern) {
                if (preg_match($pattern, $value)) {
                    // تسجيل محاولة الحقن
                    \Illuminate\Support\Facades\Log::alert('تم اكتشاف محاولة حقن SQL', [
                        'ip' => $request->ip(),
                        'user_agent' => $request->header('User-Agent'),
                        'uri' => $request->fullUrl(),
                        'input_key' => $key,
                        'input_value' => $value,
                        'pattern_matched' => $pattern
                    ]);

                    // إرجاع استجابة خطأ
                    if (app()->environment('production')) {
                        // في الإنتاج، أظهر رسالة خطأ عامة
                        abort(403, 'تم رفض هذا الطلب لأسباب أمنية.');
                    } else {
                        // في التطوير، أظهر المزيد من التفاصيل
                        abort(403, 'تم اكتشاف نمط حقن SQL في المدخل "' . $key . '"');
                    }
                }
            }
        }

        return $next($request);
    }
}
