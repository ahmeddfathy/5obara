<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>@yield('title') | خبراء</title>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('assets/img/home/1184773-1.png') }}" type="image/x-icon">

        <!-- CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
        @yield('styles')

        <style>
            /* Critical CSS for components */
            .top-bar {
                background-color: #00b5ad;
                padding: 8px 0;
                color: white;
                display: block !important;
            }
            .main-header {
                background-color: #fff;
                padding: 10px 0;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                display: block !important;
            }
            .main-footer {
                background-color: #f8f9fa;
                padding: 60px 0 0;
                color: #333;
                display: block !important;
            }
            .contact-info a, .social-links a {
                color: white;
                text-decoration: none;
                margin-right: 15px;
            }
        </style>
    </head>
    <body>
        <!-- Top Bar -->
        @include('parts.top-bar')

        <!-- Header -->
        @include('parts.header')

        <!-- Main Content -->
        @yield('content')

        <!-- Footer -->
        @include('parts.footer')

        <!-- JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('assets/js/script.js') }}"></script>
        <script src="{{ asset('assets/js/components.js') }}"></script>
        @yield('scripts')
    </body>
</html>
