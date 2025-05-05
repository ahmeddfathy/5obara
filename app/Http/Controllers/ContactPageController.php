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
            $ipAddress = $request->ip();
            if (RateLimiter::tooManyAttempts('contact-page-form:' . $ipAddress, 5)) {
                $seconds = RateLimiter::availableIn('contact-page-form:' . $ipAddress);
                return back()->with('contact_error', 'لقد أرسلت العديد من الرسائل. الرجاء المحاولة مرة أخرى بعد ' . $seconds . ' ثانية.')
                    ->withInput();
            }

            RateLimiter::hit('contact-page-form:' . $ipAddress, 60 * 10);

            if ($request->filled('website_field')) {
                return back()->with('contact_success', 'تم إرسال رسالتك بنجاح! سنقوم بالتواصل معك قريباً.');
            }

            $submissionTimestamp = $request->input('_timestamp', 0);
            if (time() - $submissionTimestamp < 3) {
                return back()->with('contact_error', 'الرجاء التأكد من إدخال جميع البيانات بشكل صحيح قبل الإرسال.')
                    ->withInput();
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255|regex:/^[\p{L}\s\-\.\']+$/u',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20|regex:/^[0-9\+\-\(\)\s]+$/',
                'city' => 'required|string|max:255',
                'service_type' => 'required|string|max:255',
                'message' => 'required|string|max:2000',
            ]);

            $validated['name'] = strip_tags($validated['name']);
            $validated['email'] = filter_var($validated['email'], FILTER_SANITIZE_EMAIL);
            $validated['city'] = strip_tags($validated['city']);
            $validated['service_type'] = strip_tags($validated['service_type']);
            $validated['message'] = strip_tags($validated['message']);

            $validated['submission_time'] = now()->format('Y-m-d H:i:s');
            $validated['source'] = 'صفحة اتصل بنا';
            $validated['source_url'] = url()->previous();
            $validated['ip_address'] = $request->ip();

            $logData = $validated;
            unset($logData['message']);
            Log::info('Contact form submission received', ['data' => $logData, 'ip' => $ipAddress]);

            Mail::to('ahmeddfathy087@gmail.com')
                ->send(new ContactPageFormMail($validated));

            Log::info('Contact form email sent successfully');

            return redirect('/thank-you')->with('contact_success', 'تم إرسال رسالتك بنجاح! سنقوم بالتواصل معك قريباً.');
        } catch (\Exception $e) {
            Log::error('Error in contact form submission', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => $request->ip()
            ]);

            return back()->with('contact_error', 'حدث خطأ أثناء إرسال رسالتك. يرجى المحاولة مرة أخرى لاحقاً.')
                ->withInput();
        }
    }
}
