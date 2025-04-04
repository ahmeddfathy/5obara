<!DOCTYPE html>
<html>
<head>
    <title>CKEditor Test</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- تضمين CKEditor 5 -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            direction: rtl;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        #output {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
        }
        .ck-editor__editable {
            min-height: 300px;
            direction: rtl;
        }
        /* تحسين مظهر المحرر للغة العربية */
        .ck.ck-editor__editable_inline {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>اختبار محرر CKEditor</h1>

        <div class="form-group">
            <label for="editor">المحتوى:</label>
            <div id="editor">هذا هو اختبار للمحرر</div>
        </div>

        <button type="button" id="check-button">فحص المحتوى</button>
        <div id="output"></div>
    </div>

    <script>
        let editor;

        // تهيئة المحرر عند تحميل الصفحة
        ClassicEditor
            .create(document.querySelector('#editor'), {
                language: 'ar',
                toolbar: {
                    items: [
                        'undo', 'redo',
                        '|', 'heading',
                        '|', 'bold', 'italic',
                        '|', 'link', 'uploadImage', 'blockQuote', 'code',
                        '|', 'bulletedList', 'numberedList',
                        '|', 'alignment',
                        '|', 'indent', 'outdent'
                    ]
                },
                heading: {
                    options: [
                        { model: 'paragraph', title: 'فقرة', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'عنوان 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'عنوان 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'عنوان 3', class: 'ck-heading_heading3' }
                    ]
                }
            })
            .then(newEditor => {
                editor = newEditor;
            })
            .catch(error => {
                console.error(error);
            });

        // زر لفحص المحتوى
        document.getElementById('check-button').addEventListener('click', function() {
            const data = editor.getData();
            document.getElementById('output').innerHTML = '<strong>HTML المخرج:</strong><br>' +
                '<pre style="margin-top:10px;background:#f5f5f5;padding:10px;overflow:auto;direction:ltr;text-align:left">' +
                escapeHtml(data) + '</pre>';
        });

        // دالة لتنظيف رموز HTML للعرض
        function escapeHtml(text) {
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }
    </script>
</body>
</html>
