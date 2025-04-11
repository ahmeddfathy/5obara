@extends('layouts.main')

@section('title', 'ابدأ مشروعك')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/start-project.css') }}">
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1>ابدأ مشروعك</h1>
            <p>نحن هنا لمساعدتك في تحويل فكرتك إلى مشروع ناجح</p>
        </div>
    </div>
</section>

<!-- Project Form Section -->
<section class="project-form-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-wrapper">
                    <h2>أخبرنا عن مشروعك</h2>
                    <form class="project-form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>الاسم</label>
                                    <input type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>رقم الهاتف</label>
                                    <div class="phone-input">
                                        <input type="text" class="form-control" required>
                                        <span class="country-code">966+</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>البريد الإلكتروني</label>
                                    <input type="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>نوع المشروع</label>
                                    <select class="form-control" required>
                                        <option value="" selected disabled>اختر نوع المشروع</option>
                                        <option>مشروع صناعي</option>
                                        <option>مشروع تجاري</option>
                                        <option>مشروع خدمي</option>
                                        <option>مشروع تقني</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>وصف المشروع</label>
                                    <textarea class="form-control" rows="5" required></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>الميزانية المتوقعة</label>
                                    <input type="text" class="form-control" placeholder="بالريال السعودي">
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn-submit">إرسال الطلب</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="why-choose-us">
    <div class="container">
        <h2>لماذا تختارنا؟</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <img src="{{ asset('assets/img/icons/expertise.png') }}" alt="الخبرة">
                    </div>
                    <h4>خبرة واسعة</h4>
                    <p>فريق من الخبراء المتخصصين في مختلف المجالات</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <img src="{{ asset('assets/img/icons/quality.png') }}" alt="الجودة">
                    </div>
                    <h4>جودة عالية</h4>
                    <p>نقدم خدمات بأعلى معايير الجودة العالمية</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <img src="{{ asset('assets/img/icons/support.png') }}" alt="الدعم">
                    </div>
                    <h4>دعم مستمر</h4>
                    <p>نقدم دعماً فنياً وإدارياً على مدار المشروع</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="contact-info">
                    <h3>تواصل معنا</h3>
                    <ul>
                        <li><i class="fas fa-phone"></i> +966 50 000 0000</li>
                        <li><i class="fas fa-envelope"></i> info@5obara.com</li>
                        <li><i class="fas fa-map-marker-alt"></i> جدة، المملكة العربية السعودية</li>
                    </ul>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="contact-map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3712.2778999999997!2d39.1825!3d21.5433!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjHCsDMyJzM0LjAiTiAzOcKwMTAnNTcuMCJF!5e0!3m2!1sen!2ssa!4v1234567890" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/start-project.js') }}"></script>
@endsection