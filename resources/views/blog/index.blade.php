@extends('layouts.app')

@section('title', 'المدونة والفرص الاستثمارية')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}">
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1>المدونة والفرص الاستثمارية</h1>
            <p>اكتشف أحدث الفرص الاستثمارية والمقالات التي تساعدك على اتخاذ قرارات استثمارية ذكية</p>
        </div>
    </div>
</section>

<!-- Blog Section -->
<section class="blog-section">
    <div class="container">
        @if($posts->isEmpty())
        <div class="col-12">
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-newspaper fa-3x text-muted"></i>
                </div>
                <p class="text-muted fs-5 mb-3">لا توجد منشورات حالياً</p>
                <p class="text-muted">تابعنا قريباً للحصول على أحدث الفرص الاستثمارية</p>
            </div>
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
                        <div class="blog-badge">${{ number_format($post->investment_amount) }}</div>
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
                                اقرأ المزيد
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if(!$posts->isEmpty())
        <div class="text-center mt-5">
            <a href="{{ route('blog.opportunities') }}" class="investment-button">
                عرض جميع الفرص الاستثمارية
                <i class="fas fa-arrow-left mr-2"></i>
            </a>
        </div>
        @endif

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
        // Animación de aparición para los elementos del blog
        const blogItems = document.querySelectorAll('.blog-item');

        if (blogItems.length > 0) {
            blogItems.forEach((item, index) => {
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, 100 * index);
            });
        }
    });
</script>
@endsection
