<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رسالة من موقع خبراء</title>
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
            <h1>رسالة جديدة من موقع خبراء</h1>
        </div>
        <div class="content">
            <div class="item">
                <div class="label">الاسم:</div>
                <div class="value">{{ $formData['name'] }}</div>
            </div>

            <div class="item">
                <div class="label">رقم الهاتف:</div>
                <div class="value">+966{{ $formData['phone'] }}</div>
            </div>

            <div class="item">
                <div class="label">نوع الاستفسار:</div>
                <div class="value">{{ $formData['inquiry_type'] }}</div>
            </div>

            <div class="item">
                <div class="label">المدينة:</div>
                <div class="value">{{ $formData['city'] }}</div>
            </div>

            <div class="item">
                <div class="label">الرسالة:</div>
                <div class="value">{{ $formData['message'] }}</div>
            </div>
        </div>

        <div class="footer">
            تم إرسال هذه الرسالة من نموذج الاتصال على موقع خبراء
            <br>
            www.5obara.com
        </div>
    </div>
</body>
</html>
