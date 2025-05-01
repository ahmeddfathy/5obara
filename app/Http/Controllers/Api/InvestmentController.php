<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvestmentFormMail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class InvestmentController extends Controller
{
    public function submit(Request $request)
    {
        try {
            $ipAddress = $request->ip();
            if (RateLimiter::tooManyAttempts('investment-form:' . $ipAddress, 3)) {
                $seconds = RateLimiter::availableIn('investment-form:' . $ipAddress);
                return response()->json([
                    'status' => 'error',
                    'message' => 'لقد أرسلت العديد من الطلبات. الرجاء المحاولة مرة أخرى بعد ' . $seconds . ' ثانية.',
                    'retry_after' => $seconds
                ], 429);
            }

            RateLimiter::hit('investment-form:' . $ipAddress, 60 * 30);

            if ($request->filled('website_field')) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'تم إرسال طلب الاستثمار بنجاح! سنتواصل معك قريباً.'
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
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20|regex:/^[0-9\+\-\(\)\s]+$/',
                'investment_amount' => 'required|string|max:255',
                'form_type' => 'required|string|in:استثمار,شراكة,تمويل',
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
            $validated['email'] = filter_var($validated['email'], FILTER_SANITIZE_EMAIL);
            $validated['investment_amount'] = strip_tags($validated['investment_amount']);

            $validated['source'] = 'API فورم الاستثمار';
            $validated['source_url'] = $request->header('Referer', 'API');
            $validated['submission_time'] = now()->format('Y-m-d H:i:s');
            $validated['ip_address'] = $request->ip();

            Log::info('Investment form API submission', [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'amount' => $validated['investment_amount'],
                'ip' => $ipAddress
            ]);

            Mail::to('ahmeddfathy087@gmail.com')
                ->send(new InvestmentFormMail($validated));

            return response()->json([
                'status' => 'success',
                'message' => 'تم إرسال طلب الاستثمار بنجاح! سنتواصل معك قريباً.'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error in investment form API submission', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => $request->ip()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء إرسال طلب الاستثمار. يرجى المحاولة مرة أخرى لاحقاً.'
            ], 500);
        }
    }
}
