<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvestmentFormMail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;

class InvestmentController extends Controller
{
    public function submit(Request $request)
    {
        try {
            // التحقق من محدودية عدد الطلبات من نفس IP
            $ipAddress = $request->ip();
            if (RateLimiter::tooManyAttempts('investment-form:'.$ipAddress, 3)) {
                $seconds = RateLimiter::availableIn('investment-form:'.$ipAddress);
                return back()->with('investment_error', 'لقد أرسلت العديد من الطلبات. الرجاء المحاولة مرة أخرى بعد '.$seconds.' ثانية.')
                            ->withInput();
            }

            RateLimiter::hit('investment-form:'.$ipAddress, 60*30); // 30 دقيقة

            // التحقق من honeypot (فخ للروبوتات)
            if ($request->filled('website_field')) {
                // وهمي - إذا تم ملؤه فهو على الأرجح روبوت
                return back()->with('investment_success', 'تم إرسال طلب الاستثمار بنجاح! سنتواصل معك قريباً.');
            }

            // وقت التقديم لمنع الإرسال التلقائي
            $submissionTimestamp = $request->input('_timestamp', 0);
            if (time() - $submissionTimestamp < 3) { // أقل من 3 ثوانٍ = مشبوه
                return back()->with('investment_error', 'الرجاء التأكد من إدخال جميع البيانات بشكل صحيح قبل الإرسال.')
                            ->withInput();
            }

            // Validate the form data
            $validated = $request->validate([
                'name' => 'required|string|max:255|regex:/^[\p{L}\s\-\.\']+$/u', // يسمح فقط بالأحرف والمسافات
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20|regex:/^[0-9\+\-\(\)\s]+$/', // يسمح فقط بأرقام الهاتف الصالحة
                'investment_amount' => 'required|string|max:255',
                'form_type' => 'required|string|in:استثمار,شراكة,تمويل', // قيم محددة فقط
            ]);

            // تنظيف البيانات المدخلة
            $validated['name'] = strip_tags($validated['name']);
            $validated['email'] = filter_var($validated['email'], FILTER_SANITIZE_EMAIL);
            $validated['investment_amount'] = strip_tags($validated['investment_amount']);

            // Add source information to the form data
            $validated['source'] = 'فورم الاستثمار - الصفحة الرئيسية';
            $validated['source_url'] = url('/');
            $validated['submission_time'] = now()->format('Y-m-d H:i:s');
            $validated['ip_address'] = $request->ip(); // تخزين IP للتتبع الأمني

            // تسجيل طلب الاستثمار للمراجعة الأمنية
            Log::info('Investment form submission', [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'amount' => $validated['investment_amount'],
                'ip' => $ipAddress
            ]);

            // Send the email
            Mail::to('ahmeddfathy087@gmail.com')
                ->send(new InvestmentFormMail($validated));

            // Redirect back with success message
            return back()->with('investment_success', 'تم إرسال طلب الاستثمار بنجاح! سنتواصل معك قريباً.');

        } catch (\Exception $e) {
            // تسجيل الخطأ
            Log::error('Error in investment form submission', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => $request->ip()
            ]);

            // إعادة التوجيه مع رسالة خطأ
            return back()->with('investment_error', 'حدث خطأ أثناء إرسال طلب الاستثمار. يرجى المحاولة مرة أخرى لاحقاً.')
                         ->withInput();
        }
    }
}
