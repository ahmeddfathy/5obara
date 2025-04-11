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

                <div class="row">
                    <div class="col-md-6">
                        <div class="portfolio-form-group">
                            <label for="title" class="portfolio-form-label">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $portfolio->title) }}" required
                                class="portfolio-form-control">
                        </div>
            </div>

                    <div class="col-md-6">
                        <div class="portfolio-form-group">
                            <label for="client_name" class="portfolio-form-label">Client Name</label>
                            <input type="text" name="client_name" id="client_name" value="{{ old('client_name', $portfolio->client_name) }}"
                                class="portfolio-form-control">
                        </div>
                    </div>
            </div>

                <div class="portfolio-form-group">
                    <label for="description" class="portfolio-form-label">Description</label>
                    <textarea name="description" id="description" rows="5" required
                        class="portfolio-form-control">{{ old('description', $portfolio->description) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="portfolio-form-group">
                            <label for="project_type" class="portfolio-form-label">Project Type</label>
                            <input type="text" name="project_type" id="project_type" value="{{ old('project_type', $portfolio->project_type) }}" required
                                class="portfolio-form-control">
                        </div>
            </div>

                    <div class="col-md-6">
                        <div class="portfolio-form-group">
                            <label for="completion_date" class="portfolio-form-label">Completion Date</label>
                            <input type="date" name="completion_date" id="completion_date" value="{{ old('completion_date', $portfolio->completion_date ? $portfolio->completion_date->format('Y-m-d') : '') }}"
                                class="portfolio-form-control">
                        </div>
                    </div>
            </div>

                <div class="portfolio-form-group">
                    <label for="project_url" class="portfolio-form-label">Project URL</label>
                    <input type="url" name="project_url" id="project_url" value="{{ old('project_url', $portfolio->project_url) }}"
                        class="portfolio-form-control">
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
                        <input type="file" name="image" id="image" accept="image/*" class="d-none">
                        <i class="fas fa-cloud-upload-alt portfolio-upload-icon"></i>
                        <h4 class="portfolio-upload-title">Upload New Image</h4>
                        <p class="portfolio-upload-subtitle">Click to browse or drag and drop images here</p>
                    </div>
            </div>

                <div class="portfolio-form-group">
                    <label class="portfolio-form-label">Technologies Used</label>
                    <div class="d-flex flex-wrap gap-2">
                    @php
                        $commonTechnologies = ['PHP', 'Laravel', 'JavaScript', 'Vue.js', 'React', 'Angular', 'Node.js', 'Python', 'Django', 'Ruby', 'Ruby on Rails', 'MySQL', 'PostgreSQL', 'MongoDB', 'CSS', 'HTML', 'Tailwind CSS', 'Bootstrap', 'AWS', 'Docker', 'Kubernetes'];
                        $portfolioTechnologies = old('technologies', $portfolio->technologies ?? []);
                        if (!is_array($portfolioTechnologies)) {
                            $portfolioTechnologies = [];
                        }
                    @endphp

                    @foreach($commonTechnologies as $tech)
                        <div class="portfolio-form-check me-3 mb-2">
                            <input type="checkbox" name="technologies[]" value="{{ $tech }}" id="tech-{{ $loop->index }}"
                        {{ in_array($tech, $portfolioTechnologies) ? 'checked' : '' }}
                                class="portfolio-form-check-input">
                            <label for="tech-{{ $loop->index }}" class="portfolio-form-check-label">{{ $tech }}</label>
                        </div>
                    @endforeach

                    @if(is_array($portfolioTechnologies))
                        @foreach($portfolioTechnologies as $tech)
                            @if(!in_array($tech, $commonTechnologies))
                                <div class="portfolio-form-check me-3 mb-2">
                                    <input type="checkbox" name="technologies[]" value="{{ $tech }}" id="tech-custom-{{ $loop->index }}"
                                        checked class="portfolio-form-check-input">
                                    <label for="tech-custom-{{ $loop->index }}" class="portfolio-form-check-label">{{ $tech }}</label>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
                    <div class="mt-3">
                        <label for="other_tech" class="portfolio-form-label">Other Technologies (comma-separated)</label>
                        <input type="text" id="other_tech" name="other_tech" class="portfolio-form-control">
                </div>
            </div>

                <div class="portfolio-form-group">
                    <div class="portfolio-form-check">
                        <input type="checkbox" name="is_featured" value="1" id="is_featured"
                            {{ old('is_featured', $portfolio->is_featured) ? 'checked' : '' }}
                            class="portfolio-form-check-input">
                        <label for="is_featured" class="portfolio-form-check-label">Featured Project</label>
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
        const otherTechInput = document.getElementById('other_tech');
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
