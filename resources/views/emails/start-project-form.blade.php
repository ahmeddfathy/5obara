<!DOCTYPE html>
<html>

<head>
    <title>طلب مشروع جديد - خبراء</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            direction: rtl;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .header {
            background-color: #00b5ad;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            color: white;
            margin: 0;
            font-size: 24px;
        }

        .content {
            background-color: white;
            padding: 20px;
            border-radius: 0 0 5px 5px;
        }

        .footer {
            text-align: center;
            padding: 15px;
            font-size: 12px;
            color: #777;
        }

        .data-item {
            margin-bottom: 15px;
        }

        .label {
            font-weight: bold;
            color: #00b5ad;
        }

        .value {
            color: #000;
        }

        .source-info {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>طلب مشروع جديد - خبراء</h1>
        </div>

        <div class="content">
            <div class="data-item">
                <div class="label">الاسم:</div>
                <div class="value">{{ $data['name'] }}</div>
            </div>

            <div class="data-item">
                <div class="label">رقم الهاتف:</div>
                <div class="value">{{ $data['phone'] }}</div>
            </div>

            <div class="data-item">
                <div class="label">البريد الإلكتروني:</div>
                <div class="value">{{ $data['email'] }}</div>
            </div>

            <div class="data-item">
                <div class="label">نوع المشروع:</div>
                <div class="value">{{ $data['project_type'] }}</div>
            </div>

            <div class="data-item">
                <div class="label">وصف المشروع:</div>
                <div class="value">{{ $data['description'] }}</div>
            </div>

            @if(isset($data['budget']) && !empty($data['budget']))
            <div class="data-item">
                <div class="label">الميزانية المتوقعة:</div>
                <div class="value">{{ $data['budget'] }}</div>
            </div>
            @endif

            <div class="source-info">
                <p>تم إرسال هذا الطلب من: {{ $data['source'] }}</p>
                <p>وقت الإرسال: {{ $data['submission_time'] }}</p>
                <p>مصدر الطلب: {{ $data['source_url'] }}</p>
            </div>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} خبراء | جميع الحقوق محفوظة</p>
        </div>
    </div>
</body>

</html>