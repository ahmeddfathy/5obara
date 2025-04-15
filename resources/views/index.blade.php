@extends('layouts.main')

@section('title', 'الموقع الرسمي')

@section('meta')
<meta name="description" content="خبراء - مكتب متخصص في تقديم دراسات الجدوى الاقتصادية المفصلة للمشاريع. نساعدك في الحصول على تمويل وتنفيذ مشروعك بنجاح.">
<meta name="keywords" content="دراسات جدوى, مشاريع استثمارية, تمويل مشاريع, خطوط إنتاج, استشارات اقتصادية, رؤية 2030">
<meta name="author" content="خبراء للاستشارات الاقتصادية">
<meta property="og:title" content="خبراء - دراسات جدوى اقتصادية مفصلة للمشاريع">
<meta property="og:description" content="نقدم دراسات جدوى اقتصادية معتمدة ومفصلة لمشروعك، ونساعدك في الحصول على التمويل وتنفيذ المشروع بنجاح.">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url('/') }}">
<meta property="og:image" content="{{ asset('assets/img/home/1184773-1.png') }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="خبراء - دراسات جدوى اقتصادية مفصلة للمشاريع">
<meta name="twitter:description" content="نقدم دراسات جدوى اقتصادية معتمدة ومفصلة لمشروعك، ونساعدك في الحصول على التمويل وتنفيذ المشروع بنجاح.">
<meta name="twitter:image" content="{{ asset('assets/img/home/1184773-1.png') }}">
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
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
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
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
@if(session('investment_success'))
    <div class="toast-message" id="successToast">
        <i class="fas fa-check-circle ml-2"></i>
        {{ session('investment_success') }}
    </div>
@endif

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h5>اطلب الآن</h5>
            <h1>دراسة جدوى اقتصادية مفصلة لمشروعك</h1>
            <div class="hero-btns">
                <a href="{{ route('contact') }}" class="btn-green">
                    <i class="fa fa-file-alt"></i>
                    اطلب دراسة جدوى الان
                </a>
                <a href="https://wa.me/966569617288" class="btn-whatsapp">
                    <i class="fab fa-whatsapp"></i>
                    تواصل معنا عبر الواتساب
                </a>
            </div>
        </div>
    </div>
    <div class="chat-btns">
        <a href="#" class="chat-btn whatsapp">
            <i class="fab fa-whatsapp"></i>
        </a>
        <a href="#" class="chat-btn chat">
            <i class="far fa-comment-dots"></i>
        </a>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="why-choose-us">
    <div class="container">
        <h2 class="section-title">لماذا تختار مكتب خبراء لدراسة مشروعك الاقتصادي؟</h2>
        <div class="why-choose-content">
            <div class="why-choose-text">
                <h3>خبراء | الموقع الرسمي</h3>
                <p>نعتمد على خمس ركائز تجعلنا من أفضل الشركات لتتعاون معها في تنفيذ مشروعك:</p>
                <div class="pillars-list">
                    <div class="pillar-item">
                        <h4>أولاً: الخبرة الواسعة</h4>
                        <p>نقدم لك دراسة جدوى اقتصادية مفصلة لمشروعك، معتمدة لدى جميع الجهات التمويلية والحكومية.</p>
                    </div>
                    <div class="pillar-item">
                        <h4>ثانياً: بيانات واقعية</h4>
                        <p>نقدم لك دراسة جدوى مفصلة من أرض الواقع بعد تجميع بيانات واقعية وتحليلها، على يد أكبر المستشاريين بالسوق.</p>
                    </div>
                    <div class="pillar-item">
                        <h4>ثالثاً: فريق متكامل</h4>
                        <p>لدينا فرق عمل تتمتع بقدر كبير من اللياقة الذهنية للحصول على أكثر الافكار المبتكرة، التي تميز مشروعك عن منافسيه تسويقياً وفنياً.</p>
                    </div>
                    <div class="pillar-item">
                        <h4>رابعاً: خدمات متكاملة</h4>
                        <p>لدينا مكتب خاص بتنفيذ المشروعات، والمساعدة في الحصول على التمويل، واستيراد المكائن، وخطوط الانتاج، بالمواصفات القياسية الدقيقة للمشروعات.</p>
                    </div>
                    <div class="pillar-item">
                        <h4>خامساً: أسعار تنافسية</h4>
                        <p>نبادر بدعم رواد الاعمال والمشروعات المتوسطة والصغيرة من خلال أسعار مبسطة، وهذا حرصا منا على خلق المزيد من الفرص، وتشجيعا لعملية التنمية الاقتصادية بالمملكة والتي تتماشى مع رؤية 2030.</p>
                    </div>
                </div>
                <a href="#" class="btn-green">المزيد</a>
            </div>
            <div class="why-choose-img">
                <img src="{{ asset('assets/img/home/shutterstock_778123057.jpg') }}" alt="صناعة">
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services-section">
    <div class="container">
        <h2 class="section-title">نبذة عن الخدمات التي نقدمها وما نتميز به</h2>
        <div class="services-desc">
            <p>نحن نتولى مشروعك حتى تنفيذه على أرض الواقع</p>
            <p>وهذا مرورا بدراسة الجدوى الاقتصادية المفصلة والمعتمدة</p>
            <p>وتمويل المشروع من الجهة المناسبة لما بناء على الملائة المالية لديك</p>
            <p>كذلك استيراد المكائن وخطوط الإنتاج والمواد الخام، وضمان جودة المواصفات</p>
            <p>مع متابعة بدء العمل حتى حصول المشروع على شهادة الجودة والإعتماد التشغيلية للمنتجات</p>
            <p>اطلب الآن دراسة جدوى اقتصادية مفصلة لمشروعك</p>
        </div>

        <div class="services-grid">
            <div class="service-item">
                <div class="service-icon">
                    <img src="{{ asset('assets/img/home/1184773-1.png') }}" alt="تنفيذ المشروعات">
                </div>
                <h3>تنفيذ المشروعات</h3>
            </div>
            <div class="service-item">
                <div class="service-icon">
                    <img src="{{ asset('assets/img/home/1184773-2.png') }}" alt="خطوط انتاج صناعية">
                </div>
                <h3>خطوط انتاج صناعية</h3>
            </div>
            <div class="service-item">
                <div class="service-icon">
                    <img src="{{ asset('assets/img/home/1184773-3.png') }}" alt="دراسات جدوى اقتصادية">
                </div>
                <h3>دراسات جدوى اقتصادية</h3>
            </div>
            <div class="service-item">
                <div class="service-icon">
                    <img src="{{ asset('assets/img/home/1184773-4.png') }}" alt="دراسات مالية ومراجعات محاسبية">
                </div>
                <h3>دراسات مالية ومراجعات محاسبية</h3>
            </div>
            <div class="service-item">
                <div class="service-icon">
                    <img src="{{ asset('assets/img/home/1184773-5.png') }}" alt="رسومات هندسية للمشروع">
                </div>
                <h3>رسومات هندسية للمشروع</h3>
            </div>
            <div class="service-item">
                <div class="service-icon">
                    <img src="{{ asset('assets/img/home/1184773-6.png') }}" alt="الحصول على التمويل">
                </div>
                <h3>الحصول على التمويل</h3>
            </div>
        </div>


        <div class="services-checklist">
            <div class="checklist-item">
                <input type="checkbox" checked disabled>
                <label>عمل دراسة جدوى اقتصادية واقعية مفصلة</label>
            </div>
            <div class="checklist-item">
                <input type="checkbox" checked disabled>
                <label>ترتيب الأوراق والمساعدة في الحصول على تمويل</label>
            </div>
            <div class="checklist-item">
                <input type="checkbox" checked disabled>
                <label>عمل رسوم هندسية للمشروع، واستيراد المكائن وخطوط الإنتاج والمواد الخام</label>
            </div>
            <div class="checklist-item">
                <input type="checkbox" checked disabled>
                <label>ضمان متابعة مواصفات جودة المكائن والحصول على شهادات الجودة</label>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <h2 class="section-title">حقائق بالأرقام</h2>
        <p class="section-desc">نبذة عن أرقام من داخل مؤسستنا ... أطلب الآن دراسة جدوى اقتصادية مفصلة لمشروعك</p>
        <div class="stats-container">
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">1250</div>
                        <div class="stat-label">استشارة</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">6663</div>
                        <div class="stat-label">عميل راضي</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">3450</div>
                        <div class="stat-label">فرصة استثمارية</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">5430</div>
                        <div class="stat-label">دراسة جدوى</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Offering Section -->
<section class="services-offering">
    <div class="container">
        <h2 class="section-title">خدمات خبراء</h2>
        <div class="services-offering-desc">
            <p>نحن نقدم عدد متنوع من الخدمات والاستشارات الاقتصادية يقوم عليها خبراء بسوق التجارة والصناعة خبرتهم تزيد عن عشرون عاما</p>
        </div>
        <div class="services-icons">
            <div class="row g-4">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="service-icon-item">
                        <div class="service-icon-img">
                            <img src="{{ asset('assets/img/home/1184773-1.png') }}" alt="خطوط انتاج">
                        </div>
                        <h4 class="service-icon-title">خطوط انتاج</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="service-icon-item">
                        <div class="service-icon-img">
                            <img src="{{ asset('assets/img/home/1184773-2.png') }}" alt="إنشاء وتنفيذ المشروعات الصناعية">
                        </div>
                        <h4 class="service-icon-title">إنشاء وتنفيذ المشروعات الصناعية</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="service-icon-item">
                        <div class="service-icon-img">
                            <img src="{{ asset('assets/img/home/1184773-3.png') }}" alt="دراسات جدوى اقتصادية">
                        </div>
                        <h4 class="service-icon-title">دراسات جدوى اقتصادية</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="service-icon-item">
                        <div class="service-icon-img">
                            <img src="{{ asset('assets/img/home/1184773-4.png') }}" alt="الرسم الهندسي">
                        </div>
                        <h4 class="service-icon-title">الرسم الهندسي</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Invest Section -->
<section class="invest-section">
    <div class="container">
        <h2 class="section-title">استثمر معنا</h2>
        <p class="invest-desc">يمكنك إدخال رأس المال وسنتواصل معك بأفضل المشاريع - أطلب الان دراسة جدوى اقتصادية مفصلة لمشروعك</p>
        <div class="invest-form">
            <form action="{{ route('investment.submit') }}" method="POST">
                @csrf
                <input type="hidden" name="form_type" value="استثمار">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="الاسم" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="البريد الإلكتروني" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="tel" name="phone" class="form-control" placeholder="رقم الهاتف" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="investment_amount" class="form-control" placeholder="المبلغ المراد استثماره" required>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="submit-btn">طلب استثمار</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/script.js') }}"></script>
<script src="{{ asset('assets/js/counters.js') }}"></script>
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
