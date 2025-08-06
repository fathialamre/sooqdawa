<?php

namespace App\Models;

use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'department_id',
        'company',
        'city_id',
        'country_id',
        'address',
        'number_of_views',
        'activity',
        'phone',
        'description',
        'price',
        'currency',
        'user_id',
        'status',
        'tags',
    ];

    protected $casts = [
        'tags' => 'array',
        'price' => 'decimal:2',
        'number_of_views' => 'integer',
        'status' => PostStatus::class,
    ];

    // Relationships
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function savers(): HasMany
    {
        return $this->hasMany(SavedPost::class);
    }

    public function banners(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Banner::class, 'model_id')
            ->where('model', Post::class);
    }

    // Media Library Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg']);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->sharpen(10)
            ->performOnCollections('images');

        $this->addMediaConversion('preview')
            ->width(800)
            ->height(600)
            ->sharpen(10)
            ->performOnCollections('images');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', PostStatus::PUBLISHED);
    }

    public function scopeDraft($query)
    {
        return $query->where('status', PostStatus::DRAFT);
    }

    public function scopeArchived($query)
    {
        return $query->where('status', PostStatus::ARCHIVED);
    }

    // Accessors
    public function getFormattedPriceAttribute(): string
    {
        if (!$this->price || !$this->currency) {
            return 'غير محدد';
        }
        
        return number_format((float) $this->price, 2) . ' ' . $this->currency;
    }

    // Mutators
    public function incrementViews(): void
    {
        $this->increment('number_of_views');
    }

    // Helper methods for comments and likes
    public function getCommentsCountAttribute(): int
    {
        return $this->comments()->count();
    }

    public function getLikesCountAttribute(): int
    {
        return $this->likes()->count();
    }

    public function isLikedByUser($userId): bool
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    public function toggleLike($userId): bool
    {
        return Like::toggleLike($this->id, $userId);
    }
}
