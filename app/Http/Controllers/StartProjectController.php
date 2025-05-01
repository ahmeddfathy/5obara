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
            $ipAddress = $request->ip();
            if (RateLimiter::tooManyAttempts('start-project-form:'.$ipAddress, 3)) {
                $seconds = RateLimiter::availableIn('start-project-form:'.$ipAddress);
                return back()->with('project_error', 'لقد أرسلت العديد من الطلبات. الرجاء المحاولة مرة أخرى بعد '.$seconds.' ثانية.')
                            ->withInput();
            }

            RateLimiter::hit('start-project-form:'.$ipAddress, 60*30);

            if ($request->filled('website_field')) {
                return back()->with('project_success', 'تم إرسال طلب المشروع بنجاح! سنتواصل معك قريباً.');
            }

            $submissionTimestamp = $request->input('_timestamp', 0);
            if (time() - $submissionTimestamp < 3) {
                return back()->with('project_error', 'الرجاء التأكد من إدخال جميع البيانات بشكل صحيح قبل الإرسال.')
                            ->withInput();
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255|regex:/^[\p{L}\s\-\.\']+$/u',
                'phone' => 'required|string|max:20|regex:/^[0-9\+\-\(\)\s]+$/',
                'email' => 'required|email|max:255',
                'project_type' => 'required|string|max:255',
                'description' => 'required|string|max:5000',
                'budget' => 'nullable|string|max:255',
            ]);

            $validated['name'] = strip_tags($validated['name']);
            $validated['email'] = filter_var($validated['email'], FILTER_SANITIZE_EMAIL);
            $validated['project_type'] = strip_tags($validated['project_type']);
            $validated['description'] = strip_tags($validated['description']);
            $validated['budget'] = $validated['budget'] ? strip_tags($validated['budget']) : null;

            $validated['submission_time'] = now()->format('Y-m-d H:i:s');
            $validated['source'] = 'نموذج ابدأ مشروعك';
            $validated['source_url'] = url()->previous();
            $validated['ip_address'] = $request->ip();

            $logData = $validated;
            unset($logData['description']);
            Log::info('Start project form submission', [
                'data' => $logData,
                'ip' => $ipAddress
            ]);

            Mail::to('ahmeddfathy087@gmail.com')
                ->send(new StartProjectMail($validated));

            return back()->with('project_success', 'تم إرسال طلب المشروع بنجاح! سنتواصل معك قريباً.');

        } catch (\Exception $e) {
            Log::error('Error in start project form submission', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => $request->ip()
            ]);

            return back()->with('project_error', 'حدث خطأ أثناء إرسال طلب المشروع. يرجى المحاولة مرة أخرى لاحقاً.')
                         ->withInput();
        }
    }
}
