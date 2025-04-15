<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلب استثمار من موقع خبراء</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #000000;
            padding: 0;
            margin: 0;
            direction: rtl;
            text-align: right;
            background-color: #f9f9f9;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        .header {
            background-color: #3CBFAE;
            color: white;
            padding: 25px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 600;
            color: white;
            padding-bottom: 0;
            letter-spacing: 0.5px;
        }
        .logo-container {
            text-align: center;
            background-color: white;
            padding: 25px 0 10px;
            border-bottom: 1px solid #f0f0f0;
        }
        .logo-text {
            font-size: 32px;
            font-weight: bold;
            color: #3CBFAE;
            margin: 0;
        }
        .content {
            padding: 30px;
            background-color: #ffffff;
        }
        .item {
            margin-bottom: 20px;
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 15px;
        }
        .item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        .label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #3CBFAE;
            font-size: 14px;
        }
        .value {
            padding: 15px;
            background-color: #f9f9f9;
            border-right: 3px solid #3CBFAE;
            border-radius: 4px;
            font-size: 15px;
            color: #000000;
        }
        .footer {
            margin-top: 0;
            background-color: #f9f9f9;
            color: #666;
            padding: 20px 30px;
            font-size: 14px;
            text-align: center;
            border-top: 3px solid #3CBFAE;
        }
        .top-bar {
            height: 6px;
            background-color: #3CBFAE;
        }
        .form-tag {
            display: inline-block;
            background-color: #3CBFAE;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            margin-bottom: 15px;
        }
        .source-info {
            background-color: #f0faf9;
            padding: 10px 15px;
            border-radius: 4px;
            margin-top: 20px;
            border: 1px dashed #3CBFAE;
            font-size: 13px;
            color: #666;
        }
        .source-info p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="top-bar"></div>
        <div class="logo-container">
            <!-- Embedded Logo as Text -->
            <div class="logo-text">خبراء</div>
        </div>
        <div class="header">
            <h1>طلب استثمار جديد من موقع خبراء</h1>
        </div>
        <div class="content">
            <div class="form-tag">{{ $formData['source'] ?? 'نموذج الاستثمار' }}</div>

            <div class="item">
                <div class="label">الاسم:</div>
                <div class="value">{{ $formData['name'] }}</div>
            </div>

            <div class="item">
                <div class="label">البريد الإلكتروني:</div>
                <div class="value">{{ $formData['email'] }}</div>
            </div>

            <div class="item">
                <div class="label">رقم الهاتف:</div>
                <div class="value">{{ $formData['phone'] }}</div>
            </div>

            <div class="item">
                <div class="label">المبلغ المراد استثماره:</div>
                <div class="value">{{ $formData['investment_amount'] }}</div>
            </div>

            <div class="source-info">
                <p><strong>مصدر الطلب:</strong> {{ $formData['source'] ?? 'نموذج الاستثمار' }}</p>
                <p><strong>وقت الإرسال:</strong> {{ $formData['submission_time'] ?? now() }}</p>
                @if(isset($formData['source_url']))
                <p><strong>رابط المصدر:</strong> {{ $formData['source_url'] }}</p>
                @endif
            </div>
        </div>

        <div class="footer">
            تم إرسال هذه الرسالة من نموذج الاستثمار على موقع خبراء
            <br>
            www.5obara.com
        </div>
    </div>
</body>
</html>
