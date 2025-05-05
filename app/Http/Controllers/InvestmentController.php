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
            $ipAddress = $request->ip();
            if (RateLimiter::tooManyAttempts('investment-form:' . $ipAddress, 3)) {
                $seconds = RateLimiter::availableIn('investment-form:' . $ipAddress);
                return back()->with('investment_error', 'لقد أرسلت العديد من الطلبات. الرجاء المحاولة مرة أخرى بعد ' . $seconds . ' ثانية.')
                    ->withInput();
            }

            RateLimiter::hit('investment-form:' . $ipAddress, 60 * 30);

            if ($request->filled('website_field')) {
                return back()->with('investment_success', 'تم إرسال طلب الاستثمار بنجاح! سنتواصل معك قريباً.');
            }

            $submissionTimestamp = $request->input('_timestamp', 0);
            if (time() - $submissionTimestamp < 3) {
                return back()->with('investment_error', 'الرجاء التأكد من إدخال جميع البيانات بشكل صحيح قبل الإرسال.')
                    ->withInput();
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255|regex:/^[\p{L}\s\-\.\']+$/u',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20|regex:/^[0-9\+\-\(\)\s]+$/',
                'investment_amount' => 'required|string|max:255',
                'form_type' => 'required|string|in:استثمار,شراكة,تمويل',
            ]);

            $validated['name'] = strip_tags($validated['name']);
            $validated['email'] = filter_var($validated['email'], FILTER_SANITIZE_EMAIL);
            $validated['investment_amount'] = strip_tags($validated['investment_amount']);

            $validated['source'] = 'فورم الاستثمار - الصفحة الرئيسية';
            $validated['source_url'] = url('/');
            $validated['submission_time'] = now()->format('Y-m-d H:i:s');
            $validated['ip_address'] = $request->ip();

            Log::info('Investment form submission', [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'amount' => $validated['investment_amount'],
                'ip' => $ipAddress
            ]);

            Mail::to('ahmeddfathy087@gmail.com')
                ->send(new InvestmentFormMail($validated));

            return redirect('/thank-you')->with('investment_success', 'تم إرسال طلب الاستثمار بنجاح! سنتواصل معك قريباً.');
        } catch (\Exception $e) {
            Log::error('Error in investment form submission', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => $request->ip()
            ]);

            return back()->with('investment_error', 'حدث خطأ أثناء إرسال طلب الاستثمار. يرجى المحاولة مرة أخرى لاحقاً.')
                ->withInput();
        }
    }
}
