@extends('layouts.main')

@section('title', 'خدماتنا')

@section('meta')
<meta name="description" content="تعرف على خدماتنا المتكاملة في مجال الاستشارات الاقتصادية - دراسات الجدوى، دراسة السوق، التخطيط المالي، وخدمات استشارية متكاملة لتحقيق نجاح مشاريعك.">
<meta name="keywords" content="خدمات استشارية، دراسة جدوى، دراسة سوق، تخطيط مالي، استشارات اقتصادية، تنفيذ مشاريع، تمويل، رؤية 2030">
<meta property="og:title" content="خدماتنا المتكاملة | خبراء للاستشارات الاقتصادية">
<meta property="og:description" content="نقدم حلولاً استشارية متكاملة لتحقيق نجاح مشاريعك، بدءاً من دراسة الجدوى والسوق وحتى التخطيط المالي والتنفيذ.">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ asset('assets/img/home/logo.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="خدماتنا المتكاملة | خبراء للاستشارات الاقتصادية">
<meta name="twitter:description" content="نقدم حلولاً استشارية متكاملة لتحقيق نجاح مشاريعك، بدءاً من دراسة الجدوى والسوق وحتى التخطيط المالي والتنفيذ.">
<meta name="twitter:image" content="{{ asset('assets/img/home/logo.jpg') }}">
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/services.css') }}?t={{ time() }}">
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1>خدماتنا المتكاملة</h1>
                <p class="lead">نقدم حلولاً استشارية متكاملة لتحقيق نجاح مشاريعك</p>
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
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="text-right">دراسة الجدوى</h3>
                        <p class="text-right">نقدم دراسات جدوى شاملة لمشاريعك باستخدام أحدث المنهجيات وأدوات التحليل، مع التركيز على الجوانب المالية والتسويقية والفنية</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-search-dollar"></i>
                        </div>
                        <h3 class="text-right">دراسة السوق</h3>
                        <p class="text-right">تحليل شامل للسوق المستهدف وتحديد الفرص والتحديات، مع تقديم رؤى استراتيجية لتحقيق النجاح في السوق التنافسي</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <h3 class="text-right">التخطيط المالي</h3>
                        <p class="text-right">تطوير خطط مالية متكاملة وتقدير التكاليف والإيرادات، مع وضع استراتيجيات فعالة لتحقيق الاستدامة المالية</p>
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
                        <p>نستمع إلى متطلباتك وأهداف مشروعك بعناية، ونقوم بتحليل احتياجاتك بدقة</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="process-step">
                        <div class="step-number">2</div>
                        <h4>تحليل وتخطيط</h4>
                        <p>نقوم بتحليل البيانات وتطوير خطة عمل استراتيجية مخصصة لمشروعك</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="process-step">
                        <div class="step-number">3</div>
                        <h4>تنفيذ وتسليم</h4>
                        <p>نقدم تقريراً شاملاً مع توصيات عملية قابلة للتنفيذ، ونضمن متابعة النتائج</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2>هل لديك مشروع؟</h2>
            <p>نحن هنا لمساعدتك في تحويل فكرتك إلى واقع ملموس. تواصل معنا اليوم لبدء رحلة نجاح مشروعك</p>
            <a href="{{ route('contact') }}" class="btn-primary">تواصل معنا</a>
        </div>
    </section>
@endsection

@section('scripts')
<!-- No scripts needed for now -->
@endsection
