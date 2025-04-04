@extends('layouts.admin')

@section('styles')
<style>
    .gallery-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }
    .gallery-item {
        position: relative;
        width: 150px;
        height: 150px;
        border-radius: 4px;
        overflow: hidden;
    }
    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .gallery-caption {
        margin-top: 5px;
        width: 150px;
    }
    .gallery-remove {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(255,0,0,0.7);
        color: white;
        border: none;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .marked-for-delete {
        opacity: 0.3;
    }

    /* تنسيقات لمحرر CKEditor */
    .cke_rtl {
        direction: rtl;
    }
</style>

<!-- تضمين CKEditor 4 بالإصدار الكامل بدلا من standard-all -->
<script src="https://cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>
@endsection

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h1 class="text-2xl font-bold mb-6">Edit Post</h1>

        <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="editor" class="block text-gray-700 text-sm font-bold mb-2">Content</label>
                <textarea id="editor" name="content">{{ old('content', $post->content) }}</textarea>
                <div class="text-sm text-gray-500 mt-2">
                    <p>يمكنك إدراج الصور في أي مكان من المحتوى. استخدم الأزرار في شريط الأدوات لإضافة صور ومحتوى منسق.</p>
                </div>
            </div>

            <div class="mb-4">
                <label for="featured_image" class="block text-gray-700 text-sm font-bold mb-2">Featured Image</label>
                @if($post->featured_image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Current featured image" class="h-32 w-auto">
                </div>
                @endif
                <input type="file" name="featured_image" id="featured_image" accept="image/*"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <p class="text-sm text-gray-500 mt-1">هذه الصورة ستظهر في الصفحة الرئيسية وفي أعلى صفحة المقال</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Existing Gallery Images</label>
                <div class="border border-dashed border-gray-400 p-4 rounded">
                    @if($post->images->count() > 0)
                    <div class="gallery-preview">
                        @foreach($post->images as $index => $image)
                        <div class="gallery-item-container" data-id="{{ $image->id }}">
                            <div class="gallery-item">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->caption }}">
                                <button type="button" class="gallery-remove" onclick="markForDeletion('{{ $image->id }}')">×</button>
                            </div>
                            <input type="text" name="existing_image_captions[{{ $index }}]" value="{{ $image->caption }}"
                                class="gallery-caption shadow appearance-none border rounded py-1 px-2 text-gray-700 text-sm"
                                placeholder="Image caption">
                            <input type="hidden" name="existing_image_ids[{{ $index }}]" value="{{ $image->id }}">
                        </div>
                        @endforeach
                    </div>
                    <div id="marked-for-deletion"></div>
                    @else
                    <p class="text-gray-500">No gallery images available.</p>
                    @endif
                </div>
            </div>

            <div class="mb-4">
                <label for="gallery_images" class="block text-gray-700 text-sm font-bold mb-2">Add New Gallery Images</label>
                <div class="border border-dashed border-gray-400 p-4 rounded">
                    <input type="file" name="gallery_images[]" id="gallery_images" accept="image/*" multiple
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <p class="text-sm text-gray-500 mt-1">You can select multiple images at once</p>

                    <div id="gallery-preview" class="gallery-preview mt-4"></div>
                </div>
            </div>

            <div class="mb-4">
                <label for="investment_amount" class="block text-gray-700 text-sm font-bold mb-2">Investment Amount</label>
                <input type="number" name="investment_amount" id="investment_amount" value="{{ old('investment_amount', $post->investment_amount) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="investment_type" class="block text-gray-700 text-sm font-bold mb-2">Investment Type</label>
                <input type="text" name="investment_type" id="investment_type" value="{{ old('investment_type', $post->investment_type) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="location" class="block text-gray-700 text-sm font-bold mb-2">Location</label>
                <input type="text" name="location" id="location" value="{{ old('location', $post->location) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="tags" class="block text-gray-700 text-sm font-bold mb-2">Tags (comma-separated)</label>
                <input type="text" name="tags" id="tags" value="{{ old('tags', is_array($post->tags) ? implode(', ', $post->tags) : '') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="investment_highlights" class="block text-gray-700 text-sm font-bold mb-2">Investment Highlights (comma-separated)</label>
                <input type="text" name="investment_highlights" id="investment_highlights"
                    value="{{ old('investment_highlights', is_array($post->investment_highlights) ? implode(', ', $post->investment_highlights) : '') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <p class="text-sm text-gray-500 mt-1">For example: "Guaranteed ROI of 15%,Premium location,Fully managed property"</p>
            </div>

            <div class="mb-4">
                <label for="contact_info" class="block text-gray-700 text-sm font-bold mb-2">Contact Information</label>
                <textarea name="contact_info" id="contact_info" rows="3"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('contact_info', $post->contact_info) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $post->is_published) ? 'checked' : '' }}
                        class="form-checkbox h-4 w-4 text-blue-600">
                    <span class="ml-2 text-gray-700">Published</span>
                </label>
            </div>

            @if($post->is_published && $post->published_at)
            <div class="mb-4">
                <label for="published_at" class="block text-gray-700 text-sm font-bold mb-2">Published Date</label>
                <input type="datetime-local" name="published_at" id="published_at"
                    value="{{ old('published_at', $post->published_at->format('Y-m-d\TH:i')) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            @endif

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Post
                </button>
                <a href="{{ route('admin.posts.index') }}" class="text-gray-600 hover:text-gray-800">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // تهيئة CKEditor
        if (CKEDITOR) {
            CKEDITOR.replace('editor', {
                language: 'ar',
                contentsLangDirection: 'rtl',
                height: 400,
                filebrowserUploadUrl: "{{ route('admin.images.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form',
                extraPlugins: 'uploadimage',
                uploadUrl: "{{ route('admin.images.upload', ['_token' => csrf_token()]) }}",
                toolbar: [
                    { name: 'document', items: [ 'Source' ] },
                    { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                    { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll' ] },
                    { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
                    { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl' ] },
                    { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                    { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'SpecialChar' ] },
                    { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                    { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                    { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] }
                ]
            });
        }

        const galleryInput = document.getElementById('gallery_images');
        const preview = document.getElementById('gallery-preview');

        if (galleryInput) {
            galleryInput.addEventListener('change', updateGalleryPreview);
        }

        function updateGalleryPreview() {
            preview.innerHTML = '';

            if (galleryInput.files) {
                Array.from(galleryInput.files).forEach((file, index) => {
                    // Create preview container
                    const container = document.createElement('div');
                    container.className = 'gallery-item-container';

                    // Create image preview
                    const imageContainer = document.createElement('div');
                    imageContainer.className = 'gallery-item';

                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.onload = function() {
                        URL.revokeObjectURL(this.src);
                    }
                    imageContainer.appendChild(img);
                    container.appendChild(imageContainer);

                    // Create caption input
                    const caption = document.createElement('input');
                    caption.type = 'text';
                    caption.name = `image_captions[${index}]`;
                    caption.placeholder = 'Image caption';
                    caption.className = 'gallery-caption shadow appearance-none border rounded py-1 px-2 text-gray-700 text-sm';
                    container.appendChild(caption);

                    preview.appendChild(container);
                });
            }
        }
    });

    function markForDeletion(imageId) {
        const container = document.querySelector(`.gallery-item-container[data-id="${imageId}"]`);
        const markedArea = document.getElementById('marked-for-deletion');

        if (container.classList.contains('marked-for-delete')) {
            // Unmark for deletion
            container.classList.remove('marked-for-delete');
            const inputToRemove = document.querySelector(`input[name="images_to_delete[]"][value="${imageId}"]`);
            if (inputToRemove) {
                inputToRemove.remove();
            }
        } else {
            // Mark for deletion
            container.classList.add('marked-for-delete');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'images_to_delete[]';
            input.value = imageId;
            markedArea.appendChild(input);
        }
    }
</script>
@endsection
