<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'featured_image',
        'investment_amount',
        'investment_type',
        'location',
        'tags',
        'investment_highlights',
        'contact_info',
        'is_published',
        'published_at'
    ];

    protected $casts = [
        'tags' => 'array',
        'investment_highlights' => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'investment_amount' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    /**
     * Get the gallery images for the post.
     */
    public function images()
    {
        return $this->hasMany(PostImage::class)->orderBy('sort_order');
    }

    /**
     * Get the primary gallery image for the post.
     */
    public function primaryImage()
    {
        return $this->hasOne(PostImage::class)->where('is_primary', true);
    }
}
