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

    /* تنسيقات محرر CKEditor 5 */
    .ck-editor__editable {
        min-height: 400px !important;
        max-height: none !important;
        direction: rtl !important;
    }

    .ck.ck-editor__main > .ck-editor__editable {
        background: #fff;
        border: 1px solid #d3d3d3;
        padding: 2rem;
    }

    .ck.ck-toolbar {
        direction: rtl !important;
        background: #f8f9fa;
        border: 1px solid #d3d3d3;
        padding: 8px;
    }

    .ck.ck-content {
        min-height: 400px;
        direction: rtl !important;
        text-align: right;
        font-size: 16px;
        line-height: 1.6;
    }

    /* تنسيقات الصور في المحرر */
    .ck-content .image {
        margin: 1em 0;
        text-align: center;
    }

    .ck-content .image > img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 0 auto;
    }

    .ck-content .image-style-side {
        float: right;
        margin-left: 1.5em;
        max-width: 50%;
    }

    .ck-content .image-style-align-left {
        float: left;
        margin-right: 1.5em;
    }

    .ck-content .image-style-align-right {
        float: right;
        margin-left: 1.5em;
    }

    .ck-content .image-style-align-center {
        margin-left: auto;
        margin-right: auto;
    }

    .ck-content .image-caption {
        color: #666;
        font-size: 0.9em;
        text-align: center;
    }
</style>

<!-- تضمين CKEditor 5 النسخة الكاملة مع دعم الصور -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/super-build/ckeditor.js"></script>
@endsection

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h1 class="text-2xl font-bold mb-6">Create New Post</h1>

        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="editor" class="block text-gray-700 text-sm font-bold mb-2">Content</label>
                <textarea id="editor" name="content">{{ old('content') }}</textarea>
                <div class="text-sm text-gray-500 mt-2">
                    <p>يمكنك إدراج الصور في أي مكان من المحتوى. استخدم الأزرار في شريط الأدوات لإضافة صور ومحتوى منسق.</p>
                </div>
            </div>

            <div class="mb-4">
                <label for="featured_image" class="block text-gray-700 text-sm font-bold mb-2">Featured Image</label>
                <input type="file" name="featured_image" id="featured_image" accept="image/*"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <p class="text-sm text-gray-500 mt-1">هذه الصورة ستظهر في الصفحة الرئيسية وفي أعلى صفحة المقال</p>
            </div>

            <div class="mb-4">
                <label for="gallery_images" class="block text-gray-700 text-sm font-bold mb-2">Gallery Images</label>
                <div class="border border-dashed border-gray-400 p-4 rounded">
                    <input type="file" name="gallery_images[]" id="gallery_images" accept="image/*" multiple
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <p class="text-sm text-gray-500 mt-1">You can select multiple images at once</p>

                    <div id="gallery-preview" class="gallery-preview mt-4"></div>
                </div>
            </div>

            <div class="mb-4">
                <label for="investment_amount" class="block text-gray-700 text-sm font-bold mb-2">Investment Amount</label>
                <input type="number" name="investment_amount" id="investment_amount" value="{{ old('investment_amount') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="investment_type" class="block text-gray-700 text-sm font-bold mb-2">Investment Type</label>
                <input type="text" name="investment_type" id="investment_type" value="{{ old('investment_type') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="location" class="block text-gray-700 text-sm font-bold mb-2">Location</label>
                <input type="text" name="location" id="location" value="{{ old('location') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="tags" class="block text-gray-700 text-sm font-bold mb-2">Tags (comma-separated)</label>
                <input type="text" name="tags" id="tags" value="{{ old('tags') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="investment_highlights" class="block text-gray-700 text-sm font-bold mb-2">Investment Highlights (comma-separated)</label>
                <input type="text" name="investment_highlights" id="investment_highlights" value="{{ old('investment_highlights') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <p class="text-sm text-gray-500 mt-1">For example: "Guaranteed ROI of 15%,Premium location,Fully managed property"</p>
            </div>

            <div class="mb-4">
                <label for="contact_info" class="block text-gray-700 text-sm font-bold mb-2">Contact Information</label>
                <textarea name="contact_info" id="contact_info" rows="3"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('contact_info') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}
                        class="form-checkbox h-4 w-4 text-blue-600">
                    <span class="ml-2 text-gray-700">Publish immediately</span>
                </label>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Create Post
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
        ClassicEditor
            .create(document.querySelector('#editor'), {
                toolbar: ['heading', '|', 'bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'imageUpload', '|', 'undo', 'redo'],
                language: 'ar',
                simpleUpload: {
                    uploadUrl: '{{ route('admin.ckeditor.upload') }}',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }
            })
            .then(editor => {
                console.log('Editor initialized successfully');
            })
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });

        // معالجة معرض الصور
        const galleryInput = document.getElementById('gallery_images');
        const preview = document.getElementById('gallery-preview');

        if (galleryInput) {
            galleryInput.addEventListener('change', updateGalleryPreview);
        }

        function updateGalleryPreview() {
            preview.innerHTML = '';

            if (galleryInput.files) {
                Array.from(galleryInput.files).forEach((file, index) => {
                    const container = document.createElement('div');
                    container.className = 'gallery-item-container';

                    const imageContainer = document.createElement('div');
                    imageContainer.className = 'gallery-item';

                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.onload = function() {
                        URL.revokeObjectURL(this.src);
                    }
                    imageContainer.appendChild(img);
                    container.appendChild(imageContainer);

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
</script>
@endsection

