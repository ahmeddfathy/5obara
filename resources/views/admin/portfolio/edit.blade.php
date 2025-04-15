@extends('layouts.admin')

@section('content')
<div class="portfolio-container">
    <div class="portfolio-header d-flex justify-content-between align-items-center">
        <div>
            <h1 class="portfolio-title">Edit Portfolio Item</h1>
            <p class="portfolio-subtitle">Update your portfolio item details</p>
        </div>
        <div class="portfolio-actions">
            <a href="{{ route('admin.portfolio.index') }}" class="portfolio-btn portfolio-btn-outline">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="portfolio-card portfolio-fade-in">
        <div class="portfolio-card-header">
            <h2 class="portfolio-card-title"><i class="fas fa-edit"></i> Edit Portfolio Details</h2>
        </div>
        <div class="portfolio-card-body">
        <form action="{{ route('admin.portfolio.update', $portfolio) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

                <div class="portfolio-form-group">
                    <label for="title" class="portfolio-form-label">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $portfolio->title) }}" required
                        class="portfolio-form-control @error('title') is-invalid @enderror">
                    @error('title')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="portfolio-form-group">
                    <label for="description" class="portfolio-form-label">Description</label>
                    <textarea name="description" id="description" rows="5" required
                        class="portfolio-form-control @error('description') is-invalid @enderror">{{ old('description', $portfolio->description) }}</textarea>
                    @error('description')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="portfolio-form-group">
                    <label for="project_type" class="portfolio-form-label">Project Type</label>
                    <input type="text" name="project_type" id="project_type" value="{{ old('project_type', $portfolio->project_type) }}" required
                        class="portfolio-form-control @error('project_type') is-invalid @enderror">
                    @error('project_type')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="portfolio-form-group">
                    <label class="portfolio-form-label">Project Image</label>

                    @if($portfolio->image)
                    <div class="portfolio-image-preview">
                        <div class="portfolio-image-item">
                            <img src="{{ asset('storage/' . $portfolio->image) }}" alt="{{ $portfolio->title }}">
                        </div>
                    </div>
                    @endif

                    <div class="portfolio-upload-area mt-3">
                        <input type="file" name="image" id="image" accept="image/*" class="d-none @error('image') is-invalid @enderror">
                        <i class="fas fa-cloud-upload-alt portfolio-upload-icon"></i>
                        <h4 class="portfolio-upload-title">Upload New Image</h4>
                        <p class="portfolio-upload-subtitle">Click to browse or drag and drop images here</p>
                        @error('image')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="portfolio-form-group">
                    <div class="portfolio-form-check">
                        <input type="checkbox" name="is_featured" value="1" id="is_featured"
                            {{ old('is_featured', $portfolio->is_featured) ? 'checked' : '' }}
                            class="portfolio-form-check-input @error('is_featured') is-invalid @enderror">
                        <label for="is_featured" class="portfolio-form-check-label">Featured Project</label>
                        @error('is_featured')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="portfolio-btn portfolio-btn-primary">
                        <i class="fas fa-save"></i> Update Portfolio Item
                    </button>
                    <a href="{{ route('admin.portfolio.index') }}" class="portfolio-btn portfolio-btn-outline">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadArea = document.querySelector('.portfolio-upload-area');
        const fileInput = document.getElementById('image');

        uploadArea.addEventListener('click', function() {
            fileInput.click();
        });

        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const fileName = this.files[0].name;
                const uploadTitle = document.querySelector('.portfolio-upload-title');
                uploadTitle.textContent = 'Selected: ' + fileName;
            }
        });

        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('border-primary');
        });

        uploadArea.addEventListener('dragleave', function() {
            this.classList.remove('border-primary');
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-primary');

            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                const fileName = e.dataTransfer.files[0].name;
                const uploadTitle = document.querySelector('.portfolio-upload-title');
                uploadTitle.textContent = 'Selected: ' + fileName;
            }
        });
    });
</script>
@endpush

@push('styles')
<style>
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
@endsection
