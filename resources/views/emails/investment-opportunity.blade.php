<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }} | خبراء للاستشارات الاقتصادية</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap');

        body,
        html {
            font-family: 'Cairo', Arial, sans-serif;
            margin: 0;
            padding: 0;
            direction: rtl;
            background-color: #f5f7fa;
            color: #2c3e50;
            line-height: 1.6;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background: #00b5ad;
            color: white;
            padding: 30px 20px;
            text-align: center;
            position: relative;
        }

        .email-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.05);
            z-index: 0;
        }

        .header-content {
            position: relative;
            z-index: 1;
        }

        .logo {
            width: 200px;
            height: auto;
            margin-bottom: 15px;
            border-radius: 10px;
        }

        .email-title {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 10px;
            color: white;
        }

        .email-subtitle {
            margin: 0;
            font-size: 16px;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.9);
        }

        .email-body {
            padding: 30px;
        }

        .investment-type {
            background-color: #edf2f7;
            padding: 12px 20px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
        }

        .investment-type-label {
            font-size: 15px;
            color: #4a5568;
        }

        .investment-type-value {
            font-size: 15px;
            font-weight: 600;
            color: #00b5ad;
        }

        .section-title {
            color: #00b5ad;
            font-size: 20px;
            font-weight: 700;
            margin-top: 25px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #edf2f7;
        }

        .highlights-list {
            background-color: #f8fafc;
            border-radius: 8px;
            padding: 20px 20px 20px 0;
            margin: 15px 0 25px 0;
            border-right: 4px solid #00b5ad;
        }

        .highlights-list li {
            margin-bottom: 10px;
            position: relative;
            padding-right: 5px;
        }

        .highlights-list li:last-child {
            margin-bottom: 0;
        }

        .contact-box {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-top: 25px;
        }

        .contact-title {
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            margin-top: 0;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .contact-info {
            margin: 0;
            padding: 0;
            list-style-type: none;
        }

        .contact-info li {
            margin-bottom: 10px;
        }

        .cta-button {
            display: block;
            margin: 30px auto;
            padding: 15px 30px;
            background-color: #00b5ad;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .cta-button:hover {
            background-color: #008c85;
        }

        .email-footer {
            background-color: #edf2f7;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #4a5568;
        }

        .social-links {
            margin: 15px 0;
        }

        .social-link {
            display: inline-block;
            margin: 0 5px;
            width: 32px;
            height: 32px;
            background-color: #2c3e50;
            border-radius: 50%;
            text-align: center;
            line-height: 32px;
        }

        .social-link img {
            width: 16px;
            height: 16px;
            vertical-align: middle;
        }

        @media screen and (max-width: 600px) {
            .email-container {
                width: 100%;
                margin: 0;
                border-radius: 0;
            }

            .email-body {
                padding: 20px;
            }

            .email-title {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <div class="header-content">
                <img src="data:image/png;base64,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" alt="خبراء للاستشارات الاقتصادية" class="logo">
                <h1 class="email-title">فرصة استثمارية: {{ $subject }}</h1>
                <p class="email-subtitle">فرصة استثمارية مميزة مقدمة من خبراء للاستشارات الاقتصادية</p>
            </div>
        </div>

        <div class="email-body">
            <div class="investment-type">
                <div>
                    <span class="investment-type-label">نوع الاستثمار:</span>
                    <span class="investment-type-value">{{ $investment_type }}</span>
                </div>
                <div>
                    <span class="investment-type-label">قيمة الاستثمار:</span>
                    <span class="investment-type-value">{{ $investment_amount }}</span>
                </div>
                <div>
                    <span class="investment-type-label">الموقع:</span>
                    <span class="investment-type-value">{{ $location }}</span>
                </div>
            </div>

            <h2 class="section-title">تفاصيل الفرصة الاستثمارية</h2>
            <div>
                {!! nl2br(e($description)) !!}
            </div>

            <h2 class="section-title">أهم مميزات الفرصة</h2>
            <ul class="highlights-list">
                @foreach($highlights as $highlight)
                <li>{{ $highlight }}</li>
                @endforeach
            </ul>

            <div class="contact-box">
                <h3 class="contact-title">للتواصل والاستفسار</h3>
                <ul class="contact-info">
                    @foreach($contact_info_array as $line)
                    <li>{{ $line }}</li>
                    @endforeach
                </ul>
            </div>

            <a href="https://5obara.com/investment-opportunities" class="cta-button">استعرض الفرص الاستثمارية الأخرى</a>
        </div>

        <div class="email-footer">
            <div class="social-links">
                <a href="https://www.facebook.com/people/%D8%AE%D8%A8%D8%B1%D8%A7%D8%A1-%D9%84%D9%84%D8%A7%D8%B3%D8%AA%D8%B4%D8%A7%D8%B1%D8%A7%D8%AA-%D8%A7%D9%84%D8%A7%D9%82%D8%AA%D8%B5%D8%A7%D8%AF%D9%8A%D8%A9/61551783909820/" class="social-link" style="display: inline-block; margin: 0 5px; width: 32px; height: 32px; background-color: #3b5998; border-radius: 50%; text-align: center; line-height: 32px; color: white; text-decoration: none;">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAACXBIWXMAAAsTAAALEwEAmpwYAAABGElEQVR4nGNgoAZITU3lS01NFUxNTY1JTU0dnpqauj41NfUYEJ9OTU3dlpqaOjU1NTWaTg745DHUgRtTU1P/A/FfIH6VmpqqQbYBaWlprKmpqRmp/xk+pqWlcRPlgrS0NJkudoafoPDPnGS5H2lpadJkGZCens6empr6DYi/JCcns5FlQGZmJiMw3X8C4iNkuQBqwH9g5F0gyYDMzEyTtLS0f0D8JTk5WYZkA4AuiIAa8CEpKYmdZAPS09OFgRn3b0pKCgfJBgANiMrIyPifkpLCTrIBwMxzDWjAf7LjICMjwwzo919khQEwELmA6f85OTmZmSwDgN5QAdriAXRJBtmBCMxqTMAxfzyIUWQbANXMBJRTQkoWAC77YQwCGE+jAAAAAElFTkSuQmCC" style="width: 16px; height: 16px; vertical-align: middle;" alt="Facebook">
                </a>
                <a href="https://x.com/Khobra_company" class="social-link" style="display: inline-block; margin: 0 5px; width: 32px; height: 32px; background-color: #000000; border-radius: 50%; text-align: center; line-height: 32px; color: white; text-decoration: none;">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAACXBIWXMAAAsTAAALEwEAmpwYAAABEElEQVR4nGNgGLTg////PMBCPfA/MzOTlWQDMjIyOFJTU0NTU1NPp6am/gfitLS0tESSDABqDgJqWgbU+B+IFyQnJ7MSbQDQcHGgpptAjf+g+G9SUhIv0QYkJycbp6am/gNq/AfFb5OSkoSJcgEwwLSAvv4NNOgfEB9JTU3VJ8oAYGBJp6am3gUa8BeIPycnJzsQZQAwsMSAmj4CQ/4vEG9PTk5WJsoAoCaeYIr7D8Q/gPhnampqSHJyMgd5SRko6R8QnwDi1NRUc7IMSEtLE05NTX0JxN+A+HtqaurW1NRUQ5INSEtLk0lNTY0BetkTaLMUSQYMVgAAVyFu9dZlcw8AAAAASUVORK5CYII=" style="width: 16px; height: 16px; vertical-align: middle;" alt="Twitter">
                </a>
                <a href="https://www.instagram.com/" class="social-link" style="display: inline-block; margin: 0 5px; width: 32px; height: 32px; background-color: #e4405f; border-radius: 50%; text-align: center; line-height: 32px; color: white; text-decoration: none;">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAACXBIWXMAAAsTAAALEwEAmpwYAAABGklEQVR4nGNgoAb4//8/MyMjI0dycrJAcnJyVHJy8kIgPpGcnHwNiE8BDdmYnJycnJycnMjIyMhAjgO2AvV9Afr7HxB/B+KnyaG6nkA19BjwHxjYH5OTkxVJdgHQn7rJycl/gBq/A/E5oCHWJBuQnJzsCcQvgZp/AfHG5ORkLpINABrgDTTgO1DDx+TkZEuSDQBqsgZq+gXE95OTkzVINgCoyQKI/wBxTXJyMhfJBgANCEtOTv4LtEGXLAOSkpLYgc7/APT7ErIMAAqwAvFToCt1STbg////DEDNy4F+70xOTmYm2YB///4xAA14DsQK5ITBEmDgnyfVgGnhW/9PjdjyH4hPk+KCnR6r/8+M2vZ/RtS2/9PDt5RQ3TUUAwDCf43PKUXanQAAAABJRU5ErkJggg==" style="width: 16px; height: 16px; vertical-align: middle;" alt="Instagram">
                </a>
                <a href="https://www.linkedin.com/company/%D8%AE%D8%A8%D8%B1%D8%A7%D8%A1-%D9%84%D9%84%D8%A7%D8%B3%D8%AA%D8%B4%D8%A7%D8%B1%D8%A7%D8%AA-%D8%A7%D9%84%D8%A7%D9%82%D8%AA%D8%B5%D8%A7%D8%AF%D9%8A%D8%A9/" class="social-link" style="display: inline-block; margin: 0 5px; width: 32px; height: 32px; background-color: #0077b5; border-radius: 50%; text-align: center; line-height: 32px; color: white; text-decoration: none;">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAACXBIWXMAAAsTAAALEwEAmpwYAAAA/0lEQVR4nGNgoBQwMjKyAI0xT05ODgbiaCBeBMSngfhncnLy3+TkZDagGhZSDbjq5fD/ipvpf6BBV4D4f3Jycg0Q5/1PTi4F4vkgNcnJyVNINgBowF0g/gU07CYQhwAN4AViXiD+DDQkD6h2M0kGADULAQ14BgzUFUDD+UC4N9gcIN4G1CNItAvMzc2Zge5dAAxE3//Jyed8fX2ZiTIAqNkSGO9/gAb8AeIZQI0c5BYmx4EafwPxJJIMSElJ4QJq/gDE30BqSTYAaIgK0IBtQFecAuJYkg2AWsACFLwEjI/fQJxGtgEwAyxMTf8D8V+gCzKA2INsA6AGsQKxBBALkmLAoAIA7M1P5fOaHW4AAAAASUVORK5CYII=" style="width: 16px; height: 16px; vertical-align: middle;" alt="LinkedIn">
                </a>
            </div>

            <p>© {{ date('Y') }} خبراء للاستشارات الاقتصادية. جميع الحقوق محفوظة.</p>
            <p>تم إرسال هذا البريد الإلكتروني لأنك مشترك في قائمة الفرص الاستثمارية لدينا.</p>
        </div>
    </div>
</body>

</html>