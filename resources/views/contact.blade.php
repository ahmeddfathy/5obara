@extends('layouts.main')

@section('title', 'اتصل بنا')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/contact.css') }}">
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1>تواصل معنا</h1>
                <p>نحن هنا لمساعدتك في تحقيق أهداف مشروعك. تواصل معنا الآن ودعنا نبدأ رحلة نجاحك</p>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-form-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="contact-form-wrapper">
                        <form class="contact-form" id="contactForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="الاسم الكامل" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="phone-input">
                                            <input type="tel" class="form-control" placeholder="رقم الهاتف" required>
                                            <span class="country-code">966+</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="البريد الإلكتروني" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="المدينة" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <select class="form-control" required>
                                            <option value="" selected disabled>نوع الخدمة المطلوبة</option>
                                            <option value="consultation">استشارة</option>
                                            <option value="feasibility">دراسة جدوى</option>
                                            <option value="business_plan">خطة عمل</option>
                                            <option value="market_study">دراسة سوق</option>
                                            <option value="other">أخرى</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea class="form-control" rows="5" placeholder="تفاصيل المشروع" required></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn-submit">
                                        <i class="fas fa-paper-plane ml-2"></i>
                                        إرسال الطلب
                                    </button>
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
            <h2>معلومات التواصل</h2>
            <div class="contact-info">
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>جدة - طريق الكورنيش - مبنى كورنيز الدور الرابع</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-phone-alt"></i>
                    <span>966569617288+</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>info@5obara.com</span>
                </div>
            </div>

            <div class="social-links">
                <a href="#" class="social-link facebook" title="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="social-link twitter" title="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="social-link instagram" title="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="social-link linkedin" title="LinkedIn">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>

            <a href="https://wa.me/966569617288" class="whatsapp-btn" target="_blank">
                <i class="fab fa-whatsapp"></i>
                تواصل معنا عبر الواتساب
            </a>
        </div>
    </section>

    <!-- Vision 2030 Logo -->
    <div class="vision-2030">
        <img src="{{ asset('assets/img/vision-2030.png') }}" alt="رؤية 2030">
    </div>

    <!-- Floating Chat Buttons -->
    <div class="chat-btns">
        <a href="https://wa.me/966569617288" class="chat-btn whatsapp" target="_blank">
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
