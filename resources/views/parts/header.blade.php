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

<style>
    .main-header {
        background-color: #fff;
        padding: 10px 0;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .navbar-brand {
        margin-right: 0;
        padding: 0;
    }

    .navbar-nav {
        margin-right: 20px;
    }

    .nav-item {
        margin: 0 12px;
    }

    .nav-link {
        color: #333;
        font-weight: 500;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .nav-link:hover, .nav-link.active {
        color: #00b5ad;
    }

    .header-buttons .btn {
        padding: 8px 16px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .header-buttons .btn-primary {
        background-color: #00b5ad;
        border-color: #00b5ad;
    }

    .header-buttons .btn-primary:hover {
        background-color: #009d96;
        transform: translateY(-2px);
    }

    .header-buttons .btn-success {
        background-color: #25D366;
        border-color: #25D366;
    }

    .header-buttons .btn-success:hover {
        background-color: #20bd5b;
        transform: translateY(-2px);
    }

    @media (max-width: 991px) {
        .navbar-nav {
            margin-right: 0;
            margin-top: 15px;
        }

        .header-buttons {
            margin-top: 15px;
            flex-direction: column;
            width: 100%;
        }

        .header-buttons .btn {
            margin: 5px 0;
            text-align: center;
        }
    }
</style>
