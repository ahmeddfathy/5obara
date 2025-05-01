@extends('layouts.main')

@section('title', $investment->title)

@section('meta')
<meta name="description" content="{{ Str::limit(strip_tags($investment->content), 160) }}">
<meta name="keywords" content="فرص استثمارية، {{ $investment->title }}، استثمار، مشاريع استثمارية، خبراء، استشارات اقتصادية، {{ $investment->category->name ?? 'دراسة جدوى' }}، المملكة العربية السعودية">
<meta property="og:title" content="{{ $investment->title }} | خبراء للاستشارات الاقتصادية">
<meta property="og:description" content="{{ Str::limit(strip_tags($investment->content), 160) }}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ $investment->featured_image ? asset('storage/' . $investment->featured_image) : asset('assets/img/blog/default-post.jpg') }}">
@if($investment->published_at)
<meta property="article:published_time" content="{{ $investment->published_at->toIso8601String() }}">
@endif
<meta property="article:section" content="{{ $investment->category->name ?? 'استثمار' }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $investment->title }} | خبراء للاستشارات الاقتصادية">
<meta name="twitter:description" content="{{ Str::limit(strip_tags($investment->content), 160) }}">
<meta name="twitter:image" content="{{ $investment->featured_image ? asset('storage/' . $investment->featured_image) : asset('assets/img/blog/default-post.jpg') }}">
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}?t={{ time() }}" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
<style>
    /* Hero Section - Specific to this page */
    .hero-section {
        position: relative;
        background-color: #1a1a1a;
        overflow: hidden;
        height: 600px;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1;
    }

    .hero-section .featured-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        color: white;
        text-align: center;
        padding: 200px 0;
    }

    .hero-content h1 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .hero-content p {
        font-size: 1.2rem;
        opacity: 0.9;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
    }

    /* Gallery Styles */
    .investment-gallery {
        margin: 40px 0;
    }

    .gallery-main-slider {
        width: 100%;
        height: 500px;
        margin-bottom: 20px;
        border-radius: 8px;
        overflow: hidden;
        background-color: #f8f9fa;
    }

    .gallery-main-item {
        position: relative;
        height: 100%;
        width: 100%;
        background: #f8f9fa;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .gallery-main-item img {
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
        object-fit: contain;
        display: block;
    }

    .gallery-thumbs {
        height: 100px;
        box-sizing: border-box;
        padding: 10px 0;
    }

    .gallery-thumb-item {
        position: relative;
        height: 80px;
        background: #fff;
        border-radius: 4px;
        overflow: hidden;
        cursor: pointer;
        opacity: 0.7;
        transition: opacity 0.3s;
    }

    .gallery-thumb-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .swiper-slide-thumb-active .gallery-thumb-item {
        opacity: 1;
        border: 2px solid #007bff;
    }

    .gallery-caption {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 15px;
        text-align: center;
    }

    .swiper-button-next,
    .swiper-button-prev {
        color: white;
        background: rgba(0, 0, 0, 0.5);
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .swiper-button-next:after,
    .swiper-button-prev:after {
        font-size: 20px;
    }

    /* Custom navigation arrows */
    .custom-nav-button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .custom-nav-button:hover {
        background: rgba(0, 0, 0, 0.8);
    }

    .nav-button-next {
        right: 20px;
    }

    .nav-button-prev {
        left: 20px;
    }

    .nav-button-icon {
        color: white;
        font-size: 20px;
    }

    /* Investment content image fixes */
    .blog-detail-content img {
        max-width: 100%;
        height: auto !important;
        object-fit: contain;
        background-color: #f8f9fa;
        margin: 20px auto;
        display: block;
    }

    /* Media queries for responsive gallery */
    @media (max-width: 768px) {
        .gallery-main-slider {
            height: 400px;
        }

        .gallery-thumbs {
            height: 90px;
        }

        .gallery-thumb-item {
            height: 70px;
        }
    }

    @media (max-width: 576px) {
        .gallery-main-slider {
            height: 300px;
        }

        .gallery-thumbs {
            height: 70px;
        }

        .gallery-thumb-item {
            height: 50px;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    @if($investment->featured_image)
    <img src="{{ asset('storage/' . $investment->featured_image) }}" alt="{{ $investment->title }}" class="featured-image">
    @endif
    <div class="container">
        <div class="hero-content">
            <h1>{{ $investment->title }}</h1>
            @if($investment->category)
            <p>{{ $investment->category->name }}</p>
            @endif
        </div>
    </div>
</section>

<!-- Investment Detail -->
<section class="blog-detail">
    <div class="container">
        <div class="row">
            <!-- Main Content Column -->
            <div class="col-lg-8">
                <div class="blog-detail-container">
                    <!-- Investment Highlight Box -->
                    <div class="investment-box">
                        <h3>تفاصيل الاستثمار</h3>
                        <div class="investment-details">
                            <div class="investment-detail">
                                <strong>قيمة الاستثمار</strong>
                                <span>{{ number_format((float)$investment->investment_amount) }} ر.س</span>
                            </div>
                            <div class="investment-detail">
                                <strong>نوع الاستثمار</strong>
                                <span>{{ $investment->category->name }}</span>
                            </div>
                            @if($investment->location)
                            <div class="investment-detail">
                                <strong>الموقع</strong>
                                <span>{{ $investment->location }}</span>
                            </div>
                            @endif
                            @if($investment->published_at)
                            <div class="investment-detail">
                                <strong>تاريخ النشر</strong>
                                <span>{{ $investment->published_at->format('d M, Y') }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="investment-cta">
                            <a href="#contact" class="investment-button">
                                تواصل معنا للاستفسار
                                <i class="fas fa-envelope mr-2"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Investment Content -->
                    <div class="blog-detail-content">
                        {!! $investment->content !!}
                    </div>

                    <!-- Investment Gallery -->
                    @if($galleryImages->isNotEmpty())
                    <div class="investment-gallery mt-5">
                        <h3 class="mb-4">معرض الصور</h3>
                        <!-- Main Slider -->
                        <div class="swiper gallery-main-slider mb-3">
                            <div class="swiper-wrapper">
                                @foreach($galleryImages as $image)
                                <div class="swiper-slide">
                                    <div class="gallery-main-item">
                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                            alt="{{ $image->caption ?? $investment->title }}"
                                            class="img-fluid">
                                        @if($image->caption && $galleryImages->count() > 1)
                                        <div class="gallery-caption">
                                            {{ $image->caption }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @if($galleryImages->count() > 1)
                            <!-- Custom Navigation -->
                            <div class="custom-nav-button nav-button-next">
                                <i class="fas fa-arrow-left nav-button-icon"></i>
                            </div>
                            <div class="custom-nav-button nav-button-prev">
                                <i class="fas fa-arrow-right nav-button-icon"></i>
                            </div>
                            @endif
                        </div>

                        @if($galleryImages->count() > 1)
                        <!-- Thumbnails Slider -->
                        <div class="swiper gallery-thumbs">
                            <div class="swiper-wrapper">
                                @foreach($galleryImages as $image)
                                <div class="swiper-slide">
                                    <div class="gallery-thumb-item">
                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                            alt="{{ $image->caption ?? $investment->title }}">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Investment Highlights -->
                    @php
                    $highlights = $investment->investment_highlights;
                    if (is_string($highlights)) {
                    $highlights = json_decode($highlights) ?: [];
                    }
                    @endphp
                    @if(!empty($highlights) && (is_array($highlights) || is_object($highlights)))
                    <div class="investment-box mt-5">
                        <h3>مميزات الاستثمار</h3>
                        <ul class="list-unstyled mt-4">
                            @foreach($highlights as $highlight)
                            <li class="mb-3 d-flex align-items-start">
                                <i class="fas fa-check-circle me-2 mt-1 text-success"></i>
                                <span>{{ $highlight }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Share Buttons -->
                    <div class="blog-share">
                        <span class="blog-share-label">شارك هذه الفرصة:</span>
                        <div class="blog-share-buttons">
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($investment->title) }}" target="_blank" class="twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($investment->title . ' - ' . url()->current()) }}" target="_blank" class="whatsapp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Column -->
            <div class="col-lg-4">
                <!-- Contact Information -->
                @if($investment->contact_info)
                <div id="contact" class="blog-detail-container">
                    <h3 class="mb-4 fw-bold">معلومات التواصل</h3>
                    <div class="mb-4">
                        {!! $investment->contact_info !!}
                    </div>

                    <a href="mailto:info@5obara.com" class="investment-button d-block text-center">
                        <i class="fas fa-envelope me-2"></i>
                        راسلنا للاستفسار
                    </a>
                </div>
                @endif

                <!-- Tags -->
                @php
                $tags = $investment->tags;
                if (is_string($tags)) {
                $tags = json_decode($tags) ?: [];
                }
                @endphp
                @if(!empty($tags) && (is_array($tags) || is_object($tags)))
                <div class="blog-detail-container mb-4">
                    <h3 class="mb-4 fw-bold">الوسوم</h3>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                        <span class="badge bg-light text-dark p-2 rounded-pill">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- WhatsApp Contact -->
                <div class="blog-detail-container">
                    <h3 class="mb-4 fw-bold">تواصل معنا مباشرة</h3>
                    <p>للاستفسارات والمزيد من المعلومات، يمكنك التواصل معنا على الواتساب مباشرة</p>
                    <a href="https://wa.me/966569617288" class="btn btn-success d-flex align-items-center justify-content-center">
                        <i class="fab fa-whatsapp fs-5 me-2"></i>
                        تواصل عبر الواتساب
                    </a>
                </div>
            </div>
        </div>

        <!-- Related Investments -->
        @if($similarInvestments->isNotEmpty())
        <section class="similar-investments">
            <div class="container">
                <div class="section-title">
                    <h2>فرص استثمارية مشابهة</h2>
                </div>
                <div class="row g-4">
                    @foreach($similarInvestments as $similarInvestment)
                    <div class="col-lg-4 col-md-6">
                        <div class="similar-investment-card">
                            <div class="card-image">
                                @if($similarInvestment->featured_image)
                                <img src="{{ asset('storage/' . $similarInvestment->featured_image) }}"
                                    alt="{{ $similarInvestment->title }}">
                                @else
                                <img src="{{ asset('assets/img/blog/default-post.jpg') }}"
                                    alt="{{ $similarInvestment->title }}">
                                @endif

                                @if($similarInvestment->investment_amount)
                                <div class="investment-badge">
                                    {{ number_format((float)$similarInvestment->investment_amount) }} ر.س
                                </div>
                                @endif

                                @if($similarInvestment->category)
                                <div class="category-badge">
                                    {{ $similarInvestment->category->name }}
                                </div>
                                @endif
                            </div>
                            <div class="card-content">
                                <h3 class="card-title">
                                    <a href="{{ route('investments.show', $similarInvestment->slug) }}">
                                        {{ $similarInvestment->title }}
                                    </a>
                                </h3>
                                <p class="card-description">
                                    {{ Str::limit(strip_tags($similarInvestment->content), 120) }}
                                </p>
                            </div>
                            <div class="card-footer">
                                <div class="publish-date">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ $similarInvestment->published_at->format('d M, Y') }}
                                </div>
                                <a href="{{ route('investments.show', $similarInvestment->slug) }}"
                                    class="view-details-btn">
                                    عرض التفاصيل
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
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
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if there's only one gallery image
        const gallerySlides = document.querySelectorAll('.gallery-main-slider .swiper-slide');
        const galleryMainElement = document.querySelector('.gallery-main-slider');

        if (gallerySlides.length === 1 && galleryMainElement) {
            galleryMainElement.classList.add('single-image');

            // Hide navigation arrows for single image
            const nextButton = document.querySelector('.gallery-main-slider .nav-button-next');
            const prevButton = document.querySelector('.gallery-main-slider .nav-button-prev');

            if (nextButton) nextButton.style.display = 'none';
            if (prevButton) prevButton.style.display = 'none';
        }

        // Initialize thumbnail slider if there are multiple images
        if (gallerySlides.length > 1) {
            const galleryThumbs = new Swiper('.gallery-thumbs', {
                spaceBetween: 10,
                slidesPerView: 'auto',
                freeMode: true,
                watchSlidesProgress: true,
                breakpoints: {
                    320: {
                        slidesPerView: 3,
                    },
                    480: {
                        slidesPerView: 4,
                    },
                    768: {
                        slidesPerView: 5,
                    },
                    992: {
                        slidesPerView: 6,
                    }
                }
            });

            // Initialize main slider
            const galleryMain = new Swiper('.gallery-main-slider', {
                spaceBetween: 10,
                navigation: {
                    nextEl: '.nav-button-next',
                    prevEl: '.nav-button-prev',
                },
                thumbs: {
                    swiper: galleryThumbs
                },
                on: {
                    init: function() {
                        // Add class to wrapper when only one slide
                        if (this.slides.length === 1) {
                            this.wrapperEl.classList.add('single-slide');

                            // Hide navigation buttons when initialized with one slide
                            const nextButton = document.querySelector('.gallery-main-slider .nav-button-next');
                            const prevButton = document.querySelector('.gallery-main-slider .nav-button-prev');

                            if (nextButton) nextButton.style.display = 'none';
                            if (prevButton) prevButton.style.display = 'none';
                        }
                    }
                }
            });
        }

        // Scroll to contact section if hash exists
        if (window.location.hash && window.location.hash === '#contact') {
            const contactSection = document.querySelector(window.location.hash);
            if (contactSection) {
                contactSection.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        }
    });
</script>
@endsection