@extends('layouts.main')

@section('title', 'اتصل بنا')

@section('meta')
<meta name="description" content="تواصل مع خبراء للاستشارات الاقتصادية - نحن هنا لمساعدتك في تحقيق أهداف مشروعك. تواصل معنا الآن عبر الهاتف، البريد الإلكتروني، أو النموذج مباشرة.">
<meta name="keywords" content="اتصل بنا، تواصل، استشارات اقتصادية، دراسة جدوى، مكتب استشاري، خدمة العملاء، دعم المشاريع">
<meta property="og:title" content="اتصل بنا | خبراء للاستشارات الاقتصادية">
<meta property="og:description" content="نحن هنا لمساعدتك في تحقيق أهداف مشروعك. تواصل معنا الآن عبر الهاتف، البريد الإلكتروني، أو زيارة مكتبنا في جدة.">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ asset('assets/img/home/logo.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="اتصل بنا | خبراء للاستشارات الاقتصادية">
<meta name="twitter:description" content="نحن هنا لمساعدتك في تحقيق أهداف مشروعك. تواصل معنا الآن عبر الهاتف، البريد الإلكتروني، أو زيارة مكتبنا في جدة.">
<meta name="twitter:image" content="{{ asset('assets/img/home/logo.jpg') }}">
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/contact.css') }}?t={{ time() }}">
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
@if(session('contact_success'))
<div class="toast-message" id="successToast">
  <i class="fas fa-check-circle ml-2"></i>
  {{ session('contact_success') }}
</div>
@endif

@if(session('contact_error'))
<div class="toast-message" id="errorToast" style="background-color: #f8d7da; color: #721c24;">
  <i class="fas fa-exclamation-circle ml-2"></i>
  {{ session('contact_error') }}
</div>
@endif

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
          <form class="contact-form" action="{{ route('contact.page.submit') }}" method="POST">
            @csrf

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" name="name" class="form-control" placeholder="الاسم الكامل" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <div class="phone-input">
                    <input type="tel" name="phone" class="form-control" placeholder="رقم الهاتف" required>
                    <span class="country-code">966+</span>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="email" name="email" class="form-control" placeholder="البريد الإلكتروني" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" name="city" class="form-control" placeholder="المدينة" required>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <select name="service_type" class="form-control" required>
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
                  <textarea name="message" class="form-control" rows="5" placeholder="تفاصيل المشروع" required></textarea>
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
    <div class="branch-info">
      <div class="branch-item">
        <i class="fas fa-map-marker-alt"></i>
        <span>جدة - طريق الكورنيش - مبنى كورنيز الدور الرابع</span>
      </div>
      <div class="branch-item">
        <i class="fas fa-phone-alt"></i>
        <span>966569617288+</span>
      </div>
      <div class="branch-item">
        <i class="fas fa-envelope"></i>
        <span>info@5obara.com</span>
      </div>
    </div>

    <div class="branch-social-links">
      <a href="https://www.facebook.com/people/%D8%AE%D8%A8%D8%B1%D8%A7%D8%A1-%D9%84%D9%84%D8%A7%D8%B3%D8%AA%D8%B4%D8%A7%D8%B1%D8%A7%D8%AA-%D8%A7%D9%84%D8%A7%D9%82%D8%AA%D8%B5%D8%A7%D8%AF%D9%8A%D8%A9/61551783909820/" class="branch-social-link facebook" target="_blank" title="Facebook">
        <i class="fab fa-facebook-f"></i>
      </a>
      <a href="https://x.com/Khobra_company" class="branch-social-link twitter" target="_blank" title="Twitter">
        <i class="fab fa-twitter"></i>
      </a>
      <a href="https://www.instagram.com/" class="branch-social-link instagram" target="_blank" title="Instagram">
        <i class="fab fa-instagram"></i>
      </a>
      <a href="https://www.linkedin.com/company/%D8%AE%D8%A8%D8%B1%D8%A7%D8%A1-%D9%84%D9%84%D8%A7%D8%B3%D8%AA%D8%B4%D8%A7%D8%B1%D8%A7%D8%AA-%D8%A7%D9%84%D8%A7%D9%82%D8%AA%D8%B5%D8%A7%D8%AF%D9%8A%D8%A9/" class="branch-social-link linkedin" target="_blank" title="LinkedIn">
        <i class="fab fa-linkedin-in"></i>
      </a>
    </div>

    <a href="https://wa.me/966569617288" class="whatsapp-btn" target="_blank">
      <i class="fab fa-whatsapp"></i>
      تواصل معنا عبر الواتساب
    </a>

    <!-- Google Maps -->
    <div class="branch-map mt-5">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3712.2778999999997!2d39.1825!3d21.5433!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjHCsDMyJzM0LjAiTiAzOcKwMTAnNTcuMCJF!5e0!3m2!1sen!2ssa!4v1234567890" width="100%" height="400" style="border:0; border-radius: 10px;" allowfullscreen="" loading="lazy"></iframe>
    </div>
  </div>
</section>

<!-- Vision 2030 Logo -->
<div class="vision-2030">
  <img src="{{ asset('assets/img/footer-logo.png') }}" alt="رؤية 2030 - المملكة العربية السعودية">
</div>

<!-- Floating Chat Buttons -->
<div class="chat-btns">
  <a href="https://wa.me/966569617288" class="chat-btn whatsapp" target="_blank">
    <i class="fab fa-whatsapp"></i>
  </a>
  <a href="https://www.facebook.com/people/%D8%AE%D8%A8%D8%B1%D8%A7%D8%A1-%D9%84%D9%84%D8%A7%D8%B3%D8%AA%D8%B4%D8%A7%D8%B1%D8%A7%D8%AA-%D8%A7%D9%84%D8%A7%D9%82%D8%AA%D8%B5%D8%A7%D8%AF%D9%8A%D8%A9/61551783909820/" class="chat-btn messenger" target="_blank">
    <i class="fab fa-facebook-messenger"></i>
  </a>
</div>
@endsection

@section('scripts')

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

    // Form submission handling to ensure it's working
    const contactForm = document.querySelector('.contact-form');
    if (contactForm) {
      contactForm.addEventListener('submit', function(e) {
        // Log form submission attempt
        console.log('Form submission initiated');

        // Normal form submission continues
      });
    }
  });
</script>
@endsection
