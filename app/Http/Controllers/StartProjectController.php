<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\StartProjectMail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;

class StartProjectController extends Controller
{
    public function submit(Request $request)
    {
        try {
            // التحقق من محدودية عدد الطلبات من نفس IP
            $ipAddress = $request->ip();
            if (RateLimiter::tooManyAttempts('start-project-form:'.$ipAddress, 3)) {
                $seconds = RateLimiter::availableIn('start-project-form:'.$ipAddress);
                return back()->with('project_error', 'لقد أرسلت العديد من الطلبات. الرجاء المحاولة مرة أخرى بعد '.$seconds.' ثانية.')
                            ->withInput();
            }

            RateLimiter::hit('start-project-form:'.$ipAddress, 60*30); // 30 دقيقة

            // التحقق من honeypot (فخ للروبوتات)
            if ($request->filled('website_field')) {
                // وهمي - إذا تم ملؤه فهو على الأرجح روبوت
                return back()->with('project_success', 'تم إرسال طلب المشروع بنجاح! سنتواصل معك قريباً.');
            }

            // وقت التقديم لمنع الإرسال التلقائي
            $submissionTimestamp = $request->input('_timestamp', 0);
            if (time() - $submissionTimestamp < 3) { // أقل من 3 ثوانٍ = مشبوه
                return back()->with('project_error', 'الرجاء التأكد من إدخال جميع البيانات بشكل صحيح قبل الإرسال.')
                            ->withInput();
            }

            // التحقق من صحة البيانات
            $validated = $request->validate([
                'name' => 'required|string|max:255|regex:/^[\p{L}\s\-\.\']+$/u', // يسمح فقط بالأحرف والمسافات
                'phone' => 'required|string|max:20|regex:/^[0-9\+\-\(\)\s]+$/', // يسمح فقط بأرقام الهاتف الصالحة
                'email' => 'required|email|max:255',
                'project_type' => 'required|string|max:255',
                'description' => 'required|string|max:5000', // تحديد الحد الأقصى لطول الوصف
                'budget' => 'nullable|string|max:255',
            ]);

            // تنظيف البيانات المدخلة
            $validated['name'] = strip_tags($validated['name']);
            $validated['email'] = filter_var($validated['email'], FILTER_SANITIZE_EMAIL);
            $validated['project_type'] = strip_tags($validated['project_type']);
            $validated['description'] = strip_tags($validated['description']);
            $validated['budget'] = $validated['budget'] ? strip_tags($validated['budget']) : null;

            // إضافة وقت الإرسال
            $validated['submission_time'] = now()->format('Y-m-d H:i:s');

            // إضافة معلومات المصدر
            $validated['source'] = 'نموذج ابدأ مشروعك';
            $validated['source_url'] = url()->previous();
            $validated['ip_address'] = $request->ip(); // تخزين IP للتتبع الأمني

            // تسجيل طلب المشروع للمراجعة الأمنية
            $logData = $validated;
            unset($logData['description']); // نزيل المحتوى الطويل من السجلات للحفاظ على المساحة
            Log::info('Start project form submission', [
                'data' => $logData,
                'ip' => $ipAddress
            ]);

            // إرسال البريد الإلكتروني
            Mail::to('ahmeddfathy087@gmail.com')
                ->send(new StartProjectMail($validated));

            // إعادة التوجيه مع رسالة نجاح
            return back()->with('project_success', 'تم إرسال طلب المشروع بنجاح! سنتواصل معك قريباً.');

        } catch (\Exception $e) {
            // تسجيل الخطأ
            Log::error('Error in start project form submission', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => $request->ip()
            ]);

            // إعادة التوجيه مع رسالة خطأ
            return back()->with('project_error', 'حدث خطأ أثناء إرسال طلب المشروع. يرجى المحاولة مرة أخرى لاحقاً.')
                         ->withInput();
        }
    }
}
