<!-- Newsletter Subscription -->
<div class="newsletter-container">
    <div class="newsletter-content">
        <div class="newsletter-icon">
            <i class="far fa-envelope-open"></i>
        </div>
        <div class="newsletter-text">
            <h3>اشترك في نشرتنا البريدية</h3>
            <p>انضم إلينا للحصول على أحدث الأخبار والعروض الحصرية من خبراء للاستشارات الاقتصادية</p>
        </div>
        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="newsletter-form">
            @csrf
            <div class="newsletter-inputs">
                <div class="input-group">
                    <div class="input-icon-wrapper">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" name="name" placeholder="الاسم الكريم" required value="{{ old('name') }}" class="@error('name') is-invalid @enderror">
                    </div>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input-group">
                    <div class="input-icon-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" placeholder="البريد الإلكتروني" required value="{{ old('email') }}" class="@error('email') is-invalid @enderror">
                    </div>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="newsletter-btn">
                    اشترك الآن
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </form>
    </div>
</div>
