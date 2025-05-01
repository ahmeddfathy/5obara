@extends('layouts.main')

@section('title', 'ابدأ مشروعك')

@section('meta')
<meta name="description" content="ابدأ مشروعك مع خبراء - نساعدك في تحويل فكرتك إلى مشروع ناجح. املأ النموذج للحصول على استشارة مجانية والبدء في رحلتك الاستثمارية.">
<meta name="keywords" content="ابدأ مشروعك، تنفيذ المشاريع، دراسة جدوى، مشاريع استثمارية، استشارات اقتصادية، تمويل مشاريع، خطط عمل، رؤية 2030">
<meta property="og:title" content="ابدأ مشروعك | خبراء للاستشارات الاقتصادية">
<meta property="og:description" content="نساعدك في تحويل فكرتك إلى مشروع ناجح. خبرتنا الواسعة وفريقنا المحترف في خدمتك لتنفيذ مشروعك من البداية إلى النهاية.">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ asset('assets/img/icons/expertise.png') }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="ابدأ مشروعك | خبراء للاستشارات الاقتصادية">
<meta name="twitter:description" content="نساعدك في تحويل فكرتك إلى مشروع ناجح. خبرتنا الواسعة وفريقنا المحترف في خدمتك لتنفيذ مشروعك من البداية إلى النهاية.">
<meta name="twitter:image" content="{{ asset('assets/img/icons/expertise.png') }}">
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/start-project.css') }}?t={{ time() }}">
<style>
    .toast-message {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
        max-width: 350px;
        padding: 15px 20px;
        border-radius: 5px;
        background-color: #d4edda;
        color: #155724;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        opacity: 1;
        transition: opacity 0.5s;
        direction: rtl;
    }

    .toast-message.hide {
        opacity: 0;
    }
</style>
@endsection

@section('content')
@if(session('project_success'))
<div class="toast-message" id="successToast">
    <i class="fas fa-check-circle ml-2"></i>
    {{ session('project_success') }}
</div>
@endif

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
            <div class="col-lg-10">
                <div class="form-wrapper">
                    <h2>أخبرنا عن مشروعك</h2>
                    <form class="project-form" action="{{ route('start.project.submit') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <div class="form-group">
                                    <label>الاسم</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>رقم الهاتف</label>
                                    <div class="phone-input">
                                        <input type="text" name="phone" class="form-control" required>
                                        <span class="country-code">966+</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="form-group">
                                    <label>البريد الإلكتروني</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="form-group">
                                    <label>نوع المشروع</label>
                                    <select name="project_type" class="form-control" required>
                                        <option value="" selected disabled>اختر نوع المشروع</option>
                                        <option value="مشروع صناعي">مشروع صناعي</option>
                                        <option value="مشروع تجاري">مشروع تجاري</option>
                                        <option value="مشروع خدمي">مشروع خدمي</option>
                                        <option value="مشروع تقني">مشروع تقني</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="form-group">
                                    <label>وصف المشروع</label>
                                    <textarea name="description" class="form-control" rows="5" placeholder="اكتب تفاصيل مشروعك هنا..." required></textarea>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="form-group">
                                    <label>الميزانية المتوقعة</label>
                                    <input type="text" name="budget" class="form-control" placeholder="بالريال السعودي">
                                </div>
                            </div>
                            <div class="col-12 mt-4">
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
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h4>خبرة واسعة</h4>
                    <p>فريق من الخبراء المتخصصين في مختلف المجالات</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h4>جودة عالية</h4>
                    <p>نقدم خدمات بأعلى معايير الجودة العالمية</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
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
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="contact-info">
                    <h3>تواصل معنا</h3>
                    <ul>
                        <li><i class="fas fa-phone"></i> +966 569617288</li>
                        <li><i class="fas fa-envelope"></i> info@5obara.com</li>
                        <li><i class="fas fa-map-marker-alt"></i> جدة - طريق الكورنيش - مبنى كورنيز الدور الرابع</li>
                    </ul>
                    <div class="project-social-links">
                        <a href="https://www.facebook.com/people/%D8%AE%D8%A8%D8%B1%D8%A7%D8%A1-%D9%84%D9%84%D8%A7%D8%B3%D8%AA%D8%B4%D8%A7%D8%B1%D8%A7%D8%AA-%D8%A7%D9%84%D8%A7%D9%82%D8%AA%D8%B5%D8%A7%D8%AF%D9%8A%D8%A9/61551783909820/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://x.com/Khobra_company" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.linkedin.com/company/%D8%AE%D8%A8%D8%B1%D8%A7%D8%A1-%D9%84%D9%84%D8%A7%D8%B3%D8%AA%D8%B4%D8%A7%D8%B1%D8%A7%D8%AA-%D8%A7%D9%84%D8%A7%D9%82%D8%AA%D8%B5%D8%A7%D8%AF%D9%8A%D8%A9/" target="_blank" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="contact-map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3712.2778999999997!2d39.1825!3d21.5433!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjHCsDMyJzM0LjAiTiAzOcKwMTAnNTcuMCJF!5e0!3m2!1sen!2ssa!4v1234567890" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vision 2030 Logo -->
<div class="vision-2030">
    <img src="{{ asset('assets/img/footer-logo.png') }}" alt="رؤية 2030 - المملكة العربية السعودية">
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/start-project.js') }}?t={{ time() }}"></script>
<script>
    // Auto hide toast messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const toasts = document.querySelectorAll('.toast-message');

        toasts.forEach(function(toast) {
            setTimeout(function() {
                toast.classList.add('hide');
                setTimeout(function() {
                    toast.remove();
                }, 500);
            }, 5000);
        });
    });
</script>
@endsection
