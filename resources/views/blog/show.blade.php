@extends('layouts.main')

@section('title', $post->title)

@section('meta')
<meta name="description" content="{{ Str::limit(strip_tags($post->content), 160) }}">
<meta name="keywords" content="فرص استثمارية، {{ $post->title }}، استثمار، مشاريع استثمارية، خبراء، استشارات اقتصادية، {{ $post->investment_type ?? 'دراسة جدوى' }}، المملكة العربية السعودية">
<meta property="og:title" content="{{ $post->title }} | خبراء للاستشارات الاقتصادية">
<meta property="og:description" content="{{ Str::limit(strip_tags($post->content), 160) }}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : asset('assets/img/blog/default-post.jpg') }}">
@if($post->published_at)
<meta property="article:published_time" content="{{ $post->published_at->toIso8601String() }}">
@endif
<meta property="article:section" content="{{ $post->investment_type ?? 'استثمار' }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $post->title }} | خبراء للاستشارات الاقتصادية">
<meta name="twitter:description" content="{{ Str::limit(strip_tags($post->content), 160) }}">
<meta name="twitter:image" content="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : asset('assets/img/blog/default-post.jpg') }}">
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}" />
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


</style>

@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    @if($post->featured_image)
        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="featured-image">
    @endif
    <div class="container">
        <div class="hero-content">
            <h1>{{ $post->title }}</h1>
            @if($post->investment_type)
                <p>{{ $post->investment_type }}</p>
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
                    <!-- Investment Highlight Box -->
            @if($post->investment_amount)
                    <div class="investment-box">
                        <h3>تفاصيل الاستثمار</h3>
                        <div class="investment-details">
                            <div class="investment-detail">
                                <strong>قيمة الاستثمار</strong>
                                <span>{{ number_format($post->investment_amount) }} ر.س</span>
                    </div>
                    @if($post->investment_type)
                            <div class="investment-detail">
                                <strong>نوع الاستثمار</strong>
                                <span>{{ $post->investment_type }}</span>
                    </div>
                    @endif
                    @if($post->location)
                            <div class="investment-detail">
                                <strong>الموقع</strong>
                                <span>{{ $post->location }}</span>
                            </div>
                            @endif
                            @if($post->published_at)
                            <div class="investment-detail">
                                <strong>تاريخ النشر</strong>
                                <span>{{ $post->published_at->format('d M, Y') }}</span>
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
            @endif



                    <!-- Post Content -->
                    <div class="blog-detail-content">
                            {!! $post->content !!}
                    </div>

                    <!-- Investment Highlights -->
                    @php
                        $highlights = $post->investment_highlights;
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

                    <!-- Gallery Captions -->
                    @if($galleryImages->isNotEmpty() && $galleryImages->contains('caption', '!=', null))
                    <div class="mt-5">
                        <h3 class="mb-4 fw-bold">معرض الصور</h3>
                        <div class="gallery-captions">
                            @foreach($galleryImages as $index => $image)
                                @if($image->caption)
                                <div class="gallery-caption">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{$image->caption}}">
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
                        <span class="blog-share-label">شارك هذه الفرصة:</span>
                        <div class="blog-share-buttons">
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" class="twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . url()->current()) }}" target="_blank" class="whatsapp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
                </div>

            <!-- Sidebar Column -->
            <div class="col-lg-4">
                    <!-- Contact Information -->
                    @if($post->contact_info)
                <div id="contact" class="blog-detail-container">
                    <h3 class="mb-4 fw-bold">معلومات التواصل</h3>
                    <div class="mb-4">
                            {!! $post->contact_info !!}
                        </div>

                    <a href="mailto:info@5obara.com" class="investment-button d-block text-center">
                        <i class="fas fa-envelope me-2"></i>
                                راسلنا للاستفسار
                            </a>
                    </div>
                    @endif

                    <!-- Tags -->
                    @php
                        $tags = $post->tags;
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
            <h2 class="text-center fw-bold mb-4">فرص استثمارية مشابهة</h2>
            <div class="row g-4">
                @foreach($similarPosts as $similarPost)
                <div class="col-lg-4 col-md-6">
                    <div class="blog-item">
                        <div class="blog-img-container">
                            @if($similarPost->featured_image)
                                <img src="{{ asset('storage/' . $similarPost->featured_image) }}" alt="{{ $similarPost->title }}">
                            @else
                                <img src="{{ asset('assets/img/blog/default-post.jpg') }}" alt="{{ $similarPost->title }}">
                            @endif

                            @if($similarPost->investment_amount)
                                <div class="blog-badge">{{ number_format($similarPost->investment_amount) }} ر.س</div>
                            @endif

                            @if($similarPost->investment_type)
                                <div class="blog-type">{{ $similarPost->investment_type }}</div>
                            @endif
                        </div>
                        <div class="blog-content">
                            <h3>
                                <a href="{{ route('blog.show', $similarPost->slug) }}">
                                    {{ $similarPost->title }}
                                </a>
                            </h3>
                            <p class="blog-description">
                                {{ Str::limit(strip_tags($similarPost->content), 150) }}
                            </p>
                            <div class="blog-meta">
                                <div class="blog-date">
                                    <i class="far fa-calendar-alt"></i>
                                    {{ $similarPost->published_at->format('Y-m-d') }}
                                </div>
                                <a href="{{ route('blog.show', $similarPost->slug) }}" class="read-more">
                                    عرض التفاصيل
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
