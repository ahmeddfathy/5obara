@extends('layouts.main')

@section('title', 'من نحن')

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

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="contact-form">
                        <h3>تواصل معنا</h3>
                        <form>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="الاسم الكامل">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="البريد الإلكتروني">
                            </div>
                            <div class="form-group">
                                <select class="form-control">
                                    <option value="">نوع الخدمة</option>
                                    <option>دراسة جدوى</option>
                                    <option>استشارة</option>
                                    <option>تمويل مشروع</option>
                                    <option>خدمات أخرى</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="4" placeholder="رسالتك"></textarea>
                            </div>
                            <button type="submit" class="btn-submit">إرسال الرسالة</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-info">
                        <h3>معلومات التواصل</h3>
                        <ul>
                            <li><i class="far fa-envelope"></i> info@5obara.com</li>
                            <li><i class="fas fa-phone"></i> +966569617288</li>
                            <li><i class="fab fa-whatsapp"></i> +966569617288</li>
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
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/about.js') }}"></script>
@endsection
