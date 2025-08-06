<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Plan extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'price',
        'duration_months',
        'description',
        'number_of_posts',
        'feature_posts',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'duration_months' => 'integer',
            'number_of_posts' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the user plans for this plan.
     */
    public function userPlans(): HasMany
    {
        return $this->hasMany(UserPlan::class);
    }

    /**
     * Get active user plans for this plan.
     */
    public function activeUserPlans(): HasMany
    {
        return $this->hasMany(UserPlan::class)->where('status', 'active');
    }

    /**
     * Register media collections for plan avatars
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
    }

    /**
     * Register media conversions for avatars
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->sharpen(10)
            ->performOnCollections('avatar');

        $this->addMediaConversion('preview')
            ->width(300)
            ->height(300)
            ->sharpen(10)
            ->performOnCollections('avatar');
    }

    /**
     * Get the avatar URL
     */
    public function getAvatarUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('avatar');
    }

    /**
     * Get the avatar thumbnail URL
     */
    public function getAvatarThumbUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('avatar', 'thumb');
    }

    /**
     * Check if plan has an avatar
     */
    public function hasAvatar(): bool
    {
        return $this->hasMedia('avatar');
    }

    /**
     * Scope to get only active plans
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
