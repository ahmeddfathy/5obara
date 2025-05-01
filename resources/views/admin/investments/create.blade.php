@extends('layouts.admin')

@section('title', 'إضافة فرصة استثمارية جديدة')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/blog.css') }}?t={{ time() }}">
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<style>
    .hidden {
        display: none;
    }

    .ql-editor {
        min-height: 300px;
        direction: rtl;
        text-align: right;
    }

    .select2-container {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--multiple {
        border-color: var(--post-gray-300);
        border-radius: var(--post-input-radius);
        min-height: 45px;
    }

    .flatpickr-input {
        background-color: white !important;
    }

    .gallery-remove:hover {
        opacity: 1;
        background: rgba(245, 101, 101, 1);
    }

    .is-invalid+.ql-container .ql-editor,
    .is-invalid+.ql-toolbar+.ql-container .ql-editor {
        border: 1px solid #dc3545;
        border-top: none;
    }

    .is-invalid+.ql-toolbar {
        border-color: #dc3545;
    }
</style>
@endsection

@section('content')
<div class="admin-posts-container">
    <!-- Header Section -->
    <div class="admin-posts-header">
        <h1 class="admin-title"><i class="fas fa-plus-circle"></i> إضافة فرصة استثمارية جديدة</h1>
        <p class="admin-subtitle">قم بإضافة فرصة استثمارية جديدة مع كافة البيانات والمعلومات المطلوبة</p>
    </div>

    <!-- Create Form Card -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title"><i class="fas fa-chart-line"></i> بيانات الفرصة الاستثمارية</h2>
            <div class="admin-card-actions">
                <a href="{{ route('admin.investments.index') }}" class="admin-btn admin-btn-outline">
                    <i class="fas fa-arrow-right"></i> العودة للفرص الاستثمارية
                </a>
            </div>
        </div>
        <div class="admin-card-body">
            @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.investments.store') }}" method="POST" enctype="multipart/form-data" id="investment-form">
                @csrf

                <div class="row">
                    <!-- Basic Information Section -->
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label for="title" class="form-label">عنوان الفرصة الاستثمارية <span class="text-danger">*</span></label>
                            <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content" class="form-label">وصف الفرصة الاستثمارية <span class="text-danger">*</span></label>
                            <div id="content-editor" class="{{ $errors->has('content') ? 'is-invalid' : '' }}"></div>
                            <textarea name="content" id="content" class="hidden @error('content') is-invalid @enderror">{{ old('content', '<p>هذا_المحتوى_سيتم_استبداله</p>') }}</textarea>
                            @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <!-- Sidebar Options -->
                    <div class="col-lg-4">


                        <div class="admin-card mb-4">
                            <div class="admin-card-header">
                                <h3 class="admin-card-title" style="font-size: 1.2rem;"><i class="fas fa-image"></i> الصورة الرئيسية</h3>
                            </div>
                            <div class="admin-card-body">
                                <div class="form-group">
                                    <label for="featured_image" class="form-label">صورة الفرصة الاستثمارية</label>
                                    <input type="file" id="featured_image" name="featured_image" class="form-control @error('featured_image') is-invalid @enderror" accept="image/*">
                                    <small class="text-muted">أبعاد الصورة المثالية: 1200×800 بكسل</small>
                                    @error('featured_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <div class="mt-3" id="featured-image-preview"></div>
                                </div>
                            </div>
                        </div>


                        <div class="admin-card mb-4">
                            <div class="admin-card-header">
                                <h3 class="admin-card-title" style="font-size: 1.2rem;"><i class="fas fa-list-ul"></i> مميزات الاستثمار</h3>
                            </div>
                            <div class="admin-card-body">
                                <div class="form-group">
                                    <label for="investment_highlights" class="form-label">مميزات الفرصة الاستثمارية</label>
                                    <textarea id="investment_highlights" name="investment_highlights" class="form-control @error('investment_highlights') is-invalid @enderror" rows="4" placeholder="أدخل المميزات مفصولة بفواصل">{{ old('investment_highlights') }}</textarea>
                                    <small class="text-muted">أدخل المميزات مفصولة بفواصل (مثال: ميزة 1، ميزة 2، ميزة 3)</small>
                                    @error('investment_highlights')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="admin-card mb-4">
                        <div class="admin-card-header">
                            <h3 class="admin-card-title" style="font-size: 1.2rem;"><i class="fas fa-money-bill-wave"></i> بيانات الاستثمار</h3>
                        </div>
                        <div class="admin-card-body">
                            <div class="form-group">
                                <label for="investment_amount" class="form-label">قيمة الاستثمار <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="investment_amount" name="investment_amount" class="form-control @error('investment_amount') is-invalid @enderror" value="{{ old('investment_amount') }}" required>
                                    <span class="input-group-text">ر.س</span>
                                </div>
                                @error('investment_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="investment_category_id">فئة الاستثمار</label>
                                <select class="form-control @error('investment_category_id') is-invalid @enderror" id="investment_category_id" name="investment_category_id" required>
                                    <option value="">اختر فئة الاستثمار</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('investment_category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('investment_category_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="location" class="form-label">الموقع <span class="text-danger">*</span></label>
                                <input type="text" id="location" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}" placeholder="مثل: الرياض، جدة، الدمام، إلخ" required>
                                @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <!-- Additional Information -->
                    <div class="col-12">
                        <div class="admin-card mb-4">
                            <div class="admin-card-header">
                                <h3 class="admin-card-title" style="font-size: 1.2rem;"><i class="fas fa-info-circle"></i> معلومات إضافية</h3>
                            </div>
                            <div class="admin-card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tags" class="form-label">الوسوم</label>
                                            <input type="text" id="tags" name="tags" class="form-control @error('tags') is-invalid @enderror" value="{{ old('tags') }}">
                                            @error('tags')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_info" class="form-label">معلومات التواصل</label>
                                            <textarea id="contact_info" name="contact_info" class="form-control @error('contact_info') is-invalid @enderror" rows="4" placeholder="معلومات التواصل للمستثمرين المهتمين">{{ old('contact_info') }}</textarea>
                                            @error('contact_info')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gallery Images -->
                    <div class="col-12">
                        <div class="admin-card mb-4">
                            <div class="admin-card-header">
                                <h3 class="admin-card-title" style="font-size: 1.2rem;"><i class="fas fa-images"></i> معرض الصور</h3>
                            </div>
                            <div class="admin-card-body">
                                <div class="form-group">
                                    <label for="gallery_images" class="form-label">صور إضافية للمعرض</label>
                                    <input type="file" id="gallery_images" name="gallery_images[]" class="form-control @error('gallery_images.*') is-invalid @enderror" accept="image/*" multiple>
                                    <small class="text-muted">يمكنك إضافة عدة صور للمعرض (الحد الأقصى 10 صور)</small>
                                    @error('gallery_images.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="gallery-preview mt-3" id="gallery-preview"></div>
                            </div>
                        </div>
                    </div>

                    <div class="admin-card mb-4">
                        <div class="admin-card-header">
                            <h3 class="admin-card-title" style="font-size: 1.2rem;"><i class="fas fa-cog"></i> إعدادات النشر</h3>
                        </div>
                        <div class="admin-card-body">
                            <div class="form-group">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_published">نشر الفرصة الاستثمارية</label>
                                </div>
                                <small class="text-muted">في حالة التفعيل سيتم نشر الفرصة فورًا على الموقع</small>
                            </div>

                            <div class="form-group mt-3">
                                <label for="published_at" class="form-label">تاريخ النشر</label>
                                <input type="text" id="published_at" name="published_at" class="form-control flatpickr" value="{{ old('published_at') }}" placeholder="اختر تاريخ النشر">
                            </div>

                            <div class="form-group mt-3 d-grid gap-2">
                                <button type="submit" class="admin-btn admin-btn-primary">
                                    <i class="fas fa-save"></i> حفظ الفرصة الاستثمارية
                                </button>
                                <a href="{{ route('admin.investments.index') }}" class="admin-btn admin-btn-outline">
                                    <i class="fas fa-times"></i> إلغاء
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ar.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Quill editor
        const quill = new Quill('#content-editor', {
            theme: 'snow',
            placeholder: 'وصف الفرصة الاستثمارية...',
            modules: {
                toolbar: [
                    [{
                        'header': [1, 2, 3, 4, 5, 6, false]
                    }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                        'color': []
                    }, {
                        'background': []
                    }],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    ['blockquote', 'code-block'],
                    [{
                        'direction': 'rtl'
                    }],
                    [{
                        'align': []
                    }],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        });

        // Handle Quill editor image upload
        const toolbarImageHandler = function() {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.click();

            input.onchange = function() {
                const file = input.files[0];
                if (file) {
                    const formData = new FormData();
                    formData.append('image', file);
                    formData.append('_token', '{{ csrf_token() }}');

                    fetch('{{ route("admin.investments.upload-image") }}', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(result => {
                            if (result.url) {
                                const range = quill.getSelection(true);
                                quill.insertEmbed(range.index, 'image', result.url);
                            } else {
                                alert(result.error || 'Error uploading image');
                            }
                        })
                        .catch(error => {
                            alert('Network error');
                        });
                }
            };
        };

        // Bind custom image handler to Quill toolbar button
        const toolbar = quill.getModule('toolbar');
        toolbar.addHandler('image', toolbarImageHandler);

        // Sync Quill content with hidden textarea
        const form = document.getElementById('investment-form');
        const contentField = document.getElementById('content');
        const quillEditor = document.getElementById('content-editor');

        // Set initial content if exists
        if (contentField.value && contentField.value !== '<p>هذا_المحتوى_سيتم_استبداله</p>') {
            quill.root.innerHTML = contentField.value;
        } else {
            // Clear the placeholder
            quill.root.innerHTML = '';
        }

        // Copy content to hidden field before form submission
        form.onsubmit = function() {
            // Copy content to hidden field
            contentField.value = quill.root.innerHTML;

            // Check if Quill editor is empty or only contains empty paragraphs
            const isEmpty = quill.getText().trim() === '' || quill.root.innerHTML === '<p><br></p>';

            if (isEmpty) {
                alert('محتوى الفرصة الاستثمارية مطلوب');
                quillEditor.classList.add('is-invalid');
                return false;
            }

            return true;
        };

        // Remove error class when typing in Quill
        quill.on('text-change', function() {
            if (quill.getText().trim() !== '') {
                quillEditor.classList.remove('is-invalid');
            }
        });

        // Initialize Flatpickr
        flatpickr('.flatpickr', {
            enableTime: false,
            dateFormat: 'Y-m-d',
            locale: 'ar',
            theme: 'material_blue'
        });

        // Initialize Select2 for tags input
        $(document).ready(function() {
            $('#tags').select2({
                tags: true,
                tokenSeparators: [','],
                placeholder: 'أدخل الوسوم مفصولة بفواصل'
            });
        });

        // Featured image preview
        const featuredImageInput = document.getElementById('featured_image');
        const featuredImagePreview = document.getElementById('featured-image-preview');

        featuredImageInput.addEventListener('change', function() {
            featuredImagePreview.innerHTML = '';

            if (this.files && this.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-fluid rounded mt-2';
                    img.style.maxHeight = '200px';
                    featuredImagePreview.appendChild(img);
                }

                reader.readAsDataURL(this.files[0]);
            }
        });

        // Gallery images preview
        const galleryImagesInput = document.getElementById('gallery_images');
        const galleryPreview = document.getElementById('gallery-preview');

        galleryImagesInput.addEventListener('change', function() {
            galleryPreview.innerHTML = '';

            if (this.files && this.files.length > 0) {
                Array.from(this.files).forEach((file, index) => {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        // Create gallery item container
                        const galleryItem = document.createElement('div');
                        galleryItem.className = 'gallery-item';

                        // Create image
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        galleryItem.appendChild(img);

                        // Create caption input
                        const captionContainer = document.createElement('div');
                        captionContainer.className = 'gallery-caption';

                        const captionInput = document.createElement('input');
                        captionInput.type = 'text';
                        captionInput.name = `image_captions[${index}]`;
                        captionInput.className = 'form-control form-control-sm mt-1';
                        captionInput.placeholder = 'وصف الصورة';

                        captionContainer.appendChild(captionInput);

                        // Add elements to preview
                        galleryPreview.appendChild(galleryItem);
                        galleryPreview.appendChild(captionContainer);
                    }

                    reader.readAsDataURL(file);
                });
            }
        });

        // Convert investment highlights from comma-separated to array on submit
        const investmentHighlightsField = document.getElementById('investment_highlights');

        form.addEventListener('submit', function() {
            const highlights = investmentHighlightsField.value
                .split(',')
                .map(item => item.trim())
                .filter(item => item !== '');
            investmentHighlightsField.value = highlights.join(',');
        });

        // Add loading state to submit button
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> جاري الحفظ...';
        });

        // Handle form cancel and clear temporary uploaded images
        const cancelBtn = document.querySelector('.admin-btn-outline');

        cancelBtn.addEventListener('click', function(e) {
            e.preventDefault();

            if (confirm('هل أنت متأكد من إلغاء إنشاء الفرصة الاستثمارية؟ سيتم فقدان جميع البيانات المدخلة.')) {
                // Clear temporary images
                fetch('{{ route("admin.investments.clear-temp-images") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        window.location.href = '{{ route("admin.investments.index") }}';
                    })
                    .catch(error => {
                        window.location.href = '{{ route("admin.investments.index") }}';
                    });
            }
        });
    });
</script>
@endsection