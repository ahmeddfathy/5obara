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

                <div class="row">
                    <div class="col-md-6">
                        <div class="portfolio-form-group">
                            <label for="title" class="portfolio-form-label">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                class="portfolio-form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="portfolio-form-group">
                            <label for="client_name" class="portfolio-form-label">Client Name</label>
                            <input type="text" name="client_name" id="client_name" value="{{ old('client_name') }}"
                                class="portfolio-form-control">
                        </div>
                    </div>
            </div>

                <div class="portfolio-form-group">
                    <label for="description" class="portfolio-form-label">Description</label>
                <textarea name="description" id="description" rows="5" required
                        class="portfolio-form-control">{{ old('description') }}</textarea>
            </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="portfolio-form-group">
                            <label for="project_type" class="portfolio-form-label">Project Type</label>
                            <input type="text" name="project_type" id="project_type" value="{{ old('project_type') }}" required
                                class="portfolio-form-control">
                        </div>
            </div>

                    <div class="col-md-6">
                        <div class="portfolio-form-group">
                            <label for="completion_date" class="portfolio-form-label">Completion Date</label>
                            <input type="date" name="completion_date" id="completion_date" value="{{ old('completion_date') }}"
                                class="portfolio-form-control">
                        </div>
                    </div>
            </div>

                <div class="portfolio-form-group">
                    <label for="project_url" class="portfolio-form-label">Project URL</label>
                    <input type="url" name="project_url" id="project_url" value="{{ old('project_url') }}"
                        class="portfolio-form-control">
            </div>

                <div class="portfolio-form-group">
                    <label class="portfolio-form-label">صورة المشروع</label>
                    <div class="simple-upload-area">
                        <input type="file" name="image" id="imageInput" class="portfolio-form-control" accept="image/*">
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
                    <label class="portfolio-form-label">Technologies Used</label>
                    <div class="d-flex flex-wrap gap-2">
                    @php
                        $commonTechnologies = ['PHP', 'Laravel', 'JavaScript', 'Vue.js', 'React', 'Angular', 'Node.js', 'Python', 'Django', 'Ruby', 'Ruby on Rails', 'MySQL', 'PostgreSQL', 'MongoDB', 'CSS', 'HTML', 'Tailwind CSS', 'Bootstrap', 'AWS', 'Docker', 'Kubernetes'];
                        $oldTechnologies = old('technologies', []);
                    @endphp

                    @foreach($commonTechnologies as $tech)
                        <div class="portfolio-form-check me-3 mb-2">
                            <input type="checkbox" name="technologies[]" value="{{ $tech }}" id="tech-{{ $loop->index }}"
                        {{ (is_array($oldTechnologies) && in_array($tech, $oldTechnologies)) ? 'checked' : '' }}
                            class="portfolio-form-check-input">
                            <label for="tech-{{ $loop->index }}" class="portfolio-form-check-label">{{ $tech }}</label>
                        </div>
                    @endforeach
                    </div>
                    <div class="mt-3">
                        <label for="other_tech" class="portfolio-form-label">Other Technologies (comma-separated)</label>
                        <input type="text" id="other_tech" name="other_tech" class="portfolio-form-control">
                    </div>
                </div>

                <div class="portfolio-form-group">
                    <div class="portfolio-form-check">
                        <input type="checkbox" name="is_featured" value="1" id="is_featured"
                            {{ old('is_featured') ? 'checked' : '' }}
                            class="portfolio-form-check-input">
                        <label for="is_featured" class="portfolio-form-check-label">Featured Project</label>
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

document.addEventListener('DOMContentLoaded', function() {
    const otherTechInput = document.getElementById('other_tech');

    otherTechInput.addEventListener('blur', function() {
        if (!this.value.trim()) return;

        const technologies = this.value.split(',').map(tech => tech.trim()).filter(tech => tech);
        const checkboxContainer = document.querySelector('.d-flex.flex-wrap.gap-2');

        technologies.forEach(tech => {
            if (!tech) return;

            // Check if tech already exists as a checkbox
            const existingCheckboxes = document.querySelectorAll('input[name="technologies[]"]');
            for (let checkbox of existingCheckboxes) {
                if (checkbox.value === tech) {
                    checkbox.checked = true;
                    return;
                }
            }

            // Create new checkbox for the tech
            const formCheck = document.createElement('div');
            formCheck.className = 'portfolio-form-check me-3 mb-2';

            const id = 'tech-new-' + Math.random().toString(36).substr(2, 9);

            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.name = 'technologies[]';
            checkbox.value = tech;
            checkbox.id = id;
            checkbox.checked = true;
            checkbox.className = 'portfolio-form-check-input';

            const label = document.createElement('label');
            label.className = 'portfolio-form-check-label';
            label.textContent = tech;
            label.setAttribute('for', id);

            formCheck.appendChild(checkbox);
            formCheck.appendChild(label);
            checkboxContainer.appendChild(formCheck);
        });

        // Clear the input field
        this.value = '';
    });
});
</script>
@endpush
@endsection
