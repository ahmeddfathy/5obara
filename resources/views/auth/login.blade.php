<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - خبراء</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('assets/css/auth.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="auth-container">
            <img src="{{ asset(path: 'assets/img/home/logo.jpg') }}" alt="خبراء" class="logo">

            @if ($errors->any())
                <div class="error-message">
                    <ul class="list-unstyled m-0">
                        @foreach ($errors->all() as $error)
                            <li><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="success-message">
                    <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                @csrf

                <div class="form-floating mb-4">
                    <input type="email" class="form-control" id="email" name="email"
                           value="{{ old('email') }}" required autofocus
                           placeholder="البريد الإلكتروني">
                    <label for="email">
                        <i class="fas fa-envelope me-2"></i>البريد الإلكتروني
                    </label>
                </div>

                <div class="form-floating mb-4">
                    <input type="password" class="form-control" id="password"
                           name="password" required
                           placeholder="كلمة المرور">
                    <label for="password">
                        <i class="fas fa-lock me-2"></i>كلمة المرور
                    </label>
                    <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted pe-3"
                            onclick="togglePassword('password')">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                    <label class="form-check-label" for="remember_me">
                        <i class="fas fa-check-circle me-2"></i>تذكرني
                    </label>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-decoration-none">
                            <i class="fas fa-key me-2"></i>نسيت كلمة المرور؟
                        </a>
                    @endif
                    <button type="submit" class="btn custom-btn">
                        <i class="fas fa-sign-in-alt me-2"></i>تسجيل الدخول
                    </button>
                </div>
            </form>

            <div class="auth-links">
                <p class="mb-0">ليس لديك حساب؟
                    <a href="{{ route('register') }}">
                        <i class="fas fa-user-plus me-1"></i>إنشاء حساب جديد
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = event.currentTarget.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Form validation
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>
</html>
