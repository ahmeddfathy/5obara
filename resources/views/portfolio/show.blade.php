@extends('layouts.main')

@section('title', $portfolio->title)

@section('meta')
<meta name="description" content="{{ Str::limit(strip_tags($portfolio->description), 160) }}">
<meta name="keywords" content="{{ $portfolio->title }}، {{ $portfolio->category }}، مشاريع ناجحة، خبراء، استشارات اقتصادية، دراسة جدوى، قصة نجاح، المملكة العربية السعودية">
<meta property="og:title" content="{{ $portfolio->title }} | خبراء للاستشارات الاقتصادية">
<meta property="og:description" content="{{ Str::limit(strip_tags($portfolio->description), 160) }}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ $portfolio->featured_image ? asset('storage/' . $portfolio->featured_image) : asset('assets/img/portfolio/default-project.jpg') }}">
<meta property="article:section" content="{{ $portfolio->category ?? 'مشاريع' }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $portfolio->title }} | خبراء للاستشارات الاقتصادية">
<meta name="twitter:description" content="{{ Str::limit(strip_tags($portfolio->description), 160) }}">
<meta name="twitter:image" content="{{ $portfolio->featured_image ? asset('storage/' . $portfolio->featured_image) : asset('assets/img/portfolio/default-project.jpg') }}">
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/portfolio.css') }}?t={{ time() }}">
<style>
    .project-hero {
        position: relative;
        height: 700px;
        overflow: hidden;
        border-radius: 0;
        margin-bottom: 0;
    }

    .project-hero-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(0.7);
    }

    .project-hero-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 40px;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
    }

    .project-hero-content h1 {
        color: #fff;
        font-size: 36px;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .project-details-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .project-details {
        padding: 60px 0;
        background-color: #f8f9fa;
        position: relative;
    }

    .project-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        padding: 40px;
        position: relative;
        margin-top: -80px;
        border: 1px solid rgba(0, 181, 173, 0.1);
    }

    .project-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin: 0 0 30px;
        padding: 15px 20px;
        background-color: rgba(0, 181, 173, 0.05);
        border-radius: 8px;
        border-right: 4px solid #00b5ad;
    }

    .project-meta span {
        display: inline-flex;
        align-items: center;
        font-size: 15px;
        color: #555;
        font-weight: 500;
    }

    .project-meta i {
        margin-left: 8px;
        color: #00b5ad;
    }

    .project-description {
        margin-bottom: 40px;
    }

    .project-description h3 {
        color: #333;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 20px;
        position: relative;
        padding-right: 15px;
    }

    .project-description h3:before {
        content: '';
        position: absolute;
        right: 0;
        top: 6px;
        height: 16px;
        width: 4px;
        background: #00b5ad;
        border-radius: 2px;
    }

    .description-content {
        color: #555;
        line-height: 1.8;
        font-size: 16px;
        text-align: justify;
    }

    .share-buttons {
        margin-top: 40px;
        padding-top: 25px;
        border-top: 1px solid #eee;
    }

    .share-buttons h4 {
        font-size: 18px;
        color: #333;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .share-buttons a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-left: 12px;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        color: #fff;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .share-buttons a.facebook {
        background-color: #3b5998;
    }

    .share-buttons a.twitter {
        background-color: #1da1f2;
    }

    .share-buttons a.linkedin {
        background-color: #0077b5;
    }

    .share-buttons a:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        color: #333;
        border: 2px solid #00b5ad;
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        margin-top: 20px;
    }

    .back-button:hover {
        background: #00b5ad;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 181, 173, 0.2);
    }

    @media (max-width: 768px) {
        .project-hero {
            height: 300px;
        }

        .project-hero-content h1 {
            font-size: 28px;
        }

        .project-card {
            padding: 25px;
            margin-top: -60px;
        }

        .project-meta {
            flex-direction: column;
            gap: 10px;
        }
    }

    /* Related Projects Section */
    .related-projects {
        padding: 60px 0;
        background-color: #f8f9fa;
    }

    .related-projects .section-title {
        text-align: center;
        margin-bottom: 40px;
    }

    .related-projects .section-title h2 {
        font-size: 32px;
        font-weight: 700;
        color: #333;
        margin-bottom: 10px;
    }

    .related-projects .section-title p {
        color: #666;
        font-size: 18px;
        margin-bottom: 0;
    }

    .related-projects .portfolio-item {
        margin-bottom: 0;
    }

    .related-projects .portfolio-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 181, 173, 0.15);
    }

    .related-projects .portfolio-description {
        height: 48px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .related-projects .view-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #00b5ad;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .related-projects .view-btn:hover {
        color: #008c85;
    }

    .related-projects .view-btn i {
        transition: transform 0.3s ease;
    }

    .related-projects .view-btn:hover i {
        transform: translateX(-5px);
    }
</style>
@endsection

@section('content')
<!-- Project Hero -->
<section class="project-hero">
    @if($portfolio->image)
    <img src="{{ asset('storage/' . $portfolio->image) }}" alt="{{ $portfolio->title }}" class="project-hero-img">
    @else
    <img src="{{ asset('assets/img/portfolio/default-project.jpg') }}" alt="{{ $portfolio->title }}" class="project-hero-img">
    @endif
    <div class="project-hero-content">
        <h1>{{ $portfolio->title }}</h1>
    </div>
</section>

<!-- Project Details -->
<section class="project-details">
    <div class="project-details-container">
        <div class="project-card">
            <div class="project-meta">
                @if($portfolio->project_type)
                <span><i class="fas fa-tag"></i> {{ $portfolio->project_type }}</span>
                @endif
            </div>

            <div class="project-description">
                <h3>تفاصيل المشروع</h3>
                <div class="description-content">
                    {!! nl2br(e($portfolio->description)) !!}
                </div>
            </div>

            <div class="share-buttons">
                <h4>شارك هذا المشروع</h4>
                <div>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($portfolio->title) }}" target="_blank" class="twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($portfolio->title) }}" target="_blank" class="linkedin">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <div class="mt-5 text-center">
                <a href="{{ route('portfolio.index') }}" class="back-button">
                    <i class="fas fa-arrow-right"></i> العودة إلى جميع المشاريع
                </a>
            </div>
        </div>
    </div>
</section>

@if($relatedProjects->isNotEmpty())
<!-- Related Projects Section -->
<section class="related-projects">
    <div class="project-details-container">
        <div class="section-title">
            <h2>مشاريع أخرى</h2>
            <p>استكشف المزيد من مشاريعنا في نفس المجال</p>
        </div>
        <div class="row g-4">
            @foreach($relatedProjects as $relatedProject)
            <div class="col-lg-4 col-md-6">
                <div class="portfolio-item">
                    <div class="portfolio-img-container">
                        @if($relatedProject->image)
                        <img src="{{ asset('storage/' . $relatedProject->image) }}" alt="{{ $relatedProject->title }}">
                        @else
                        <img src="{{ asset('assets/img/portfolio/default-project.jpg') }}" alt="{{ $relatedProject->title }}">
                        @endif
                    </div>
                    <div class="portfolio-content">
                        <div class="portfolio-meta">
                            <span class="portfolio-category">{{ $relatedProject->project_type }}</span>
                        </div>
                        <h3>{{ $relatedProject->title }}</h3>
                        <p class="portfolio-description">{{ Str::limit($relatedProject->description, 100) }}</p>
                        <div class="portfolio-buttons">
                            <a href="{{ route('portfolio.show', $relatedProject->slug) }}" class="view-btn">عرض التفاصيل <i class="fas fa-arrow-left"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

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
<script src="{{ asset('assets/js/portfolio.js') }}?t={{ time() }}"></script>
@endsection
