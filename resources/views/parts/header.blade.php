<!-- Header -->
<header class="main-header">
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid p-0">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('assets/img/home/logo.jpg') }}" alt="خبراء" height="45">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">الرئيسية</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('about-us') ? 'active' : '' }}" href="{{ route('about-us') }}">من نحن</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}" href="{{ route('services') }}">خدماتنا</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('portfolio.index') ? 'active' : '' }}" href="{{ route('portfolio.index') }}">أعمالنا</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('investments.index') || request()->routeIs('investments.show') ? 'active' : '' }}" href="{{ route('investments.index') }}">الفرص الاستثمارية</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}" href="{{ route('blog.index') }}">المدونة</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">اتصل بنا</a>
                        </li>
                    </ul>
                    <div class="header-buttons d-flex">
                        <a href="{{ route('start-your-project') }}" class="btn btn-primary mx-2">ابدأ مشروعك</a>
                        <a href="https://wa.me/966569617288" class="btn btn-success d-flex align-items-center">
                            <i class="fab fa-whatsapp ms-1"></i>
                            تواصل معنا
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>