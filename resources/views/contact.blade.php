@extends('layouts.app')

@section('title', 'اتصل بنا')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/contact.css') }}">
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1>اتصل بنا</h1>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-form-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="contact-form-wrapper">
                        <form class="contact-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="الاسم">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="phone-input">
                                            <input type="text" class="form-control" placeholder="رقم الهاتف">
                                            <span class="country-code">966+</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="بأي مدينة مشروعك؟">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <select class="form-control">
                                            <option value="" selected disabled>البريد الالكتروني</option>
                                            <option>استشارة</option>
                                            <option>اقتراح</option>
                                            <option>استفسار</option>
                                            <option>طلب دراسة</option>
                                            <option>شكوى</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea class="form-control" rows="5" placeholder="الرسالة"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn-submit">إرسال</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Branch Section -->
    <section class="branch-section">
        <div class="container">
            <h2>الفرع الرئيسي</h2>
            <p>جدة طريق الكورنيش مبنى كورنيز الدور الرابع</p>
            <a href="#" class="whatsapp-btn">تواصل معنا عبر الواتساب</a>
        </div>
    </section>

    <div class="chat-btns">
        <a href="#" class="chat-btn whatsapp">
            <i class="fab fa-whatsapp"></i>
        </a>
        <a href="#" class="chat-btn messenger">
            <i class="fab fa-facebook-messenger"></i>
        </a>
    </div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/contact.js') }}"></script>
@endsection
