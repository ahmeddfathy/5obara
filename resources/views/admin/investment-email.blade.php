@extends('layouts.admin')

@section('title', 'إرسال الفرص الاستثمارية')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/investment-email.css') }}?t={{ time() }}">
@endsection

@section('header')
<div class="admin-header admin-fade-in">
    <h1 class="admin-title">إرسال الفرص الاستثمارية عبر البريد الإلكتروني</h1>
    <div class="admin-actions">
        <a href="{{ route('admin.dashboard') }}" class="admin-action-btn">
            <i class="fas fa-arrow-right"></i>
            <span>العودة للوحة التحكم</span>
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="investment-email-form admin-fade-in admin-fade-in-1">
            <div class="investment-form-header">
                <img src="{{ asset('assets/img/home/logo.jpg') }}" alt="خبراء" class="investment-logo">
                <h2>إرسال فرصة استثمارية</h2>
                <p>أرسل تفاصيل الفرصة الاستثمارية إلى المستثمرين المهتمين</p>
            </div>
            <div class="investment-form-body">
                <form action="{{ route('admin.investment.send-email') }}" method="POST" id="investmentForm">
                    @csrf

                    <div class="investment-form-group">
                        <label class="investment-form-label">المستلمون</label>
                        <div class="alert alert-info">
                            سيتم إرسال الفرصة الاستثمارية إلى جميع المشتركين في النشرة البريدية
                            <br>
                            <strong>عدد المشتركين الحاليين: {{ $recipientCount }}</strong>
                        </div>
                    </div>

                    <div class="investment-form-group">
                        <label class="investment-form-label">عنوان الفرصة الاستثمارية</label>
                        <input type="text" name="subject" class="investment-form-input" placeholder="أدخل عنوان الفرصة الاستثمارية" required>
                    </div>

                    <div class="investment-form-group">
                        <label class="investment-form-label">نوع الاستثمار</label>
                        <select name="investment_type" class="investment-form-select" required>
                            <option value="">اختر نوع الاستثمار</option>
                            <option value="real_estate">عقاري</option>
                            <option value="commercial">تجاري</option>
                            <option value="industrial">صناعي</option>
                            <option value="agricultural">زراعي</option>
                            <option value="other">أخرى</option>
                        </select>
                    </div>

                    <div class="investment-form-group">
                        <label class="investment-form-label">قيمة الاستثمار</label>
                        <input type="text" name="investment_amount" class="investment-form-input" placeholder="أدخل قيمة الاستثمار" required>
                    </div>

                    <div class="investment-form-group">
                        <label class="investment-form-label">الموقع</label>
                        <input type="text" name="location" class="investment-form-input" placeholder="أدخل موقع المشروع" required>
                    </div>

                    <div class="investment-form-group">
                        <label class="investment-form-label">وصف الفرصة الاستثمارية</label>
                        <textarea name="description" class="investment-form-textarea" rows="6" placeholder="أدخل وصف تفصيلي للفرصة الاستثمارية" required></textarea>
                    </div>

                    <div class="investment-form-group">
                        <label class="investment-form-label">أهم مميزات الفرصة الاستثمارية</label>
                        <textarea name="highlights" class="investment-form-textarea" rows="4" placeholder="أدخل أهم مميزات الفرصة الاستثمارية (نقاط منفصلة بسطر جديد)" required></textarea>
                    </div>

                    <div class="investment-form-group">
                        <label class="investment-form-label">بيانات التواصل</label>
                        <textarea name="contact_info" class="investment-form-textarea" rows="3" placeholder="أدخل بيانات التواصل" required></textarea>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="preview" id="previewCheckbox">
                        <label class="form-check-label" for="previewCheckbox">
                            معاينة قبل الإرسال
                        </label>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="investment-form-submit">
                            <i class="fas fa-paper-plane"></i>
                            إرسال الفرصة الاستثمارية
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="admin-card admin-fade-in admin-fade-in-2">
            <div class="admin-card-header">
                <h2 class="admin-card-title">إحصائيات الرسائل</h2>
            </div>
            <div class="admin-card-body">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>الرسائل المرسلة اليوم</span>
                        <span class="badge bg-primary rounded-pill">{{ $todaySentCount }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>إجمالي الرسائل المرسلة</span>
                        <span class="badge bg-success rounded-pill">{{ $totalSentCount }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>إجمالي المستلمين</span>
                        <span class="badge bg-info rounded-pill">{{ $recipientCount }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="admin-card admin-fade-in admin-fade-in-3 mt-4">
            <div class="admin-card-header">
                <h2 class="admin-card-title">القوالب الجاهزة</h2>
            </div>
            <div class="admin-card-body">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action d-flex align-items-center template-item" data-type="real_estate">
                        <i class="fas fa-building me-2"></i>
                        <span>فرصة استثمارية عقارية</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex align-items-center template-item" data-type="commercial">
                        <i class="fas fa-store me-2"></i>
                        <span>فرصة استثمارية تجارية</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex align-items-center template-item" data-type="industrial">
                        <i class="fas fa-industry me-2"></i>
                        <span>فرصة استثمارية صناعية</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex align-items-center template-item" data-type="agricultural">
                        <i class="fas fa-leaf me-2"></i>
                        <span>فرصة استثمارية زراعية</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">معاينة البريد الإلكتروني</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="preview-container">
                    <div class="preview-header">
                        <div class="preview-logo">
                            <img src="{{ asset('assets/img/home/logo.jpg') }}" alt="خبراء" height="40">
                        </div>
                        <div class="preview-title" id="previewSubject"></div>
                    </div>
                    <div class="preview-content" id="previewContent">
                        <!-- محتوى المعاينة سيظهر هنا -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-primary" id="sendAfterPreview">إرسال</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const investmentForm = document.getElementById('investmentForm');
        const previewCheckbox = document.getElementById('previewCheckbox');

        // معالجة نموذج الإرسال
        investmentForm.addEventListener('submit', function(e) {
            if (previewCheckbox.checked) {
                e.preventDefault();
                showPreview();
            }
        });

        // إظهار المعاينة
        function showPreview() {
            const formData = new FormData(investmentForm);
            const subject = formData.get('subject');
            const investmentType = document.querySelector('select[name="investment_type"]').selectedOptions[0].text;
            const investmentAmount = formData.get('investment_amount');
            const location = formData.get('location');
            const description = formData.get('description');
            const highlights = formData.get('highlights').split('\n').filter(item => item.trim() !== '');
            const contactInfo = formData.get('contact_info');

            document.getElementById('previewSubject').textContent = subject;

            let previewContent = `
                <div style="margin-bottom: 20px;">
                    <h3 style="color: #00b5ad;">فرصة استثمارية: ${subject}</h3>
                    <p><strong>نوع الاستثمار:</strong> ${investmentType}</p>
                    <p><strong>قيمة الاستثمار:</strong> ${investmentAmount}</p>
                    <p><strong>الموقع:</strong> ${location}</p>
                    <hr style="border-top: 1px solid #eee; margin: 15px 0;">
                    <h4 style="color: #2c3e50;">تفاصيل الفرصة:</h4>
                    <p>${description.replace(/\n/g, '<br>')}</p>
                    <h4 style="color: #2c3e50;">أهم المميزات:</h4>
                    <ul>
            `;

            highlights.forEach(item => {
                previewContent += `<li>${item}</li>`;
            });

            previewContent += `
                    </ul>
                    <hr style="border-top: 1px solid #eee; margin: 15px 0;">
                    <h4 style="color: #2c3e50;">للتواصل:</h4>
                    <p>${contactInfo.replace(/\n/g, '<br>')}</p>
                </div>
            `;

            document.getElementById('previewContent').innerHTML = previewContent;

            const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
            previewModal.show();

            // إرسال بعد المعاينة
            document.getElementById('sendAfterPreview').addEventListener('click', function() {
                previewCheckbox.checked = false;
                investmentForm.submit();
            });
        }

        // تعبئة القوالب الجاهزة
        document.querySelectorAll('.template-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const type = this.getAttribute('data-type');
                fillTemplate(type);
            });
        });

        // تعبئة القالب حسب النوع
        function fillTemplate(type) {
            const templates = {
                real_estate: {
                    subject: 'فرصة استثمارية مميزة في القطاع العقاري',
                    type: 'real_estate',
                    amount: '1,000,000 - 5,000,000 ريال',
                    location: 'الرياض - حي الملقا',
                    description: 'فرصة استثمارية مميزة في مجمع سكني فاخر بموقع استراتيجي في شمال الرياض. المشروع عبارة عن مجمع سكني متكامل الخدمات يحتوي على شقق سكنية بمساحات مختلفة.\n\nالمشروع قيد الإنشاء حالياً وقد تم الانتهاء من 70% من الأعمال الإنشائية. المشروع مرخص ومعتمد من كافة الجهات الحكومية، وتم التعاقد مع شركات مقاولات من الفئة الأولى.',
                    highlights: 'عائد استثماري سنوي متوقع 15%\nموقع استراتيجي بالقرب من الطرق الرئيسية\nمرافق وخدمات متكاملة\nإمكانية البيع على الخارطة\nفترة استرداد رأس المال 5 سنوات',
                    contact: 'مكتب خبراء للاستشارات الاقتصادية\nهاتف: 0569617288\nالبريد الإلكتروني: info@5obara.com'
                },
                commercial: {
                    subject: 'فرصة استثمارية في قطاع التجزئة التجاري',
                    type: 'commercial',
                    amount: '3,000,000 - 7,000,000 ريال',
                    location: 'جدة - شارع التحلية',
                    description: 'فرصة استثمارية نادرة في مجمع تجاري حديث بموقع حيوي في شارع التحلية بجدة. المشروع عبارة عن مجمع تجاري على مساحة 5,000 متر مربع يضم محلات تجارية ومطاعم ومكاتب.\n\nالمشروع جاهز للتشغيل وقد تم تأجير 60% من المساحات التجارية لعلامات تجارية مرموقة.',
                    highlights: 'عائد استثماري سنوي متوقع 18%\nموقع تجاري متميز وحيوي\nعقود إيجار طويلة الأمد\nتصميم عصري وفريد\nخدمات إدارية متكاملة',
                    contact: 'إدارة الاستثمار - شركة خبراء\nهاتف: 0569617288\nالبريد الإلكتروني: investment@5obara.com'
                },
                industrial: {
                    subject: 'فرصة استثمارية صناعية في مدينة سدير الصناعية',
                    type: 'industrial',
                    amount: '10,000,000 - 15,000,000 ريال',
                    location: 'مدينة سدير الصناعية',
                    description: 'فرصة استثمارية واعدة في القطاع الصناعي بمدينة سدير الصناعية. المشروع عبارة عن مصنع لإنتاج المواد البلاستيكية بتقنيات حديثة ومتطورة.\n\nتم الحصول على كافة التراخيص اللازمة وتوقيع اتفاقيات توريد مع عدة جهات حكومية وشركات كبرى.',
                    highlights: 'عائد استثماري سنوي متوقع 22%\nحوافز وإعفاءات من الدولة\nصناعة مستدامة وصديقة للبيئة\nإمكانية التصدير للأسواق الإقليمية\nفريق إداري وفني متكامل',
                    contact: 'الرئيس التنفيذي - خبراء للاستشارات\nهاتف: 0569617288\nالبريد الإلكتروني: ceo@5obara.com'
                },
                agricultural: {
                    subject: 'فرصة استثمارية زراعية في منطقة القصيم',
                    type: 'agricultural',
                    amount: '5,000,000 - 8,000,000 ريال',
                    location: 'منطقة القصيم',
                    description: 'فرصة استثمارية واعدة في القطاع الزراعي بمنطقة القصيم. المشروع عبارة عن مزرعة متكاملة لإنتاج محاصيل عضوية باستخدام تقنيات الزراعة الحديثة وأنظمة الري المتطورة.\n\nالمشروع حاصل على شهادات الجودة العالمية وتم توقيع عقود توريد مع كبرى سلاسل التجزئة.',
                    highlights: 'عائد استثماري سنوي متوقع 20%\nدعم حكومي للمشاريع الزراعية\nمنتجات عضوية عالية الجودة\nتقنيات زراعية مستدامة\nخطط توسعية مستقبلية',
                    contact: 'مستشار الاستثمار الزراعي - خبراء\nهاتف: 0569617288\nالبريد الإلكتروني: agri@5obara.com'
                }
            };

            const template = templates[type];

            document.querySelector('input[name="subject"]').value = template.subject;
            document.querySelector('select[name="investment_type"]').value = type;
            document.querySelector('input[name="investment_amount"]').value = template.amount;
            document.querySelector('input[name="location"]').value = template.location;
            document.querySelector('textarea[name="description"]').value = template.description;
            document.querySelector('textarea[name="highlights"]').value = template.highlights;
            document.querySelector('textarea[name="contact_info"]').value = template.contact;
        }
    });
</script>
@endsection