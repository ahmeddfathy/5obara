<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب جديد - خبراء</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('assets/css/auth.css') }}" rel="stylesheet">
    <style>
        .register-container {
            max-width: 400px;
            margin: 40px auto;
            padding: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .logo {
            width: 200px;
            margin: 0 auto 30px;
            display: block;
        }
        .custom-btn {
            background-color: #4FD1C5;
            border: none;
            color: white;
            padding: 10px 20px;
        }
        .custom-btn:hover {
            background-color: #38B2AC;
        }
        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .terms-text {
            font-size: 14px;
            color: #6c757d;
        }
        .terms-text a {
            color: #4FD1C5;
            text-decoration: none;
        }
        .terms-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="auth-container">
            <img src="{{ asset('assets/img/home/logo.jpg') }}" alt="خبراء" class="logo">

            @if ($errors->any())
                <div class="error-message">
                    <ul class="list-unstyled m-0">
                        @foreach ($errors->all() as $error)
                            <li><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
                @csrf

                <div class="form-floating mb-4">
                    <input type="text" class="form-control" id="name" name="name"
                           value="{{ old('name') }}" required autofocus
                           placeholder="الاسم">
                    <label for="name">
                        <i class="fas fa-user me-2"></i>الاسم
                    </label>
                </div>

                <div class="form-floating mb-4">
                    <input type="email" class="form-control" id="email" name="email"
                           value="{{ old('email') }}" required
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

                <div class="form-floating mb-4">
                    <input type="password" class="form-control" id="password_confirmation"
                           name="password_confirmation" required
                           placeholder="تأكيد كلمة المرور">
                    <label for="password_confirmation">
                        <i class="fas fa-lock me-2"></i>تأكيد كلمة المرور
                    </label>
                    <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted pe-3"
                            onclick="togglePassword('password_confirmation')">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="terms-container">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="terms" id="terms" required>
                            <label class="form-check-label terms-text" for="terms">
                                <i class="fas fa-check-circle me-2"></i>
                                أوافق على <a href="{{ route('terms.show') }}" target="_blank">شروط الخدمة</a> و
                                <a href="{{ route('policy.show') }}" target="_blank">سياسة الخصوصية</a>
                            </label>
                        </div>
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <a href="{{ route('login') }}" class="text-decoration-none">
                        <i class="fas fa-sign-in-alt me-2"></i>لديك حساب بالفعل؟
                    </a>
                    <button type="submit" class="btn custom-btn">
                        <i class="fas fa-user-plus me-2"></i>إنشاء حساب
                    </button>
                </div>
            </form>
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
