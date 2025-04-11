@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/posts.css') }}">
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<style>
    #editor {
        height: 300px;
        direction: rtl;
        text-align: right;
    }
    .ql-editor {
        direction: rtl;
        text-align: right;
        font-family: 'Arial', sans-serif;
        font-size: 16px;
        line-height: 1.6;
    }
    .ql-container {
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }
    .ql-toolbar {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    .ql-editor p {
        margin-bottom: 1em;
    }
    .ql-editor img {
        display: block;
        max-width: 100%;
        margin: 1em 0;
    }
</style>
@endsection

@section('content')
<div class="admin-posts-container">
    <div class="admin-posts-header">
        <h1 class="admin-title">
            <i class="fas fa-plus-circle me-2"></i>Create New Post
        </h1>
    </div>

    <div class="admin-card admin-fade-in">
        <div class="admin-card-header">
            <h2 class="admin-card-title"><i class="fas fa-edit me-2"></i>Post Information</h2>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" id="postForm">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group mb-4">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                class="form-control">
                        </div>

                        <div class="form-group mb-4">
                            <label for="editor" class="form-label">Content</label>
                            <div id="editor">{!! old('content') !!}</div>
                            <input type="hidden" name="content" id="content-input">
                            <div class="text-sm text-muted mt-2">
                                <p>يمكنك إدراج الصور في أي مكان من المحتوى. استخدم الأزرار في شريط الأدوات لإضافة صور ومحتوى منسق.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-4">
                            <label for="featured_image" class="form-label">Featured Image</label>
                            <div class="featured-image-preview mb-2 d-none">
                                <img src="" id="featured-image-preview" class="img-fluid rounded">
                            </div>
                            <input type="file" name="featured_image" id="featured_image" accept="image/*"
                                class="form-control" onchange="previewFeaturedImage(this)">
                            <p class="text-sm text-muted mt-1">هذه الصورة ستظهر في الصفحة الرئيسية وفي أعلى صفحة المقال</p>
                        </div>

                        <div class="form-group mb-4">
                            <label for="investment_amount" class="form-label">Investment Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="investment_amount" id="investment_amount" value="{{ old('investment_amount') }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="investment_type" class="form-label">Investment Type</label>
                            <input type="text" name="investment_type" id="investment_type" value="{{ old('investment_type') }}"
                                class="form-control">
                        </div>

                        <div class="form-group mb-4">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" name="location" id="location" value="{{ old('location') }}"
                                class="form-control">
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-check form-switch">
                                <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}
                                    class="form-check-input">
                                <span class="form-check-label">Publish immediately</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="admin-card mt-4">
                    <div class="admin-card-header">
                        <h3 class="admin-card-title"><i class="fas fa-images me-2"></i>Gallery Images</h3>
                    </div>
                    <div class="admin-card-body">
                        <div class="border border-dashed border-gray-300 p-4 rounded">
                            <input type="file" name="gallery_images[]" id="gallery_images" accept="image/*" multiple
                                class="form-control" onchange="previewGalleryImages(this)">
                            <p class="text-sm text-muted mt-1">You can select multiple images at once</p>

                            <div id="gallery-preview" class="gallery-preview mt-4"></div>
                        </div>
                    </div>
                </div>

                <div class="admin-card mt-4">
                    <div class="admin-card-header">
                        <h3 class="admin-card-title"><i class="fas fa-tags me-2"></i>Additional Information</h3>
                    </div>
                    <div class="admin-card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="tags" class="form-label">Tags (comma-separated)</label>
                                    <input type="text" name="tags" id="tags" value="{{ old('tags') }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="investment_highlights" class="form-label">Investment Highlights (comma-separated)</label>
                                    <input type="text" name="investment_highlights" id="investment_highlights" value="{{ old('investment_highlights') }}"
                                        class="form-control">
                                    <p class="text-sm text-muted mt-1">For example: "Guaranteed ROI of 15%,Premium location,Fully managed property"</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="contact_info" class="form-label">Contact Information</label>
                            <textarea name="contact_info" id="contact_info" rows="3"
                                class="form-control">{{ old('contact_info') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="admin-btn admin-btn-primary">
                        <i class="fas fa-save me-2"></i>Create Post
                    </button>
                    <a href="{{ route('admin.posts.index') }}" class="admin-btn admin-btn-outline">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var quill;
    var initialContent = `{!! old('content') !!}`;

    function imageHandler() {
        const input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        input.click();

        input.onchange = async () => {
            const file = input.files[0];
            if (file) {
                if (file.size > 10 * 1024 * 1024) {
                    alert('Image size should be less than 10MB');
                    return;
                }

                const formData = new FormData();
                formData.append('image', file);
                formData.append('_token', '{{ csrf_token() }}');

                try {
                    const range = quill.getSelection(true);
                    quill.insertText(range.index, 'Uploading image...', Quill.sources.USER);
                    quill.setSelection(range.index, 0, Quill.sources.SILENT);

                    const response = await fetch('{{ route("admin.posts.upload-image") }}', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (!response.ok) {
                        throw new Error(result.error || 'Upload failed');
                    }

                    quill.deleteText(range.index, 13, Quill.sources.SILENT);

                    if (range.index > 0) {
                        quill.insertText(range.index, '\n', Quill.sources.USER);
                    }

                    quill.insertEmbed(range.index, 'image', result.url, Quill.sources.USER);
                    quill.insertText(range.index + 1, '\n', Quill.sources.USER);
                    quill.setSelection(range.index + 2, Quill.sources.SILENT);

                } catch (error) {
                    alert(error.message || 'Failed to upload image. Please try again.');
                    const range = quill.getSelection(true);
                    quill.deleteText(range.index - 13, 13, Quill.sources.SILENT);
                }
            }
        };
    }

    function previewFeaturedImage(input) {
        const preview = document.getElementById('featured-image-preview');
        const previewContainer = preview.parentElement;

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('d-none');
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            previewContainer.classList.add('d-none');
        }
    }

    function previewGalleryImages(input) {
        const previewContainer = document.getElementById('gallery-preview');
        previewContainer.innerHTML = '';

        if (input.files && input.files.length > 0) {
            for (let i = 0; i < input.files.length; i++) {
                const file = input.files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const galleryItem = document.createElement('div');
                    galleryItem.className = 'gallery-item';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Gallery image ' + (i + 1);

                    const removeBtn = document.createElement('button');
                    removeBtn.className = 'gallery-remove';
                    removeBtn.innerHTML = '×';
                    removeBtn.type = 'button';

                    galleryItem.appendChild(img);
                    galleryItem.appendChild(removeBtn);

                    const captionInput = document.createElement('input');
                    captionInput.type = 'text';
                    captionInput.name = 'image_captions[]';
                    captionInput.className = 'gallery-caption form-control form-control-sm mt-2';
                    captionInput.placeholder = 'Image caption';

                    const galleryItemContainer = document.createElement('div');
                    galleryItemContainer.className = 'gallery-item-container';
                    galleryItemContainer.appendChild(galleryItem);
                    galleryItemContainer.appendChild(captionInput);

                    previewContainer.appendChild(galleryItemContainer);
                }

                reader.readAsDataURL(file);
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: {
                    container: [
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'align': [] }],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['link', 'image', 'video'],
                        ['clean']
                    ],
                    handlers: {
                        'image': imageHandler
                    }
                }
            },
            placeholder: 'اكتب هنا...'
        });

        if (initialContent) {
            quill.root.innerHTML = initialContent;
        }

        document.getElementById('postForm').addEventListener('submit', function(e) {
            var content = quill.root.innerHTML;
            document.getElementById('content-input').value = content;
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('gallery-remove')) {
                e.target.closest('.gallery-item-container').remove();
            }
        });
    });
</script>
@endsection
