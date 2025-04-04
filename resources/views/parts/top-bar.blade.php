<!-- Top Bar -->
<div class="top-bar">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-start">
                <div class="social-links">
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <div class="contact-links">
                    <a href="#">الاستفسارات</a>
                    <a href="tel:+966569617288">+966569617288</a>
                    <a href="#" class="login-link">الدخول</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .top-bar {
        background-color: #00b5ad;
        padding: 8px 0;
        color: white;
    }

    .social-links {
        display: flex;
        align-items: center;
    }

    .social-links a {
        color: white;
        font-size: 16px;
        margin-left: 15px;
        transition: all 0.3s ease;
    }

    .social-links a:hover {
        color: rgba(255, 255, 255, 0.8);
        transform: translateY(-2px);
    }

    .contact-links {
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .contact-links a {
        color: white;
        margin-right: 20px;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .contact-links a:hover {
        color: rgba(255, 255, 255, 0.8);
    }

    .contact-links .login-link {
        font-weight: 500;
    }

    @media (max-width: 767px) {
        .social-links, .contact-links {
            justify-content: center;
            margin: 5px 0;
        }

        .col-md-6.text-end, .col-md-6.text-start {
            text-align: center !important;
        }

        .contact-links a {
            margin: 0 10px;
            font-size: 13px;
        }
    }
</style>
