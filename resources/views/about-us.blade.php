@extends('layouts.main')

@section('title', 'من نحن')

@section('meta')
<meta name="description" content="مكتب خبراء للاستشارات الاقتصادية - مكتب معتمد في تنفيذ دراسات جدوى اقتصادية مفصلة للمشروعات داخل المملكة العربية السعودية. خبرة تزيد عن 7 سنوات في الأسواق الخليجية والإقليمية.">
<meta name="keywords" content="من نحن، عن الشركة، خبراء، استشارات اقتصادية، دراسات جدوى، مكتب معتمد، مشاريع استثمارية، المملكة العربية السعودية">
<meta property="og:title" content="من نحن | خبراء للاستشارات الاقتصادية">
<meta property="og:description" content="مكتب معتمد في تنفيذ دراسات جدوى اقتصادية مفصلة للمشروعات بخبرة تزيد عن 7 سنوات في الأسواق الخليجية والإقليمية.">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ asset('assets/img/about/Afniah_Logo-1-1024x809.png') }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="من نحن | خبراء للاستشارات الاقتصادية">
<meta name="twitter:description" content="مكتب معتمد في تنفيذ دراسات جدوى اقتصادية مفصلة للمشروعات بخبرة تزيد عن 7 سنوات في الأسواق الخليجية والإقليمية.">
<meta name="twitter:image" content="{{ asset('assets/img/about/Afniah_Logo-1-1024x809.png') }}">
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/about.css') }}">
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1>من نحن</h1>
                <p class="lead">نحن نقدم خدمات استشارية متكاملة ودراسات جدوى احترافية</p>
            </div>
        </div>
    </section>

    <!-- About Content -->
    <section class="about-section">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <p>نحن مكتب معتمد في تنفيذ دراسات جدوى اقتصادية مفصلة للمشروعات نعمل داخل المملكة العربية السعودية بمدينة جده ولدينا فرق استشارية لجميع القطاعات الاقتصادية لسوق المملكة العربية السعودية.</p>

                    <p>نحن نتولى دراسة جدوى مشروعكم والبدء بالتقديم للجهات الممولة والبدء بتنفيذ المشروع بالرسومات الهندسية واستيراد المكائن والمواد الخام وخطوط الانتاج بضمان أعلى جودة وأفضل سعر.</p>

                    <p>يقوم بجمع البيانات فريق مدرب بالتعاون مع مراكز احصائية ويقوم بتحليل البيانات فريق استشاري متخصص بالقطاع محل الدراسة نحن نسعى لإنجاح مشروعكم وتحقيق مكاسب وعوائد اقتصادية مطلوبة كما نبحث عن أفضل الطرق التسويقية التي يجب على المشروع استخدامها بالسوق لديكم.</p>

                    <p>نحن لدينا اطلاع كامل بكل ما يحدث بالأسواق في الدول الأخرى وهذا يجعلنا متفوقين على أي شركة أخرى ويجعل ثقتكم بنا وبتنفيذنا لدراسة جدوى مشروعكم وتقديم أفضل خدمة استشارية لكم.</p>

                    <p>الشركة تعمل في مجال دراسات الجدوى ولديها خبرة 7 سنوات بالأسواق الخليجية والإقليمية، من خلال ما حققته من إنجازات في هذا المجال الذي يمكنها من اتخاذ قرارات استثمارية صائبة.</p>

                    <p>اتخاذ القرار الصائب هو ركيزة أي استثمار ناجح، لذلك فإن دراسة الجدوى الاقتصادية والبحوث التي تقوم بها قبل الشروع في التنفيذ تحفظ استثماراتك وتوجهها لأفضل الطرق. فتعتبر دراسات الجدوى من سمات رجل الأعمال والمستثمر الحقيقي الذي يبحث عن مؤشرات يستطيع الاعتماد عليها لنمو المحفظة الاستثمارية بالشكل المهني السليم.</p>
                </div>
            </div>

            <div class="partners-section">
                <h2>شركاء النجاح</h2>
                <div class="partners-grid">
                    <div class="partner-card">
                        <img src="{{ asset('assets/img/about/Afniah_Logo-1-1024x809.png') }}" alt="شركة أفنية">
                    </div>
                    <div class="partner-card">
                        <img src="{{ asset('assets/img/about/bashory-logo.jpeg') }}" alt="شركة باشوري">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/about.js') }}"></script>
@endsection
