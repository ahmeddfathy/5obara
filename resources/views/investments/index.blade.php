@extends('layouts.main')

@section('title', 'الفرص الاستثمارية')

@section('meta')
<meta name="description" content="اكتشف أفضل الفرص الاستثمارية المتاحة في المملكة العربية السعودية. فرص متنوعة في قطاعات مختلفة مع تحليل متكامل وتوقعات العوائد الاستثمارية.">
<meta name="keywords" content="فرص استثمارية، استثمار، مشاريع واعدة، عوائد استثمارية، استثمار في السعودية، مشاريع مربحة، رأس المال، تمويل مشاريع، رؤية 2030">
<meta property="og:title" content="الفرص الاستثمارية | خبراء للاستشارات الاقتصادية">
<meta property="og:description" content="اكتشف أفضل الفرص الاستثمارية المتاحة في المملكة العربية السعودية. فرص متنوعة في قطاعات مختلفة مع تحليل متكامل وتوقعات العوائد الاستثمارية.">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ asset('assets/img/blog/default-post.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="الفرص الاستثمارية | خبراء للاستشارات الاقتصادية">
<meta name="twitter:description" content="اكتشف أفضل الفرص الاستثمارية المتاحة في المملكة العربية السعودية. فرص متنوعة في قطاعات مختلفة مع تحليل متكامل وتوقعات العوائد الاستثمارية.">
<meta name="twitter:image" content="{{ asset('assets/img/blog/default-post.jpg') }}">
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}?t={{ time() }}">
<style>
    .blog-badge {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(0, 181, 173, 0.6);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(0, 181, 173, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(0, 181, 173, 0);
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1>الفرص الاستثمارية</h1>
            <p>اكتشف أحدث الفرص الاستثمارية التي تساعدك على اتخاذ قرارات استثمارية ذكية</p>
        </div>
    </div>
</section>

<!-- Investment Grid -->
<section class="investment-grid">
    <div class="container">

        <!-- Modern Dropdown Filters -->
        <div class="investment-filters mb-4">
            <!-- Categories Dropdown -->
            <div class="filter-dropdown" id="categoryDropdown">
                <div class="filter-dropdown-toggle">
                    <span>{{ request('category') && request('category') !== 'all' ? $categories->firstWhere('id', request('category'))->name : 'جميع القطاعات' }}</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="filter-dropdown-menu">
                    <a href="{{ route('investments.index', array_merge(request()->except('category'), ['category' => 'all'])) }}"
                        class="filter-dropdown-item {{ !request('category') || request('category') === 'all' ? 'active' : '' }}">
                        جميع القطاعات
                    </a>
                    @foreach($categories as $category)
                    <a href="{{ route('investments.index', array_merge(request()->except('category'), ['category' => $category->id])) }}"
                        class="filter-dropdown-item {{ request('category') == $category->id ? 'active' : '' }}">
                        {{ $category->name }}
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Locations Dropdown -->
            <div class="filter-dropdown" id="locationDropdown">
                <div class="filter-dropdown-toggle">
                    <span>{{ request('location') && request('location') !== 'all' ? request('location') : 'جميع المناطق' }}</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="filter-dropdown-menu">
                    <a href="{{ route('investments.index', array_merge(request()->except('location'), ['location' => 'all'])) }}"
                        class="filter-dropdown-item {{ !request('location') || request('location') === 'all' ? 'active' : '' }}">
                        جميع المناطق
                    </a>
                    @foreach($locations as $location)
                    <a href="{{ route('investments.index', array_merge(request()->except('location'), ['location' => $location])) }}"
                        class="filter-dropdown-item {{ request('location') === $location ? 'active' : '' }}">
                        {{ $location }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        @if($investments->isEmpty())
        <div class="empty-state">
            <i class="fas fa-search"></i>
            <h3>لا توجد فرص استثمارية متاحة حالياً</h3>
            <p>يرجى تعديل معايير البحث أو زيارة هذه الصفحة لاحقاً</p>
        </div>
        @else
        <div class="row g-4">
            @foreach($investments as $investment)
            <div class="col-lg-4 col-md-6">
                <div class="blog-item">
                    <div class="blog-img-container">
                        @if($investment->featured_image)
                        <img src="{{ asset('storage/' . $investment->featured_image) }}" alt="{{ $investment->title }}">
                        @else
                        <img src="{{ asset('assets/img/blog/default-post.jpg') }}" alt="{{ $investment->title }}">
                        @endif

                        @if($investment->investment_amount)
                        <div class="blog-badge">{{ number_format((float)$investment->investment_amount) }} ر.س</div>
                        @endif

                        @if($investment->category)
                        <div class="blog-type">{{ $investment->category->name }}</div>
                        @endif
                    </div>
                    <div class="blog-content">
                        <h3>
                            <a href="{{ route('investments.show', $investment->slug) }}">
                                {{ $investment->title }}
                            </a>
                        </h3>
                        <p class="blog-description">
                            {{ Str::limit(strip_tags($investment->content), 150) }}
                        </p>
                        <div class="blog-meta">
                            <div class="blog-date">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $investment->published_at->format('d M, Y') }}
                            </div>
                            <a href="{{ route('investments.show', $investment->slug) }}" class="read-more">
                                عرض التفاصيل
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $investments->links() }}
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
        // Animation for investment items
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
