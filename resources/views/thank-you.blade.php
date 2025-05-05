@extends('layouts.main')

@section('title', 'شكراً لتواصلك معنا')
@section('meta_description', 'شكراً لإرسال رسالتك. سنتواصل معك قريباً.')
@section('canonical_url', url('/thank-you'))

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/thank-you.css') }}">
@endsection

@section('content')
<section class="thank-you-section">
    <!-- Confetti Elements -->
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>

    <div class="thank-you-card">
        <div class="success-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <h1 class="thank-you-title">شكراً لتواصلك معنا</h1>

        <div class="thank-you-message">
            <p>تم استلام رسالتك بنجاح!</p>
            <p>سيقوم فريقنا بمراجعتها والرد عليك في أقرب وقت ممكن.</p>
        </div>

        <a href="{{ url('/') }}" class="home-button">
            العودة للصفحة الرئيسية
        </a>
    </div>
</section>
@endsection