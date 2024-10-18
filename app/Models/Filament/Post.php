<?php

namespace App\Models\Filament;

use App\Models\Filament\UserFilament;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory, SoftDeletes, HasTranslations;

    public $translatable = ['title', 'content', 'seo_description'];

    protected $fillable = [
        'title',
        'content',
        'slug',
        'user_filament_id',
        'is_published',
        'banner_filename',
        'cover_filename',
        'seo_keywords',
        'seo_description',
    ];

    protected $appends = [
        'banner_url',
        'cover_url',
    ];

    protected $casts = [
        'created_at' => 'datetime:M d, Y',
    ];

    /**
     * Get the user filament that owns the post.
     *
     * This relationship indicates that each post belongs to a single user filament.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userFilament()
    {
        return $this->belongsTo(UserFilament::class, 'user_filament_id');
    }

    /**
     * Get the URL of the banner image.
     *
     * This accessor method constructs the full URL to the banner image
     * stored in the 'storage' directory. If the 'banner_filename' attribute
     * is not set, it returns null.
     *
     * @return string|null The URL of the banner image or null if not set.
     */
    public function getBannerUrlAttribute()
    {
        return $this->banner_filename ? asset('storage/' . $this->banner_filename) : null;
    }

    /**
     * Get the URL of the cover image.
     *
     * This accessor method constructs the full URL to the cover image
     * stored in the 'storage' directory. If the 'cover_filename' attribute
     * is not set, it returns null.
     *
     * @return string|null The URL of the cover image or null if not set.
     */
    public function getCoverUrlAttribute()
    {
        return $this->cover_filename ? asset('storage/' . $this->cover_filename) : null;
    }

    /**
     * Scope a query to only include published posts.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
