<?php

namespace App\Http\Controllers;

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
        if (RateLimiter::tooManyAttempts('contact-form:' . $ipAddress, 5)) {
            $seconds = RateLimiter::availableIn('contact-form:' . $ipAddress);
            return back()->with('error', 'لقد أرسلت العديد من الرسائل. الرجاء المحاولة مرة أخرى بعد ' . $seconds . ' ثانية.');
        }

        RateLimiter::hit('contact-form:' . $ipAddress, 60 * 10);

        if ($request->filled('website_field')) {
            return back()->with('success', 'تم إرسال رسالتك بنجاح!');
        }

        $submissionTimestamp = $request->input('_timestamp', 0);
        if (time() - $submissionTimestamp < 3) {
            return back()->with('error', 'الرجاء التأكد من إدخال جميع البيانات بشكل صحيح قبل الإرسال.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|regex:/^[\p{L}\s\-\.\']+$/u',
            'phone' => 'required|string|max:20|regex:/^[0-9\+\-\(\)\s]+$/',
            'inquiry_type' => 'required|string|max:255|in:استفسار,شكوى,اقتراح,أخرى',
            'city' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        $validated['name'] = strip_tags($validated['name']);
        $validated['city'] = strip_tags($validated['city']);
        $validated['message'] = strip_tags($validated['message']);

        $validated['submission_time'] = now()->format('Y-m-d H:i:s');

        $validated['source'] = 'نموذج الاتصال - القدم';
        $validated['source_url'] = url()->previous();
        $validated['ip_address'] = $request->ip();

        try {
            Mail::to('ahmeddfathy087@gmail.com')
                ->send(new ContactFormMail($validated));

            return redirect('/thank-you')->with('success', 'تم إرسال رسالتك بنجاح!');
        } catch (\Exception $e) {
            Log::error('Contact form error: ' . $e->getMessage());
            return back()->with('error', 'حدث خطأ أثناء إرسال الرسالة. الرجاء المحاولة مرة أخرى لاحقاً.')
                ->withInput();
        }
    }
}
