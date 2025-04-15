<!-- Footer -->
<footer>
    @if(session('success'))
        <div class="toast-message" id="successToast">
            <i class="fas fa-check-circle ml-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="container-fluid">
        <div class="row">
            <!-- Contact Methods Section -->
            <div class="col-md-6">
                <h3 class="footer-heading">طرق التواصل معنا</h3>
                <div class="contact-methods-grid">
                    <div class="contact-method-group">
                        <a href="https://www.facebook.com/people/%D8%AE%D8%A8%D8%B1%D8%A7%D8%A1-%D9%84%D9%84%D8%A7%D8%B3%D8%AA%D8%B4%D8%A7%D8%B1%D8%A7%D8%AA-%D8%A7%D9%84%D8%A7%D9%82%D8%AA%D8%B5%D8%A7%D8%AF%D9%8A%D8%A9/61551783909820/" target="_blank" aria-label="Facebook">
                            <div class="contact-method">
                                <span class="contact-label">Facebook</span>
                                <i class="fab fa-facebook-f"></i>
                            </div>
                        </a>
                        <a href="https://x.com/Khobra_company" target="_blank" aria-label="Twitter">
                            <div class="contact-method">
                                <span class="contact-label">Twitter</span>
                                <i class="fab fa-twitter"></i>
                            </div>
                        </a>
                        <a href="https://www.instagram.com/" target="_blank" aria-label="Instagram">
                            <div class="contact-method">
                                <span class="contact-label">Instagram</span>
                                <i class="fab fa-instagram"></i>
                            </div>
                        </a>
                        <a href="https://www.linkedin.com/company/%D8%AE%D8%A8%D8%B1%D8%A7%D8%A1-%D9%84%D9%84%D8%A7%D8%B3%D8%AA%D8%B4%D8%A7%D8%B1%D8%A7%D8%AA-%D8%A7%D9%84%D8%A7%D9%82%D8%AA%D8%B5%D8%A7%D8%AF%D9%8A%D8%A9/" target="_blank" aria-label="LinkedIn">
                            <div class="contact-method">
                                <span class="contact-label">LinkedIn</span>
                                <i class="fab fa-linkedin-in"></i>
                            </div>
                        </a>
                    </div>
                    <div class="contact-method-group">
                        <a href="mailto:info@5obara.com" aria-label="Email">
                            <div class="contact-method">
                                <span class="contact-label">info@5obara.com</span>
                                <i class="far fa-envelope"></i>
                            </div>
                        </a>
                        <a href="tel:+966569617288" aria-label="Phone">
                            <div class="contact-method">
                                <span class="contact-label">+966569617288</span>
                                <i class="fas fa-phone"></i>
                            </div>
                        </a>
                        <a href="#" aria-label="Mobile">
                            <div class="contact-method">
                                <span class="contact-label">+966569617288</span>
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                        </a>
                        <a href="https://wa.me/966569617288" aria-label="WhatsApp">
                            <div class="contact-method">
                                <span class="contact-label">+966569617288</span>
                                <i class="fab fa-whatsapp"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form Section -->
            <div class="col-md-6">
                <div class="contact-form-container">
                    <h3 class="footer-form-heading">أرسل لنا رسالة</h3>
                    <div class="footer-form">
                        <form class="contact-form" action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            <input type="hidden" name="email_to" value="ahmeddfathy087@gmail.com">
                            <div class="form-row">
                                <input type="text" name="name" class="form-control" placeholder="الاسم" required>
                            </div>
                            <div class="form-row phone-row">
                                <div class="input-group">
                                    <input type="text" name="phone" class="form-control" placeholder="مثال: 544902462" required>
                                    <div class="footer-country-code">966+</div>
                                </div>
                                <select name="inquiry_type" class="form-control" required>
                                    <option selected value="استشارة">استشارة</option>
                                    <option value="استفسار">استفسار</option>
                                    <option value="أخرى">أخرى</option>
                                </select>
                            </div>
                            <div class="form-row">
                                <input type="text" name="city" class="form-control" placeholder="بأي مدينة مشروعك؟" required>
                            </div>
                            <div class="form-row">
                                <textarea name="message" class="form-control" rows="4" placeholder="الرسالة" required></textarea>
                            </div>
                            <div class="form-row">
                                <button type="submit" class="btn-submit">إرسال</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vision Logo and Copyright -->
        <div class="vision-copyright">
            <div class="vision2030">
                <img src="{{ asset('assets/img/footer-logo.png') }}" alt="رؤية 2030" class="vision-logo">
                <!-- Social Media Links on Logo -->
                <div class="social-links">
                    <a href="https://www.facebook.com/people/%D8%AE%D8%A8%D8%B1%D8%A7%D8%A1-%D9%84%D9%84%D8%A7%D8%B3%D8%AA%D8%B4%D8%A7%D8%B1%D8%A7%D8%AA-%D8%A7%D9%84%D8%A7%D9%82%D8%AA%D8%B5%D8%A7%D8%AF%D9%8A%D8%A9/61551783909820/" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://x.com/Khobra_company" target="_blank" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.instagram.com/" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.linkedin.com/company/%D8%AE%D8%A8%D8%B1%D8%A7%D8%A1-%D9%84%D9%84%D8%A7%D8%B3%D8%AA%D8%B4%D8%A7%D8%B1%D8%A7%D8%AA-%D8%A7%D9%84%D8%A7%D9%82%D8%AA%D8%B5%D8%A7%D8%AF%D9%8A%D8%A9/" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <p class="footer-copy">جميع الحقوق محفوظة © {{ date('Y') }}</p>
        </div>
    </div>
</footer>

<!-- Chat Buttons -->
<div class="chat-btns">
    <a href="https://wa.me/966569617288" class="chat-btn whatsapp" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>
    <a href="https://www.facebook.com/people/%D8%AE%D8%A8%D8%B1%D8%A7%D8%A1-%D9%84%D9%84%D8%A7%D8%B3%D8%AA%D8%B4%D8%A7%D8%B1%D8%A7%D8%AA-%D8%A7%D9%84%D8%A7%D9%82%D8%AA%D8%B5%D8%A7%D8%AF%D9%8A%D8%A9/61551783909820/" class="chat-btn messenger" target="_blank">
        <i class="fab fa-facebook-messenger"></i>
    </a>
</div>

<script>
    // Auto hide toast messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const toasts = document.querySelectorAll('.toast-message');

        toasts.forEach(function(toast) {
            setTimeout(function() {
                toast.classList.add('hide');
                setTimeout(function() {
                    toast.remove();
                }, 500);
            }, 5000);
        });
    });
</script>
