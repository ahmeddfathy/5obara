<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>@yield('title') | خبراء</title>

        <!-- Meta Tags -->
        @yield('meta')

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('assets/img/home/logo.jpg') }}" type="image/x-icon">

        <!-- CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Main CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?t={{ time() }}">


        <!-- Parts CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/parts/top-bar.css') }}?t={{ time() }}">
        <link rel="stylesheet" href="{{ asset('assets/css/parts/header.css') }}?t={{ time() }}">
        <link rel="stylesheet" href="{{ asset('assets/css/parts/footer.css') }}?t={{ time() }}">
        <link rel="stylesheet" href="{{ asset('assets/css/parts/newsletter.css') }}?t={{ time() }}">

        @yield('styles')
    </head>
    <body>
        <!-- Top Bar -->
        @include('parts.top-bar')

        <!-- Header -->
        @include('parts.header')

        <!-- Main Content -->
        @yield('content')

        <!-- Newsletter -->
        @include('parts.newsletter')

        <!-- Footer -->
        @include('parts.footer')

        <!-- JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('assets/js/script.js') }}?t={{ time() }}"></script>

        @yield('scripts')
        @include('components.firebase-messaging')

    </body>
</html>
