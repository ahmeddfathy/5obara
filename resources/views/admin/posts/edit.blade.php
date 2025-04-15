@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/posts.css') }}">
<link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
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
    .marked-for-delete {
        opacity: 0.5;
        position: relative;
    }
    .marked-for-delete::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 0, 0, 0.2);
    }
    /* Validation styles */
    .is-invalid {
        border-color: #dc3545 !important;
    }
    .text-danger {
        color: #dc3545 !important;
        font-size: 0.875rem;
    }
    .quill-error .ql-toolbar,
    .quill-error .ql-container {
        border-color: #dc3545 !important;
    }
</style>
@endsection

@section('content')
<div class="admin-posts-container">
    <div class="admin-posts-header">
        <h1 class="admin-title">
            <i class="fas fa-edit me-2"></i>Edit Post
        </h1>
    </div>

    <div class="admin-card admin-fade-in">
        <div class="admin-card-header">
            <h2 class="admin-card-title"><i class="fas fa-file-alt me-2"></i>Post Information</h2>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data" id="postForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group mb-4">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required
                                class="form-control @error('title') is-invalid @enderror">
                            @error('title')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="editor" class="form-label">Content</label>
                            <div id="editor" class="@error('content') quill-error @enderror">{!! old('content', $post->content) !!}</div>
                            <input type="hidden" name="content" id="content-input" value="{{ old('content', $post->content) }}">
                            @error('content')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                            <div class="text-sm text-muted mt-2">
                                <p>يمكنك إدراج الصور في أي مكان من المحتوى. استخدم الأزرار في شريط الأدوات لإضافة صور ومحتوى منسق.</p>
                                <p class="text-warning"><i class="fas fa-info-circle me-1"></i> ملاحظة: الصور التي تم تحميلها ثم حذفها من المحرر سيتم حذفها تلقائيًا عند حفظ المقال.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-4">
                            <label for="featured_image" class="form-label">Featured Image</label>
                            @if($post->featured_image)
                            <div class="featured-image-preview mb-2">
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Current featured image" class="img-fluid rounded">
                            </div>
                            @endif
                            <input type="file" name="featured_image" id="featured_image" accept="image/*"
                                class="form-control @error('featured_image') is-invalid @enderror" onchange="previewFeaturedImage(this)">
                            @error('featured_image')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                            <p class="text-sm text-muted mt-1">هذه الصورة ستظهر في الصفحة الرئيسية وفي أعلى صفحة المقال</p>
                        </div>

                        <div class="form-group mb-4">
                            <label for="investment_amount" class="form-label">Investment Amount (SAR)</label>
                            <div class="input-group">
                                <span class="input-group-text">ر.س</span>
                                <input type="number" name="investment_amount" id="investment_amount" value="{{ old('investment_amount', $post->investment_amount) }}"
                                    class="form-control @error('investment_amount') is-invalid @enderror">
                            </div>
                            @error('investment_amount')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="investment_type" class="form-label">Investment Type</label>
                            <input type="text" name="investment_type" id="investment_type" value="{{ old('investment_type', $post->investment_type) }}"
                                class="form-control @error('investment_type') is-invalid @enderror">
                            @error('investment_type')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" name="location" id="location" value="{{ old('location', $post->location) }}"
                                class="form-control @error('location') is-invalid @enderror">
                            @error('location')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-check form-switch">
                                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $post->is_published) ? 'checked' : '' }}
                                    class="form-check-input">
                                <span class="form-check-label">Published</span>
                            </label>
                        </div>

                        @if($post->is_published && $post->published_at)
                        <div class="form-group mb-4">
                            <label for="published_at" class="form-label">Published Date</label>
                            <input type="datetime-local" name="published_at" id="published_at"
                                value="{{ old('published_at', $post->published_at->format('Y-m-d\TH:i')) }}"
                                class="form-control">
                        </div>
                        @endif
                    </div>
                </div>

                <div class="admin-card mt-4">
                    <div class="admin-card-header">
                        <h3 class="admin-card-title"><i class="fas fa-images me-2"></i>Gallery Images</h3>
                    </div>
                    <div class="admin-card-body">
                        <div class="mb-4">
                            <label class="form-label">Existing Gallery Images</label>
                            <div class="border border-dashed border-gray-300 p-4 rounded">
                                @if($post->images->count() > 0)
                                <div class="gallery-preview">
                                    @foreach($post->images as $index => $image)
                                    <div class="gallery-item-container" data-id="{{ $image->id }}">
                                        <div class="gallery-item {{ in_array($image->id, old('images_to_delete', [])) ? 'marked-for-delete' : '' }}">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->caption }}">
                                            <button type="button" class="gallery-remove" onclick="markForDeletion('{{ $image->id }}')">×</button>
                                        </div>
                                        <input type="text" name="existing_image_captions[{{ $index }}]" value="{{ $image->caption }}"
                                            class="gallery-caption form-control form-control-sm"
                                            placeholder="Image caption">
                                        <input type="hidden" name="existing_image_ids[{{ $index }}]" value="{{ $image->id }}">
                                    </div>
                                    @endforeach
                                </div>
                                <div id="marked-for-deletion"></div>
                                @else
                                <p class="text-muted">No gallery images available.</p>
                                @endif
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="gallery_images" class="form-label">Add New Gallery Images</label>
                            <div class="border border-dashed border-gray-300 p-4 rounded">
                                <input type="file" name="gallery_images[]" id="gallery_images" accept="image/*" multiple
                                    class="form-control @error('gallery_images') is-invalid @enderror" onchange="previewGalleryImages(this)">
                                @error('gallery_images')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                                @error('gallery_images.*')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                                <p class="text-sm text-muted mt-1">You can select multiple images at once</p>

                                <div id="gallery-preview" class="gallery-preview mt-4"></div>
                            </div>
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
                                    <input type="text" name="tags" id="tags"
                                        value="{{ old('tags', is_string($post->tags) ? $post->tags : (is_array($post->tags) ? implode(', ', $post->tags) : '')) }}"
                                        class="form-control @error('tags') is-invalid @enderror">
                                    @error('tags')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="investment_highlights" class="form-label">Investment Highlights (comma-separated)</label>
                                    <input type="text" name="investment_highlights" id="investment_highlights"
                                        value="{{ old('investment_highlights', is_string($post->investment_highlights) ? $post->investment_highlights : (is_array($post->investment_highlights) ? implode(', ', $post->investment_highlights) : '')) }}"
                                        class="form-control @error('investment_highlights') is-invalid @enderror">
                                    @error('investment_highlights')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                    <p class="text-sm text-muted mt-1">For example: "Guaranteed ROI of 15%,Premium location,Fully managed property"</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="contact_info" class="form-label">Contact Information</label>
                            <textarea name="contact_info" id="contact_info" rows="3"
                                class="form-control @error('contact_info') is-invalid @enderror">{{ old('contact_info', $post->contact_info) }}</textarea>
                            @error('contact_info')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="admin-btn admin-btn-primary">
                        <i class="fas fa-save me-2"></i>Update Post
                    </button>
                    <a href="{{ route('admin.posts.index') }}" class="admin-btn admin-btn-outline" id="cancel-btn">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Add MutationObserver polyfill for deprecated DOM mutation events -->
<script>
// Polyfill for DOMNodeInserted event used in Quill
if (typeof window !== 'undefined' && window.MutationObserver) {
    // Store original addEventListener
    const originalAddEventListener = EventTarget.prototype.addEventListener;

    // Override addEventListener to intercept DOMNodeInserted
    EventTarget.prototype.addEventListener = function(type, listener, options) {
        if (type === 'DOMNodeInserted') {
            // Create a MutationObserver instead
            const target = this;
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                        // Simulate the event for added nodes
                        mutation.addedNodes.forEach(node => {
                            const event = new Event('DOMNodeInserted');
                            event.target = node;
                            event.relatedNode = target;
                            listener.call(target, event);
                        });
                    }
                });
            });

            // Start observing with configuration
            observer.observe(target, { childList: true, subtree: true });

            // Store observer in a WeakMap to manage its lifecycle
            if (!this._mutationObservers) {
                this._mutationObservers = new WeakMap();
            }
            this._mutationObservers.set(listener, observer);

            // Don't call the original method
            return;
        }

        // Call original method for all other event types
        return originalAddEventListener.call(this, type, listener, options);
    };
}
</script>
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
<script>
    var quill;
    var initialContent = `{!! old('content', $post->content) !!}`;

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

    function markForDeletion(imageId) {
        const container = document.querySelector(`.gallery-item-container[data-id="${imageId}"] .gallery-item`);
        container.classList.toggle('marked-for-delete');

        let deletionField = document.getElementById(`delete_image_${imageId}`);

        if (!deletionField) {
            deletionField = document.createElement('input');
            deletionField.type = 'hidden';
            deletionField.name = 'images_to_delete[]';
            deletionField.value = imageId;
            deletionField.id = `delete_image_${imageId}`;
            document.getElementById('marked-for-deletion').appendChild(deletionField);
        } else {
            deletionField.remove();
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

        // Add event listener to cancel button to clear temporary images
        document.getElementById('cancel-btn').addEventListener('click', function(e) {
            // Clear temp images using AJAX call
            fetch('/admin/posts/clear-temp-images', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).catch(error => console.error('Error clearing temporary images:', error));
        });
    });
</script>
@endsection
