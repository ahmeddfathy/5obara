<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب جديد - خبراء</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/auth.css') }}" rel="stylesheet">

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

            <h4 class="text-center mb-4 fw-bold text-dark">انضم إلينا الآن!</h4>

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

                <button type="submit" class="btn custom-btn w-100 mb-3">
                    <i class="fas fa-user-plus me-2"></i>إنشاء حساب
                </button>

                <div class="d-flex justify-content-center">
                    <a href="{{ route('login') }}" class="text-decoration-none">
                        <i class="fas fa-sign-in-alt me-2"></i>لديك حساب بالفعل؟
                    </a>
                </div>
            </form>

            <div class="mt-4 text-center">
                <small class="text-muted">بالتسجيل، أنت توافق على تلقي إشعارات من منصة خبراء</small>
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
        (function() {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            // Basic password strength check
            const password = this.value;
            const passwordStrength = calculatePasswordStrength(password);

            // You could add a visual indicator here if desired
        });

        function calculatePasswordStrength(password) {
            let strength = 0;

            if (password.length >= 8) strength += 1;
            if (password.match(/[a-z]+/)) strength += 1;
            if (password.match(/[A-Z]+/)) strength += 1;
            if (password.match(/[0-9]+/)) strength += 1;
            if (password.match(/[^a-zA-Z0-9]+/)) strength += 1;

            return strength;
        }
    </script>
</body>

</html>