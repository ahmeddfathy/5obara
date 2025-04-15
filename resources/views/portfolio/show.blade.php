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
<link rel="stylesheet" href="{{ asset('assets/css/portfolio.css') }}">
<style>
    .project-details {
        padding: 50px 0;
    }
    .project-image {
        width: 100%;
        border-radius: 8px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .project-meta {
        margin: 20px 0;
        padding: 15px;
        background-color: #f9f9f9;
        border-radius: 8px;
    }
    .project-meta span {
        display: inline-block;
        margin-left: 20px;
        font-size: 14px;
        color: #666;
    }
    .project-meta i {
        margin-left: 5px;
        color: #00b5ad;
    }
    .share-buttons {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }
    .share-buttons a {
        display: inline-block;
        margin-left: 10px;
        width: 40px;
        height: 40px;
        line-height: 40px;
        text-align: center;
        border-radius: 50%;
        color: #fff;
        transition: all 0.3s ease;
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
        box-shadow: 0 5px 10px rgba(0,0,0,0.1);
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1>{{ $portfolio->title }}</h1>
        </div>
    </div>
</section>

<!-- Project Details -->
<section class="project-details">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                @if($portfolio->image)
                <img src="{{ asset('storage/' . $portfolio->image) }}" alt="{{ $portfolio->title }}" class="project-image">
                @else
                <img src="{{ asset('assets/img/portfolio/default-project.jpg') }}" alt="{{ $portfolio->title }}" class="project-image">
                @endif

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
                    <a href="{{ route('portfolio.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-right"></i> العودة إلى جميع المشاريع
                    </a>
                </div>
            </div>
        </div>
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
