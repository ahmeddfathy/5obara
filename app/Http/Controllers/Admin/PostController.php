<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'featured_image' => 'nullable|image|max:2048',
            'gallery_images.*' => 'nullable|image|max:2048',
            'image_captions.*' => 'nullable|string|max:255',
            'investment_amount' => 'nullable|numeric',
            'investment_type' => 'nullable|string',
            'location' => 'nullable|string',
            'tags' => 'nullable',
            'investment_highlights' => 'nullable',
            'contact_info' => 'nullable|string',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date'
        ]);

        // Generate slug from title
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;

        // Check if slug already exists and append a suffix if needed
        $count = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count++;
        }

        $validated['slug'] = $slug;

        // Convert arrays to JSON
        if (!empty($validated['tags'])) {
            $validated['tags'] = json_encode(explode(',', $validated['tags']));
        }

        if (!empty($validated['investment_highlights'])) {
            $validated['investment_highlights'] = json_encode(explode(',', $validated['investment_highlights']));
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        // Set published date if publishing
        if ($request->has('is_published') && $request->is_published) {
            $validated['published_at'] = $validated['published_at'] ?? now();
        }

        DB::beginTransaction();

        try {
            // Create the post
            $post = Post::create($validated);

            // Handle gallery images
            if ($request->hasFile('gallery_images')) {
                $gallery_images = $request->file('gallery_images');
                $captions = $request->input('image_captions', []);

                foreach ($gallery_images as $index => $image) {
                    $path = $image->store('posts/gallery', 'public');

                    $post->images()->create([
                        'image_path' => $path,
                        'caption' => $captions[$index] ?? null,
                        'sort_order' => $index,
                        'is_primary' => $index === 0 // First image is primary
                    ]);
                }
            }

            // Save used images from temporary storage
            $this->cleanupUnusedQuillImages($validated['content'], $request);

            DB::commit();

            return redirect()->route('admin.posts.index')
                ->with('success', 'Post created successfully with ' .
                    ($request->hasFile('gallery_images') ? count($request->file('gallery_images')) : 0) .
                    ' gallery images.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', 'Failed to create post: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // Make sure tags and investment_highlights are properly transformed
        // from JSON to arrays before passing to the view
        if (is_string($post->tags)) {
            $post->tags = json_decode($post->tags) ?: [];
        }

        if (is_string($post->investment_highlights)) {
            $post->investment_highlights = json_decode($post->investment_highlights) ?: [];
        }

        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'featured_image' => 'nullable|image|max:2048',
            'gallery_images.*' => 'nullable|image|max:2048',
            'image_captions.*' => 'nullable|string|max:255',
            'existing_image_captions.*' => 'nullable|string|max:255',
            'existing_image_ids.*' => 'nullable|exists:post_images,id',
            'images_to_delete.*' => 'nullable|exists:post_images,id',
            'investment_amount' => 'nullable|numeric',
            'investment_type' => 'nullable|string',
            'location' => 'nullable|string',
            'tags' => 'nullable',
            'investment_highlights' => 'nullable',
            'contact_info' => 'nullable|string',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date'
        ]);

        // Generate slug from title if title changed
        if ($post->title !== $validated['title']) {
            $baseSlug = Str::slug($validated['title']);
            $slug = $baseSlug;

            // Check if slug already exists (excluding the current post) and append a suffix if needed
            $count = 1;
            while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }

            $validated['slug'] = $slug;
        }

        // Convert arrays to JSON
        if (isset($validated['tags'])) {
            $tagsArray = is_array($validated['tags'])
                ? $validated['tags']
                : explode(',', $validated['tags']);
            $validated['tags'] = json_encode($tagsArray);
        }

        if (isset($validated['investment_highlights'])) {
            $highlightsArray = is_array($validated['investment_highlights'])
                ? $validated['investment_highlights']
                : explode(',', $validated['investment_highlights']);
            $validated['investment_highlights'] = json_encode($highlightsArray);
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        // Set published date if publishing for the first time
        if ($request->has('is_published') && $validated['is_published'] && !$post->is_published) {
            $validated['published_at'] = $validated['published_at'] ?? now();
        }

        DB::beginTransaction();

        try {
            // Update the post
            $post->update($validated);

            // Update existing image captions
            if ($request->has('existing_image_captions') && $request->has('existing_image_ids')) {
                $captions = $request->input('existing_image_captions', []);
                $imageIds = $request->input('existing_image_ids', []);

                foreach ($imageIds as $index => $id) {
                    if (isset($captions[$index])) {
                        PostImage::where('id', $id)->update([
                            'caption' => $captions[$index]
                        ]);
                    }
                }
            }

            // Delete selected images
            if ($request->has('images_to_delete')) {
                foreach ($request->input('images_to_delete') as $imageId) {
                    $image = PostImage::find($imageId);
                    if ($image) {
                        Storage::disk('public')->delete($image->image_path);
                        $image->delete();
                    }
                }
            }

            // Add new gallery images
            if ($request->hasFile('gallery_images')) {
                $gallery_images = $request->file('gallery_images');
                $captions = $request->input('image_captions', []);
                $currentMaxOrder = $post->images()->max('sort_order') ?? -1;

                foreach ($gallery_images as $index => $image) {
                    $path = $image->store('posts/gallery', 'public');
                    $currentMaxOrder++;

                    $post->images()->create([
                        'image_path' => $path,
                        'caption' => $captions[$index] ?? null,
                        'sort_order' => $currentMaxOrder,
                        'is_primary' => $post->images()->count() === 0 && $index === 0 // Primary only if no other images
                    ]);
                }
            }

            // Save used images from temporary storage
            $this->cleanupUnusedQuillImages($validated['content'], $request);

            DB::commit();

            return redirect()->route('admin.posts.index')
                ->with('success', 'Post updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', 'Failed to update post: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        DB::beginTransaction();

        try {
            // Delete all gallery images
            foreach ($post->images as $image) {
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
                $image->delete();
            }

            // Delete featured image
            if ($post->featured_image && Storage::disk('public')->exists($post->featured_image)) {
                Storage::disk('public')->delete($post->featured_image);
            }

            // Delete content images
            $contentImages = Storage::disk('public')->files('posts/content');
            foreach ($contentImages as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }

            // Delete post
            $post->delete();

            DB::commit();

            return redirect()->route('admin.posts.index')
                ->with('success', 'Post and all associated images deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete post: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Failed to delete post. Please try again. If the problem persists, contact support.');
        }
    }

    /**
     * Handle image upload for the post content editor.
     */
    public function uploadImage(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|max:10240' // 10MB in KB
            ]);

            if (!$request->hasFile('image')) {
                return response()->json([
                    'error' => 'No image file was uploaded.'
                ], 400);
            }

            $file = $request->file('image');
            $path = $file->store('posts/content', 'public');

            if (!$path) {
                return response()->json([
                    'error' => 'Failed to store the image.'
                ], 500);
            }

            // Store image as temporary in session
            $tempImages = $request->session()->get('temp_quill_images', []);
            $tempImages[] = $path;
            $request->session()->put('temp_quill_images', $tempImages);

            return response()->json([
                'url' => asset('storage/' . $path)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to upload image. Please try again.'
            ], 500);
        }
    }

    /**
     * Clean up unused images uploaded through Quill editor
     */
    private function cleanupUnusedQuillImages($content, Request $request)
    {
        // Get temporary images from session
        $tempImages = $request->session()->get('temp_quill_images', []);

        if (empty($tempImages)) {
            // في حالة التعديل، قد لا تكون هناك صور مؤقتة في الجلسة
            // لذلك نقوم بفحص مجلد الصور مباشرة للتنظيف
            try {
                $contentImages = Storage::disk('public')->files('posts/content');
                if (empty($contentImages)) {
                    return;
                }

                foreach ($contentImages as $imagePath) {
                    $filename = basename($imagePath);
                    // تحقق مما إذا كانت الصورة مستخدمة في المحتوى
                    if (strpos($content, $filename) === false) {
                        // إذا كانت الصورة غير موجودة في المحتوى، قم بحذفها
                        Storage::disk('public')->delete($imagePath);
                    }
                }
                return;
            } catch (\Exception $e) {
                // لوج الخطأ واستمر
                Log::error('Error cleaning content images: ' . $e->getMessage());
                return;
            }
        }

        // Find which images are actually used in the content
        $usedImages = [];
        foreach ($tempImages as $imagePath) {
            $filename = basename($imagePath);

            // Check if the image is in the content
            if (strpos($content, $filename) !== false) {
                $usedImages[] = $imagePath;
            } else {
                // Delete unused image
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
        }

        // Clear the temporary images from session
        $request->session()->forget('temp_quill_images');
    }

    /**
     * Clear temporary images when user cancels form editing
     */
    public function clearTempImages(Request $request)
    {
        $tempImages = $request->session()->get('temp_quill_images', []);

        foreach ($tempImages as $imagePath) {
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $request->session()->forget('temp_quill_images');

        return response()->json(['success' => true]);
    }
}
