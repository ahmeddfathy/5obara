@extends('layouts.app')

@section('title', 'خدماتنا')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/services.css') }}">
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1>خدماتنا</h1>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <img src="https://img.icons8.com/color/96/000000/statistics.png" alt="دراسة الجدوى">
                        </div>
                        <h3>دراسة الجدوى</h3>
                        <p>نقدم دراسات جدوى شاملة لمشاريعك باستخدام أحدث المنهجيات وأدوات التحليل</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <img src="https://img.icons8.com/color/96/000000/market-research.png" alt="دراسة السوق">
                        </div>
                        <h3>دراسة السوق</h3>
                        <p>تحليل شامل للسوق المستهدف وتحديد الفرص والتحديات</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <img src="https://img.icons8.com/color/96/000000/accounting.png" alt="التخطيط المالي">
                        </div>
                        <h3>التخطيط المالي</h3>
                        <p>تطوير خطط مالية متكاملة وتقدير التكاليف والإيرادات</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section class="process-section">
        <div class="container">
            <h2>كيف نعمل</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="process-step">
                        <div class="step-number">1</div>
                        <h4>التشاور الأولي</h4>
                        <p>نستمع إلى متطلباتك وأهداف مشروعك</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="process-step">
                        <div class="step-number">2</div>
                        <h4>تحليل وتخطيط</h4>
                        <p>نقوم بتحليل البيانات وتطوير خطة عمل</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="process-step">
                        <div class="step-number">3</div>
                        <h4>تنفيذ وتسليم</h4>
                        <p>نقدم تقريراً شاملاً مع توصيات عملية</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2>هل لديك مشروع؟</h2>
            <p>نحن هنا لمساعدتك في تحويل فكرتك إلى واقع</p>
            <a href="{{ route('contact') }}" class="btn-primary">تواصل معنا</a>
        </div>
    </section>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/services.js') }}"></script>
@endsection
