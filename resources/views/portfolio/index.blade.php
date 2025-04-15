@extends('layouts.main')

@section('title', 'أعمالنا السابقة')

@section('meta')
<meta name="description" content="استعرض أبرز الأعمال والمشاريع السابقة التي نفذها فريق خبراء للاستشارات الاقتصادية. مشاريع ناجحة في مختلف القطاعات الاقتصادية.">
<meta name="keywords" content="أعمالنا، مشاريع سابقة، بورتفوليو، خبراء، استشارات اقتصادية، دراسات جدوى، قصص نجاح، مشاريع ناجحة، المملكة العربية السعودية">
<meta property="og:title" content="أعمالنا السابقة | خبراء للاستشارات الاقتصادية">
<meta property="og:description" content="استعرض أبرز الأعمال والمشاريع السابقة التي نفذها فريق خبراء للاستشارات الاقتصادية. مشاريع ناجحة في مختلف القطاعات الاقتصادية.">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ asset('assets/img/home/logo.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="أعمالنا السابقة | خبراء للاستشارات الاقتصادية">
<meta name="twitter:description" content="استعرض أبرز الأعمال والمشاريع السابقة التي نفذها فريق خبراء للاستشارات الاقتصادية. مشاريع ناجحة في مختلف القطاعات الاقتصادية.">
<meta name="twitter:image" content="{{ asset('assets/img/home/logo.jpg') }}">
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/portfolio.css') }}">
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1>سابقة الأعمال</h1>
        </div>
    </div>
</section>

<!-- Portfolio Grid -->
<section class="portfolio-section">
    <div class="container">
        <div class="row g-4">
            @if($portfolios->isEmpty())
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-folder-open fa-3x text-muted"></i>
                    </div>
                    <p class="text-muted fs-5 mb-3">لا توجد أعمال متاحة حالياً</p>
                    <p class="text-muted">تابعنا قريباً حيث نقوم بإضافة مشاريع جديدة باستمرار.</p>
                </div>
            </div>
            @else
                @foreach($portfolios as $portfolio)
                <div class="col-lg-4 col-md-6">
                    <div class="portfolio-item">
                        <div class="portfolio-img-container">
                            @if($portfolio->image)
                            <img src="{{ asset('storage/' . $portfolio->image) }}" alt="{{ $portfolio->title }}">
                            @else
                            <img src="{{ asset('assets/img/portfolio/default-project.jpg') }}" alt="{{ $portfolio->title }}">
                            @endif
                        </div>
                        <div class="portfolio-content">
                            <div class="portfolio-meta">
                                <span class="portfolio-category">{{ $portfolio->project_type }}</span>
                            </div>
                            <h3>{{ $portfolio->title }}</h3>
                            <p class="portfolio-description">{{ Str::limit($portfolio->description, 100) }}</p>
                            <div class="portfolio-buttons">
                                <a href="{{ route('portfolio.show', $portfolio->slug) }}" class="view-btn">عرض التفاصيل <i class="fas fa-arrow-left"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

        <!-- Pagination -->
        @if(!$portfolios->isEmpty())
        <div class="pagination-wrapper">
            {{ $portfolios->links() }}
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
<script src="{{ asset('assets/js/portfolio.js') }}"></script>
@endsection
