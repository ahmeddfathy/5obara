<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        return view('blog.index', compact('posts'));
    }

    /**
     * Display the specified resource.
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

        // If no gallery images exist, create a virtual gallery using the featured image
        if ($galleryImages->isEmpty() && $post->featured_image) {
            $virtualGallery = true;
        } else {
            $virtualGallery = false;
        }

        // Get similar posts based on investment type and location
        $similarPosts = Post::where('id', '!=', $post->id) // Exclude current post
            ->where(function($query) use ($post) {
                $query->where('investment_type', $post->investment_type)
                    ->orWhere('location', $post->location);
            })
            ->where('is_published', true)
            ->latest()
            ->take(3)
            ->get();

        return view('blog.show', compact('post', 'galleryImages', 'virtualGallery', 'similarPosts'));
    }

    /**
     * Display investment opportunities.
     */
    public function opportunities()
    {
        $posts = Post::where('is_published', true)
            ->whereNotNull('investment_amount')
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        return view('blog.opportunities', compact('posts'));
    }
}
