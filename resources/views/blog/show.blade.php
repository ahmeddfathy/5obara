@extends('layouts.app')

@section('title', $post->title)

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />

@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
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
                                <span>${{ number_format($post->investment_amount) }}</span>
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

                    <!-- Featured image -->
        @if($post->featured_image)
                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="blog-detail-image">
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
                    @for ($i = 0; $i < 3; $i++)
                <div class="col-lg-4 col-md-6">
                    <div class="blog-item">
                        <div class="blog-img-container">
                        @if($post->featured_image)
                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Related post">
                        @endif
                        </div>
                        <div class="blog-content">
                            <h3><a href="#">فرصة استثمارية مشابهة {{ $i + 1 }}</a></h3>
                            <p class="blog-description">هذه فرصة استثمارية مشابهة للفرصة الحالية، قد تكون مهتماً بمعرفة المزيد عنها.</p>
                            <div class="blog-meta">
                                <span class="blog-date"><i class="far fa-calendar-alt"></i> {{ now()->subDays(rand(1, 30))->format('Y-m-d') }}</span>
                                <a href="#" class="read-more">
                                    عرض التفاصيل
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
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
