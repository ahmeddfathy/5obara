@extends('layouts.admin')

@section('content')
<div class="portfolio-container">
    <div class="portfolio-header d-flex justify-content-between align-items-center">
        <div>
            <h1 class="portfolio-title">Add New Portfolio Item</h1>
            <p class="portfolio-subtitle">Create a new portfolio item to showcase your work</p>
        </div>
        <div class="portfolio-actions">
            <a href="{{ route('admin.portfolio.index') }}" class="portfolio-btn portfolio-btn-outline">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="portfolio-card portfolio-fade-in">
        <div class="portfolio-card-header">
            <h2 class="portfolio-card-title"><i class="fas fa-plus-circle"></i> New Portfolio Details</h2>
        </div>
        <div class="portfolio-card-body">
        <form action="{{ route('admin.portfolio.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

                <div class="portfolio-form-group">
                    <label for="title" class="portfolio-form-label">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                class="portfolio-form-control @error('title') is-invalid @enderror">
                    @error('title')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="portfolio-form-group">
                    <label for="description" class="portfolio-form-label">Description</label>
                    <textarea name="description" id="description" rows="5" required
                        class="portfolio-form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="portfolio-form-group">
                    <label for="project_type" class="portfolio-form-label">Project Type</label>
                    <input type="text" name="project_type" id="project_type" value="{{ old('project_type') }}" required
                        class="portfolio-form-control @error('project_type') is-invalid @enderror">
                    @error('project_type')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="portfolio-form-group">
                    <label class="portfolio-form-label">صورة المشروع</label>
                    <div class="simple-upload-area">
                        <input type="file" name="image" id="imageInput" class="portfolio-form-control @error('image') is-invalid @enderror" accept="image/*">
                        @error('image')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                        <p class="portfolio-upload-info mt-2">
                            الحد الأقصى لحجم الملف: 10 ميجابايت
                            <br>
                            الصيغ المدعومة: JPG, PNG, GIF
                        </p>
                        <div class="portfolio-upload-preview mt-3" id="previewArea" style="display: none;">
                            <img src="" alt="Preview" id="imagePreview" class="mb-2">
                            <div class="portfolio-upload-actions">
                                <button type="button" class="portfolio-btn portfolio-btn-danger portfolio-btn-sm" onclick="removeImage()">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portfolio-form-group">
                    <div class="portfolio-form-check">
                        <input type="checkbox" name="is_featured" value="1" id="is_featured"
                            {{ old('is_featured') ? 'checked' : '' }}
                            class="portfolio-form-check-input @error('is_featured') is-invalid @enderror">
                        <label for="is_featured" class="portfolio-form-check-label">Featured Project</label>
                        @error('is_featured')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="portfolio-btn portfolio-btn-primary">
                        <i class="fas fa-save"></i> Create Portfolio Item
                    </button>
                    <a href="{{ route('admin.portfolio.index') }}" class="portfolio-btn portfolio-btn-outline">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
.simple-upload-area {
    padding: 1rem;
    border-radius: var(--portfolio-card-radius);
}

.portfolio-upload-preview {
    max-width: 100%;
}

.portfolio-upload-preview img {
    max-width: 100%;
    max-height: 300px;
    object-fit: contain;
    border-radius: var(--portfolio-card-radius);
}

.portfolio-upload-info {
    font-size: 0.875rem;
    color: var(--portfolio-gray-500);
}

.portfolio-btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

/* Validation error styles */
.is-invalid {
    border-color: #dc3545 !important;
}
.text-danger {
    color: #dc3545 !important;
    font-size: 0.875rem;
}
</style>
@endpush

@push('scripts')
<script>
const imageInput = document.getElementById('imageInput');
const previewArea = document.getElementById('previewArea');
const imagePreview = document.getElementById('imagePreview');

imageInput.addEventListener('change', function() {
    handleFiles(this.files);
});

function handleFiles(files) {
    if (files.length > 0) {
        const file = files[0];

        // Check file size (10MB limit)
        if (file.size > 10 * 1024 * 1024) {
            alert('حجم الملف كبير جداً. الحد الأقصى هو 10 ميجابايت');
            return;
        }

        // Check file type
        if (!file.type.match('image.*')) {
            alert('يرجى اختيار صورة صالحة');
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            previewArea.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    imageInput.value = '';
    imagePreview.src = '';
    previewArea.style.display = 'none';
}
</script>
@endpush
@endsection
