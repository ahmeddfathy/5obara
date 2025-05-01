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
        $ipAddress = $request->ip();
        if (RateLimiter::tooManyAttempts('contact-form:'.$ipAddress, 5)) {
            $seconds = RateLimiter::availableIn('contact-form:'.$ipAddress);
            return response()->json([
                'status' => 'error',
                'message' => 'لقد أرسلت العديد من الرسائل. الرجاء المحاولة مرة أخرى بعد '.$seconds.' ثانية.'
            ], 429);
        }

        RateLimiter::hit('contact-form:'.$ipAddress, 60*10);

        if ($request->filled('website_field')) {
            return response()->json([
                'status' => 'success',
                'message' => 'تم إرسال رسالتك بنجاح!'
            ], 200);
        }

        $submissionTimestamp = $request->input('_timestamp', 0);
        if (time() - $submissionTimestamp < 3) {
            return response()->json([
                'status' => 'error',
                'message' => 'الرجاء التأكد من إدخال جميع البيانات بشكل صحيح قبل الإرسال.'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|regex:/^[\p{L}\s\-\.\']+$/u',
            'phone' => 'required|string|max:20|regex:/^[0-9\+\-\(\)\s]+$/',
            'inquiry_type' => 'required|string|max:255|in:استفسار,شكوى,اقتراح,أخرى',
            'city' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'بيانات غير صالحة',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        $validated['name'] = strip_tags($validated['name']);
        $validated['city'] = strip_tags($validated['city']);
        $validated['message'] = strip_tags($validated['message']);

        $validated['submission_time'] = now()->format('Y-m-d H:i:s');

        $validated['source'] = 'API نموذج الاتصال';
        $validated['source_url'] = $request->header('Referer', 'API');
        $validated['ip_address'] = $request->ip();

        try {
            Mail::to('ahmeddfathy087@gmail.com')
                ->send(new ContactFormMail($validated));

            return response()->json([
                'status' => 'success',
                'message' => 'تم إرسال رسالتك بنجاح!'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Contact form API error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء إرسال الرسالة. الرجاء المحاولة مرة أخرى لاحقاً.'
            ], 500);
        }
    }
}
