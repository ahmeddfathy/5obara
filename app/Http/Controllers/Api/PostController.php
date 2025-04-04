<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the blog posts.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $posts = Post::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        return response()->json([
            'status' => 'success',
            'data' => $posts,
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total()
            ]
        ]);
    }

    /**
     * Display the specified post.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Post $post)
    {
        // Make sure tags is always an array
        if ($post->tags) {
            if (is_string($post->tags)) {
                $post->tags = json_decode($post->tags) ?: [];
            }
        } else {
            $post->tags = [];
        }

        // Make sure investment_highlights is always an array
        if ($post->investment_highlights) {
            if (is_string($post->investment_highlights)) {
                $post->investment_highlights = json_decode($post->investment_highlights) ?: [];
            }
        } else {
            $post->investment_highlights = [];
        }

        // Load gallery images
        $galleryImages = $post->images()->orderBy('sort_order')->get();
        $post->gallery_images = $galleryImages;

        // If no gallery images exist, create a virtual gallery using the featured image
        $post->has_virtual_gallery = $galleryImages->isEmpty() && $post->featured_image;

        return response()->json([
            'status' => 'success',
            'data' => $post
        ]);
    }

    /**
     * Display investment opportunities.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function opportunities()
    {
        $posts = Post::where('is_published', true)
            ->whereNotNull('investment_amount')
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        return response()->json([
            'status' => 'success',
            'data' => $posts,
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total()
            ]
        ]);
    }

    /**
     * Return a list of all post categories/tags
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function categories()
    {
        $posts = Post::where('is_published', true)
            ->whereNotNull('tags')
            ->get();

        $allTags = [];
        foreach ($posts as $post) {
            $tags = is_string($post->tags) ? json_decode($post->tags) : $post->tags;
            if (is_array($tags)) {
                $allTags = array_merge($allTags, $tags);
            }
        }

        $uniqueTags = array_values(array_unique($allTags));

        return response()->json([
            'status' => 'success',
            'data' => $uniqueTags
        ]);
    }

    /**
     * Return latest investment opportunities sorted by amount
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function featuredInvestments()
    {
        $posts = Post::where('is_published', true)
            ->whereNotNull('investment_amount')
            ->orderBy('investment_amount', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $posts
        ]);
    }
}
