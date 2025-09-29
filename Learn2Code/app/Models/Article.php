<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Article extends Model
{
    protected $fillable = [
        'title',
        'excerpt',
        'content',
        'featured_image',
        'author',
        'tags',
        'status',
        'views',
        'featured',
        'slug',
        'meta_description',
        'published_at'
    ];

    protected $casts = [
        'tags' => 'array',
        'featured' => 'boolean',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Auto-generate slug from title
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = static::generateUniqueSlug($article->title);
            }
        });

        static::updating(function ($article) {
            if ($article->isDirty('title') && empty($article->slug)) {
                $article->slug = static::generateUniqueSlug($article->title);
            }
        });
    }

    private static function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    // Accessors
    public function getFormattedPublishedAtAttribute()
    {
        if (!$this->published_at) return null;

        return $this->published_at->locale('th')->format('d M Y');
    }

    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $readingTime = ceil($wordCount / 200); // Average 200 words per minute
        return $readingTime . ' นาที';
    }

    public function getExcerptOrContentAttribute()
    {
        return $this->excerpt ?: Str::limit(strip_tags($this->content), 150);
    }

    // Increment views
    public function incrementViews()
    {
        $this->increment('views');
    }

    // Check if published
    public function isPublished()
    {
        return $this->status === 'published' &&
               $this->published_at &&
               $this->published_at <= now();
    }
}
