@extends('layouts.main')

@section('title', 'المدونة')

@section('meta')
<meta name="description" content="اكتشف أحدث المقالات من خبراء للاستشارات الاقتصادية. مقالات متخصصة لمساعدتك في اتخاذ قرارات اقتصادية ذكية.">
<meta name="keywords" content="مدونة اقتصادية، مقالات اقتصادية، استشارات اقتصادية، المملكة العربية السعودية، رؤية 2030">
<meta property="og:title" content="المدونة | خبراء للاستشارات الاقتصادية">
<meta property="og:description" content="اكتشف أحدث المقالات من خبراء للاستشارات الاقتصادية. مقالات متخصصة لمساعدتك في اتخاذ قرارات اقتصادية ذكية.">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ asset('assets/img/blog/default-post.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="المدونة | خبراء للاستشارات الاقتصادية">
<meta name="twitter:description" content="اكتشف أحدث المقالات من خبراء للاستشارات الاقتصادية. مقالات متخصصة لمساعدتك في اتخاذ قرارات اقتصادية ذكية.">
<meta name="twitter:image" content="{{ asset('assets/img/blog/default-post.jpg') }}">
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}?t={{ time() }}">
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1>المدونة</h1>
            <p>اكتشف أحدث المقالات التي تساعدك على اتخاذ قرارات اقتصادية ذكية</p>
        </div>
    </div>
</section>

<!-- Blog Section with Modern Filters -->
<section class="investment-grid">
    <div class="container">
        <!-- Modern Dropdown Filters -->
        <div class="investment-filters mb-4">
            <div class="filter-dropdown" id="categoryDropdown">
                <div class="filter-dropdown-toggle">
                    <span>{{ request('category') && request('category') !== 'all' ? $categories->firstWhere('id', request('category'))->name : 'كل المقالات' }}</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="filter-dropdown-menu">
                    <a href="{{ route('blog.index') }}"
                        class="filter-dropdown-item {{ !request('category') || request('category') === 'all' ? 'active' : '' }}">
                        كل المقالات
                    </a>
                    @foreach($categories as $category)
                    <a href="{{ route('blog.index', ['category' => $category->id]) }}"
                        class="filter-dropdown-item {{ request('category') == $category->id ? 'active' : '' }}">
                        {{ $category->name }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        @if($blogs->isEmpty())
        <div class="empty-state">
            <i class="fas fa-newspaper"></i>
            <h3>لا توجد منشورات حالياً</h3>
            <p>تابعنا قريباً للحصول على أحدث المقالات</p>
        </div>
        @else
        <div class="row g-4">
            @foreach($blogs as $blog)
            <div class="col-lg-4 col-md-6">
                <div class="blog-item">
                    <div class="blog-img-container">
                        @if($blog->featured_image)
                        <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}">
                        @else
                        <img src="{{ asset('assets/img/blog/default-post.jpg') }}" alt="{{ $blog->title }}">
                        @endif

                        @if($blog->category)
                        <div class="blog-type">{{ $blog->category->name }}</div>
                        @endif
                    </div>
                    <div class="blog-content">
                        <h3>
                            <a href="{{ route('blog.show', $blog->slug) }}">
                                {{ $blog->title }}
                            </a>
                        </h3>
                        <p class="blog-description">
                            {{ Str::limit(strip_tags($blog->content), 150) }}
                        </p>
                        <div class="blog-meta">
                            <div class="blog-date">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $blog->published_at->format('d M, Y') }}
                            </div>
                            <a href="{{ route('blog.show', $blog->slug) }}" class="read-more">
                                اقرأ المزيد
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $blogs->links() }}
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
        // Animation for blog items
        const blogItems = document.querySelectorAll('.blog-item');

        if (blogItems.length > 0) {
            blogItems.forEach((item, index) => {
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, 100 * index);
            });
        }

        // Dropdown functionality
        const dropdowns = document.querySelectorAll('.filter-dropdown');

        dropdowns.forEach(dropdown => {
            const toggle = dropdown.querySelector('.filter-dropdown-toggle');

            toggle.addEventListener('click', (e) => {
                e.preventDefault();

                // Close other dropdowns
                dropdowns.forEach(otherDropdown => {
                    if (otherDropdown !== dropdown) {
                        otherDropdown.classList.remove('active');
                    }
                });

                // Toggle current dropdown
                dropdown.classList.toggle('active');
            });
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.filter-dropdown')) {
                dropdowns.forEach(dropdown => {
                    dropdown.classList.remove('active');
                });
            }
        });
    });
</script>
@endsection
