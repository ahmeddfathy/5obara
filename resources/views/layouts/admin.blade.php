<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'لوحة التحكم') | خبراء</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/img/home/logo.jpg') }}" type="image/x-icon">

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    @yield('styles')
</head>
<body class="admin-panel">
    <div class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <img src="{{ asset('assets/img/home/logo.jpg') }}" alt="خبراء" class="sidebar-logo">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- User Profile Section in Sidebar -->
        <div class="sidebar-user-profile">
            <div class="sidebar-user-avatar">
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=0D8ABC&color=fff" alt="User Avatar">
            </div>
            <div class="sidebar-user-info">
                <h4 class="sidebar-user-name">{{ Auth::user()->name ?? 'المدير' }}</h4>
                <span class="sidebar-user-role">مدير النظام</span>
            </div>
        </div>

        <ul class="sidebar-menu">
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <div class="sidebar-menu-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <span class="sidebar-menu-text">لوحة التحكم</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.posts.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                    <div class="sidebar-menu-icon">
                        <i class="fas fa-newspaper"></i>
                        </div>
                    <span class="sidebar-menu-text">المقالات</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.portfolio.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.portfolio.*') ? 'active' : '' }}">
                    <div class="sidebar-menu-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <span class="sidebar-menu-text">المشاريع</span>
                </a>
            </li>



            <!-- Separator in Sidebar Menu -->
            <li class="sidebar-divider"><span>الحساب الشخصي</span></li>

            <li class="sidebar-menu-item">
                <a href="#" class="sidebar-menu-link">
                    <div class="sidebar-menu-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="sidebar-menu-text">الملف الشخصي</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                    @csrf
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();" class="sidebar-menu-link sidebar-menu-link-danger">
                        <div class="sidebar-menu-icon">
                            <i class="fas fa-sign-out-alt"></i>
                        </div>
                        <span class="sidebar-menu-text">تسجيل الخروج</span>
                    </a>
                </form>
            </li>
        </ul>
    </div>

    <div class="admin-main" id="adminMain">
        <!-- Top Navigation Bar -->
        <div class="admin-top-navbar">
            <div class="admin-top-navbar-wrapper">
                <div class="admin-quick-links">
                    <a href="{{ route('admin.dashboard') }}" class="admin-quick-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i> لوحة التحكم
                    </a>
                    <a href="{{ route('admin.posts.index') }}" class="admin-quick-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                        <i class="fas fa-newspaper"></i> المقالات
                    </a>
                    <a href="{{ route('admin.posts.create') }}" class="admin-quick-link {{ request()->routeIs('admin.posts.create') ? 'active' : '' }}">
                        <i class="fas fa-plus-circle"></i> إضافة مقال
                    </a>
                    <a href="{{ route('admin.portfolio.index') }}" class="admin-quick-link {{ request()->routeIs('admin.portfolio.*') ? 'active' : '' }}">
                        <i class="fas fa-briefcase"></i> المشاريع
                    </a>
                    <a href="{{ route('admin.portfolio.create') }}" class="admin-quick-link {{ request()->routeIs('admin.portfolio.create') ? 'active' : '' }}">
                        <i class="fas fa-plus-square"></i> إضافة مشروع
                    </a>

                </div>
                <div class="admin-user-menu">
                    <div class="admin-user-info">
                        <span class="admin-username">{{ Auth::user()->name ?? 'المدير' }}</span>
                        <span class="admin-role">مدير النظام</span>
                    </div>
                    <div class="admin-user-avatar dropdown-toggle" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=0D8ABC&color=fff" alt="User Avatar">
                    </div>
                    <ul class="dropdown-menu user-dropdown-menu" aria-labelledby="userMenu">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> الملف الشخصي</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-bell me-2"></i> الإشعارات</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> الإعدادات</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" id="navLogoutForm">
                                @csrf
                                <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('navLogoutForm').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> تسجيل الخروج
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        @yield('header')

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @yield('content')
            </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('adminSidebar');
            const mainContent = document.getElementById('adminMain');
            const sidebarToggle = document.getElementById('sidebarToggle');

            // Check for saved state
            const sidebarState = localStorage.getItem('sidebarCollapsed');
            if (sidebarState === 'true') {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');

                // Save state to localStorage
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
