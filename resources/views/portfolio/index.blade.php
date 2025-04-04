@extends('layouts.app')

@section('title', 'سابقة الأعمال')

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
                                @if($portfolio->completion_date)
                                <span class="portfolio-date">{{ $portfolio->completion_date->format('M Y') }}</span>
                                @endif
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

            <!-- Fallback static examples if no dynamic content -->
            @if($portfolios->isEmpty())
            <!-- Project 1 -->
            <div class="col-lg-4 col-md-6">
                <div class="portfolio-item">
                    <div class="portfolio-img-container">
                        <img src="{{ asset('assets/img/portfolio/project1.jpg') }}" alt="مشروع ورشة تصليح سيارات">
                    </div>
                    <div class="portfolio-content">
                        <div class="portfolio-meta">
                            <span class="portfolio-category">دراسة جدوى</span>
                            <span class="portfolio-date">2023</span>
                        </div>
                        <h3>دراسة جدوى مشروع ورشة تصليح سيارات</h3>
                        <p class="portfolio-description">دراسة جدوى مفصلة لإنشاء ورشة تصليح سيارات متكاملة مع تحليل السوق والمنافسين.</p>
                        <div class="portfolio-buttons">
                            <a href="{{ route('contact') }}" class="contact-btn">تواصل معنا <i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Project 2 -->
            <div class="col-lg-4 col-md-6">
                <div class="portfolio-item">
                    <div class="portfolio-img-container">
                        <img src="{{ asset('assets/img/portfolio/project2.jpg') }}" alt="مشروع مصنع مصابيح">
                    </div>
                    <div class="portfolio-content">
                        <div class="portfolio-meta">
                            <span class="portfolio-category">دراسة جدوى</span>
                            <span class="portfolio-date">2023</span>
                        </div>
                        <h3>دراسة جدوى مشروع مصنع مصابيح Led</h3>
                        <p class="portfolio-description">دراسة جدوى شاملة لمصنع إنتاج مصابيح LED مع دراسة تكاليف الإنتاج والتسويق.</p>
                        <div class="portfolio-buttons">
                            <a href="{{ route('contact') }}" class="contact-btn">تواصل معنا <i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Project 3 -->
            <div class="col-lg-4 col-md-6">
                <div class="portfolio-item">
                    <div class="portfolio-img-container">
                        <img src="{{ asset('assets/img/portfolio/project3.jpg') }}" alt="مشروع مصنع مظلات">
                    </div>
                    <div class="portfolio-content">
                        <div class="portfolio-meta">
                            <span class="portfolio-category">دراسة جدوى</span>
                            <span class="portfolio-date">2023</span>
                        </div>
                        <h3>دراسة جدوى مشروع مصنع مظلات</h3>
                        <p class="portfolio-description">دراسة جدوى تفصيلية لمشروع مصنع مظلات مع تحليل للسوق المحلي وخطة التسويق.</p>
                        <div class="portfolio-buttons">
                            <a href="{{ route('contact') }}" class="contact-btn">تواصل معنا <i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Pagination -->
        @if(!$portfolios->isEmpty())
        <div class="pagination-wrapper">
            {{ $portfolios->links() }}
        </div>
        @else
        <div class="pagination-wrapper">
            <ul class="pagination">
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">التالي</a></li>
            </ul>
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
