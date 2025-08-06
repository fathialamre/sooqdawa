<?php

namespace App\Models;

use App\Enums\BannerType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Banner extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'type',
        'external_link',
        'is_active',
        'model_id',
        'model',
    ];

    protected function casts(): array
    {
        return [
            'type' => BannerType::class,
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the related model (Post, Department, etc.)
     */
    public function getRelatedModel()
    {
        if (!$this->model_id || !$this->model) {
            return null;
        }

        return $this->model::find($this->model_id);
    }

    /**
     * Get the Post if this banner is linked to a post
     */
    public function post()
    {
        if ($this->model === 'App\\Models\\Post') {
            return Post::find($this->model_id);
        }
        return null;
    }

    /**
     * Get the Department if this banner is linked to a department
     */
    public function department()
    {
        if ($this->model === 'App\\Models\\Department') {
            return Department::find($this->model_id);
        }
        return null;
    }

    /**
     * Scope to get only active banners
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get only inactive banners
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope to filter by type
     */
    public function scopeOfType($query, BannerType $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Mark banner as active
     */
    public function markAsActive(): bool
    {
        return $this->update(['is_active' => true]);
    }

    /**
     * Mark banner as inactive
     */
    public function markAsInactive(): bool
    {
        return $this->update(['is_active' => false]);
    }

    /**
     * Register media collections for banner images
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('banner_image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/avif']);
    }

    /**
     * Register media conversions for banner images
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(200)
            ->sharpen(10)
            ->performOnCollections('banner_image');

        $this->addMediaConversion('large')
            ->width(1200)
            ->height(600)
            ->sharpen(10)
            ->performOnCollections('banner_image');
    }

    /**
     * Get the banner image URL
     */
    public function getBannerImageUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('banner_image');
    }

    /**
     * Get the banner image thumbnail URL
     */
    public function getBannerImageThumbUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('banner_image', 'thumb');
    }

    /**
     * Get the banner image large URL
     */
    public function getBannerImageLargeUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('banner_image', 'large');
    }

    /**
     * Check if banner has an image
     */
    public function hasBannerImage(): bool
    {
        return $this->hasMedia('banner_image');
    }
}