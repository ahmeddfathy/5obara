@extends('layouts.main')

@section('title', 'الفرص الاستثمارية')

@section('meta')
<meta name="description" content="اكتشف أفضل الفرص الاستثمارية المتاحة في المملكة العربية السعودية. فرص متنوعة في قطاعات مختلفة مع تحليل متكامل وتوقعات العوائد الاستثمارية.">
<meta name="keywords" content="فرص استثمارية، استثمار، مشاريع واعدة، عوائد استثمارية، استثمار في السعودية، مشاريع مربحة، رأس المال، تمويل مشاريع، رؤية 2030">
<meta property="og:title" content="الفرص الاستثمارية | خبراء للاستشارات الاقتصادية">
<meta property="og:description" content="اكتشف أفضل الفرص الاستثمارية المتاحة في المملكة العربية السعودية. فرص متنوعة في قطاعات مختلفة مع تحليل متكامل وتوقعات العوائد الاستثمارية.">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ asset('assets/img/blog/default-post.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="الفرص الاستثمارية | خبراء للاستشارات الاقتصادية">
<meta name="twitter:description" content="اكتشف أفضل الفرص الاستثمارية المتاحة في المملكة العربية السعودية. فرص متنوعة في قطاعات مختلفة مع تحليل متكامل وتوقعات العوائد الاستثمارية.">
<meta name="twitter:image" content="{{ asset('assets/img/blog/default-post.jpg') }}">
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}">
<style>
    .blog-badge {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(0, 181, 173, 0.6);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(0, 181, 173, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(0, 181, 173, 0);
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1>المدونة والفرص الاستثمارية</h1>
            <p>اكتشف أحدث الفرص الاستثمارية التي تساعدك على اتخاذ قرارات استثمارية ذكية</p>
        </div>
    </div>
</section>

<!-- Investment Grid -->
<section class="investment-grid">
    <div class="container">
        <div class="section-title">
            <h2>فرص استثمارية مميزة</h2>
            <p>استكشف أحدث الفرص الاستثمارية المتاحة في مختلف المجالات ذات العائد المجزي</p>
        </div>

        <div class="investment-filters">
            <button class="investment-filter active">جميع الفرص</button>
            <button class="investment-filter">العقارات</button>
            <button class="investment-filter">التجارة الإلكترونية</button>
            <button class="investment-filter">التصنيع</button>
            <button class="investment-filter">الخدمات</button>
        </div>

        @if($posts->isEmpty())
        <div class="empty-state">
            <i class="fas fa-search"></i>
            <h3>لا توجد فرص استثمارية متاحة حالياً</h3>
            <p>يرجى زيارة هذه الصفحة لاحقاً، سنقوم بإضافة فرص استثمارية جديدة قريباً</p>
        </div>
        @else
        <div class="row g-4">
            @foreach($posts as $post)
            <div class="col-lg-4 col-md-6">
                <div class="blog-item">
                    <div class="blog-img-container">
                        @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}">
                        @else
                        <img src="{{ asset('assets/img/blog/default-post.jpg') }}" alt="{{ $post->title }}">
                        @endif

                        @if($post->investment_amount)
                        <div class="blog-badge">{{ number_format($post->investment_amount) }} ر.س</div>
                        @endif

                        @if($post->investment_type)
                        <div class="blog-type">{{ $post->investment_type }}</div>
                        @endif
                    </div>
                    <div class="blog-content">
                        <h3>
                            <a href="{{ route('blog.show', $post->slug) }}">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <p class="blog-description">
                            {{ Str::limit(strip_tags($post->content), 150) }}
                        </p>
                        <div class="blog-meta">
                            <div class="blog-date">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $post->published_at->format('d M, Y') }}
                            </div>
                            <a href="{{ route('blog.show', $post->slug) }}" class="read-more">
                                عرض التفاصيل
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
</section>

<div class="chat-btns">
    <a href="https://wa.me/966569617288" class="chat-btn whatsapp">
        <i class="fab fa-whatsapp"></i>
    </a>
    <a href="#" class="chat-btn messenger">
        <i class="fab fa-facebook-messenger"></i>
    </a>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Efectos para los elementos del blog
        const blogItems = document.querySelectorAll('.blog-item');

        if (blogItems.length > 0) {
            blogItems.forEach((item, index) => {
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, 100 * index);
            });
        }

        // Filtros de inversión
        const filters = document.querySelectorAll('.investment-filter');

        filters.forEach(filter => {
            filter.addEventListener('click', function() {
                filters.forEach(f => f.classList.remove('active'));
                this.classList.add('active');

                // Aquí se pueden añadir funciones de filtrado reales
                // Por ahora solo es visual
            });
        });
    });
</script>
@endsection
