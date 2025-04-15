<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // التحقق من محدودية عدد الطلبات من نفس IP
        $ipAddress = $request->ip();
        if (RateLimiter::tooManyAttempts('contact-form:'.$ipAddress, 5)) {
            $seconds = RateLimiter::availableIn('contact-form:'.$ipAddress);
            return response()->json([
                'status' => 'error',
                'message' => 'لقد أرسلت العديد من الرسائل. الرجاء المحاولة مرة أخرى بعد '.$seconds.' ثانية.'
            ], 429);
        }

        RateLimiter::hit('contact-form:'.$ipAddress, 60*10); // 10 دقائق

        // التحقق من honeypot (فخ للروبوتات)
        if ($request->filled('website_field')) {
            // وهمي - إذا تم ملؤه فهو على الأرجح روبوت
            return response()->json([
                'status' => 'success',
                'message' => 'تم إرسال رسالتك بنجاح!'
            ], 200); // نعيد رسالة نجاح مزيفة
        }

        // وقت التقديم لمنع الإرسال التلقائي
        $submissionTimestamp = $request->input('_timestamp', 0);
        if (time() - $submissionTimestamp < 3) { // أقل من 3 ثوانٍ = مشبوه
            return response()->json([
                'status' => 'error',
                'message' => 'الرجاء التأكد من إدخال جميع البيانات بشكل صحيح قبل الإرسال.'
            ], 400);
        }

        // Validate the form data with better sanitization
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|regex:/^[\p{L}\s\-\.\']+$/u', // يسمح فقط بالأحرف والمسافات
            'phone' => 'required|string|max:20|regex:/^[0-9\+\-\(\)\s]+$/', // يسمح فقط بأرقام الهاتف الصالحة
            'inquiry_type' => 'required|string|max:255|in:استفسار,شكوى,اقتراح,أخرى', // قائمة محددة من القيم
            'city' => 'required|string|max:255',
            'message' => 'required|string|max:2000', // تحديد الحد الأقصى لطول الرسالة
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'بيانات غير صالحة',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        // تنظيف البيانات المدخلة
        $validated['name'] = strip_tags($validated['name']);
        $validated['city'] = strip_tags($validated['city']);
        $validated['message'] = strip_tags($validated['message']);

        // إضافة وقت الإرسال
        $validated['submission_time'] = now()->format('Y-m-d H:i:s');

        // إضافة معلومات المصدر
        $validated['source'] = 'API نموذج الاتصال';
        $validated['source_url'] = $request->header('Referer', 'API');
        $validated['ip_address'] = $request->ip(); // تخزين IP للتتبع الأمني

        try {
            // Send the email
            Mail::to('ahmeddfathy087@gmail.com')
                ->send(new ContactFormMail($validated));

            return response()->json([
                'status' => 'success',
                'message' => 'تم إرسال رسالتك بنجاح!'
            ], 200);
        } catch (\Exception $e) {
            // تسجيل الخطأ بدون كشف التفاصيل للمستخدم
            Log::error('Contact form API error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء إرسال الرسالة. الرجاء المحاولة مرة أخرى لاحقاً.'
            ], 500);
        }
    }
}
