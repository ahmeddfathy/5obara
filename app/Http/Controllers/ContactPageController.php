<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ContactPageFormMail;
use Illuminate\Support\Facades\RateLimiter;

class ContactPageController extends Controller
{
    public function submit(Request $request)
    {
        try {
            // التحقق من محدودية عدد الطلبات من نفس IP
            $ipAddress = $request->ip();
            if (RateLimiter::tooManyAttempts('contact-page-form:'.$ipAddress, 5)) {
                $seconds = RateLimiter::availableIn('contact-page-form:'.$ipAddress);
                return back()->with('contact_error', 'لقد أرسلت العديد من الرسائل. الرجاء المحاولة مرة أخرى بعد '.$seconds.' ثانية.')
                            ->withInput();
            }

            RateLimiter::hit('contact-page-form:'.$ipAddress, 60*10); // 10 دقائق

            // التحقق من honeypot (فخ للروبوتات)
            if ($request->filled('website_field')) {
                // وهمي - إذا تم ملؤه فهو على الأرجح روبوت
                return back()->with('contact_success', 'تم إرسال رسالتك بنجاح! سنقوم بالتواصل معك قريباً.');
            }

            // وقت التقديم لمنع الإرسال التلقائي
            $submissionTimestamp = $request->input('_timestamp', 0);
            if (time() - $submissionTimestamp < 3) { // أقل من 3 ثوانٍ = مشبوه
                return back()->with('contact_error', 'الرجاء التأكد من إدخال جميع البيانات بشكل صحيح قبل الإرسال.')
                            ->withInput();
            }

            // التحقق من صحة البيانات
            $validated = $request->validate([
                'name' => 'required|string|max:255|regex:/^[\p{L}\s\-\.\']+$/u', // يسمح فقط بالأحرف والمسافات
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20|regex:/^[0-9\+\-\(\)\s]+$/', // يسمح فقط بأرقام الهاتف الصالحة
                'city' => 'required|string|max:255',
                'service_type' => 'required|string|max:255',
                'message' => 'required|string|max:2000', // تحديد الحد الأقصى لطول الرسالة
            ]);

            // تنظيف البيانات المدخلة
            $validated['name'] = strip_tags($validated['name']);
            $validated['email'] = filter_var($validated['email'], FILTER_SANITIZE_EMAIL);
            $validated['city'] = strip_tags($validated['city']);
            $validated['service_type'] = strip_tags($validated['service_type']);
            $validated['message'] = strip_tags($validated['message']);

            // إضافة وقت الإرسال
            $validated['submission_time'] = now()->format('Y-m-d H:i:s');

            // إضافة معلومات المصدر
            $validated['source'] = 'صفحة اتصل بنا';
            $validated['source_url'] = url()->previous();
            $validated['ip_address'] = $request->ip(); // تخزين IP للتتبع الأمني

            // تسجيل المعلومات للتحقق
            $logData = $validated;
            unset($logData['message']); // نزيل المحتوى الطويل من السجلات للحفاظ على المساحة
            Log::info('Contact form submission received', ['data' => $logData, 'ip' => $ipAddress]);

            // إرسال البريد الإلكتروني
            Mail::to('ahmeddfathy087@gmail.com')
                ->send(new ContactPageFormMail($validated));

            // تسجيل نجاح إرسال البريد
            Log::info('Contact form email sent successfully');

            // إعادة التوجيه مع رسالة نجاح
            return back()->with('contact_success', 'تم إرسال رسالتك بنجاح! سنقوم بالتواصل معك قريباً.');
        } catch (\Exception $e) {
            // تسجيل الخطأ
            Log::error('Error in contact form submission', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => $request->ip()
            ]);

            // إعادة التوجيه مع رسالة خطأ
            return back()->with('contact_error', 'حدث خطأ أثناء إرسال رسالتك. يرجى المحاولة مرة أخرى لاحقاً.')
                         ->withInput();
        }
    }
}
