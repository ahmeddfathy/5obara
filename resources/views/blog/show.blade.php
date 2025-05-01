@extends('layouts.main')

@section('title', $blog->title)

@section('meta')
<meta name="description" content="{{ Str::limit(strip_tags($blog->content), 160) }}">
<meta name="keywords" content="مقالات اقتصادية، {{ $blog->title }}، خبراء، استشارات اقتصادية، {{ $blog->blog_type ?? 'دراسات اقتصادية' }}، المملكة العربية السعودية">
<meta property="og:title" content="{{ $blog->title }} | خبراء للاستشارات الاقتصادية">
<meta property="og:description" content="{{ Str::limit(strip_tags($blog->content), 160) }}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : asset('assets/img/blog/default-post.jpg') }}">
@if($blog->published_at)
<meta property="article:published_time" content="{{ $blog->published_at->toIso8601String() }}">
@endif
<meta property="article:section" content="{{ $blog->blog_type ?? 'مقالات اقتصادية' }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $blog->title }} | خبراء للاستشارات الاقتصادية">
<meta name="twitter:description" content="{{ Str::limit(strip_tags($blog->content), 160) }}">
<meta name="twitter:image" content="{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : asset('assets/img/blog/default-post.jpg') }}">
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

    /* Gallery Section Image Improvements */
    .gallery-section {
        margin: 40px 0;
        position: relative;
    }

    .gallery-top {
        height: 500px;
        width: 100%;
        margin-bottom: 20px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        background-color: #f8f9fa;
    }

    .gallery-top .swiper-slide {
        position: relative;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .gallery-top .swiper-slide img {
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
        object-fit: contain;
    }

    .gallery-thumbs {
        height: 100px;
        box-sizing: border-box;
        padding: 10px 0;
    }

    .gallery-thumbs .swiper-slide {
        height: 100%;
        opacity: 0.4;
        cursor: pointer;
        transition: opacity 0.3s ease;
        border-radius: 8px;
        overflow: hidden;
    }

    .gallery-thumbs .swiper-slide-thumb-active {
        opacity: 1;
    }

    .gallery-thumbs .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    /* Gallery Captions Improvement */
    .gallery-captions {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }

    .gallery-caption {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .gallery-caption img {
        width: 100%;
        height: 200px;
        object-fit: contain;
        background-color: #f8f9fa;
    }

    /* Blog content image fixes */
    .blog-detail-content img {
        max-width: 100%;
        height: auto !important;
        object-fit: contain;
        background-color: #f8f9fa;
        margin: 20px auto;
        display: block;
    }

    /* Media queries for responsive images */
    @media (max-width: 768px) {
        .gallery-top {
            height: 400px;
        }

        .gallery-thumbs {
            height: 80px;
        }

        .gallery-caption img {
            height: 180px;
        }
    }

    @media (max-width: 576px) {
        .gallery-top {
            height: 300px;
        }

        .gallery-thumbs {
            height: 60px;
        }

        .gallery-caption img {
            height: 160px;
        }
    }
</style>

@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    @if($blog->featured_image)
    <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" class="featured-image">
    @endif
    <div class="container">
        <div class="hero-content">
            <h1>{{ $blog->title }}</h1>
            @if($blog->blog_type)
            <p>{{ $blog->blog_type }}</p>
            @endif
        </div>
    </div>
</section>

<!-- Blog Detail -->
<section class="blog-detail">
    <div class="container">
        <div class="row">
            <!-- Main Content Column -->
            <div class="col-lg-8">
                <div class="blog-detail-container">
                    <!-- Post Details Box -->
                    @if($blog->published_at || $blog->blog_type)
                    <div class="investment-box">
                        <h3>تفاصيل المقالة</h3>
                        <div class="investment-details">
                            @if($blog->blog_type)
                            <div class="investment-detail">
                                <strong>التصنيف</strong>
                                <span>{{ $blog->blog_type }}</span>
                            </div>
                            @endif
                            @if($blog->published_at)
                            <div class="investment-detail">
                                <strong>تاريخ النشر</strong>
                                <span>{{ $blog->published_at->format('d M, Y') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Post Content -->
                    <div class="blog-detail-content">
                        {!! $blog->content !!}
                    </div>

                    <!-- Gallery Section -->
                    @if($galleryImages->isNotEmpty())
                    <div class="gallery-section">
                        <div class="swiper gallery-top">
                            <div class="swiper-wrapper">
                                @foreach($galleryImages as $image)
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->caption ?? $blog->title }}">
                                    @if($image->caption && $galleryImages->count() > 1)
                                    <div class="gallery-caption">
                                        <p>{{ $image->caption }}</p>
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            @if($galleryImages->count() > 1)
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            @endif
                        </div>
                        @if($galleryImages->count() > 1)
                        <div class="swiper gallery-thumbs">
                            <div class="swiper-wrapper">
                                @foreach($galleryImages as $image)
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->caption ?? $blog->title }}">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Gallery Captions -->
                    @if($galleryImages->isNotEmpty() && $galleryImages->contains('caption', '!=', null))
                    <div class="mt-5">
                        <h3 class="mb-4 fw-bold">معرض الصور</h3>
                        <div class="gallery-captions">
                            @foreach($galleryImages as $index => $image)
                            @if($image->caption)
                            <div class="gallery-caption">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->caption }}">
                                <div>
                                    <div class="text-muted small mb-1">صورة {{ $index + 1 }}</div>
                                    <p class="mb-0">{{ $image->caption }}</p>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Share Buttons -->
                    <div class="blog-share">
                        <span class="blog-share-label">شارك هذه المقالة:</span>
                        <div class="blog-share-buttons">
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($blog->title) }}" target="_blank" class="twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($blog->title . ' - ' . url()->current()) }}" target="_blank" class="whatsapp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Column -->
            <div class="col-lg-4">
                <!-- Contact Information -->
                @if($blog->contact_info)
                <div id="contact" class="blog-detail-container">
                    <h3 class="mb-4 fw-bold">معلومات التواصل</h3>
                    <div class="mb-4">
                        {!! $blog->contact_info !!}
                    </div>

                    <a href="mailto:info@5obara.com" class="investment-button d-block text-center">
                        <i class="fas fa-envelope me-2"></i>
                        راسلنا للاستفسار
                    </a>
                </div>
                @endif

                <!-- Tags -->
                @php
                $tags = $blog->tags;
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

        <!-- Related Posts -->
        <div class="mt-5">
            <h2 class="text-center fw-bold mb-4">مقالات ذات صلة</h2>
            <div class="row g-4">
                @foreach($similarBlogs as $similarBlog)
                <div class="col-lg-4 col-md-6">
                    <div class="blog-item">
                        <div class="blog-img-container" style="background-color: #f8f9fa;">
                            @if($similarBlog->featured_image)
                            <img src="{{ asset('storage/' . $similarBlog->featured_image) }}" alt="{{ $similarBlog->title }}" style="object-fit: contain;">
                            @else
                            <img src="{{ asset('assets/img/blog/default-post.jpg') }}" alt="{{ $similarBlog->title }}" style="object-fit: contain;">
                            @endif

                            @if($similarBlog->blog_type)
                            <div class="blog-type">{{ $similarBlog->blog_type }}</div>
                            @endif
                        </div>
                        <div class="blog-content">
                            <h3>
                                <a href="{{ route('blog.show', $similarBlog->slug) }}">
                                    {{ $similarBlog->title }}
                                </a>
                            </h3>
                            <p class="blog-description">
                                {{ Str::limit(strip_tags($similarBlog->content), 150) }}
                            </p>
                            <div class="blog-meta">
                                <div class="blog-date">
                                    <i class="far fa-calendar-alt"></i>
                                    {{ $similarBlog->published_at->format('Y-m-d') }}
                                </div>
                                <a href="{{ route('blog.show', $similarBlog->slug) }}" class="read-more">
                                    اقرأ المزيد
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
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
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if there's only one gallery image
        const gallerySlides = document.querySelectorAll('.gallery-top .swiper-slide');
        const galleryTopElement = document.querySelector('.gallery-top');

        if (gallerySlides.length === 1 && galleryTopElement) {
            galleryTopElement.classList.add('single-image');

            // Hide navigation arrows for single image
            const nextButton = document.querySelector('.gallery-top .swiper-button-next');
            const prevButton = document.querySelector('.gallery-top .swiper-button-prev');

            if (nextButton) nextButton.style.display = 'none';
            if (prevButton) prevButton.style.display = 'none';
        }

        var galleryThumbs = new Swiper('.gallery-thumbs', {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
        });

        var galleryTop = new Swiper('.gallery-top', {
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: galleryThumbs
            },
            on: {
                init: function() {
                    // Alternative approach: add class to wrapper when only one slide
                    if (this.slides.length === 1) {
                        this.wrapperEl.classList.add('single-slide');

                        // Hide navigation buttons when initialized with one slide
                        const nextButton = document.querySelector('.gallery-top .swiper-button-next');
                        const prevButton = document.querySelector('.gallery-top .swiper-button-prev');

                        if (nextButton) nextButton.style.display = 'none';
                        if (prevButton) prevButton.style.display = 'none';
                    }
                }
            }
        });

        // Initialize animation
        document.querySelectorAll('.blog-item').forEach((el, index) => {
            setTimeout(() => {
                el.style.opacity = 1;
                el.style.transform = "translateY(0)";
            }, 100 * index);
        });
    });
</script>
@endsection
