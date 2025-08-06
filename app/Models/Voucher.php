<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Voucher extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'name',
        'is_active',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'price' => 'decimal:2',
        ];
    }

    /**
     * Get the voucher stock for this voucher.
     */
    public function voucherStock(): HasMany
    {
        return $this->hasMany(VoucherStock::class);
    }

    /**
     * Get unused voucher stock for this voucher.
     */
    public function unusedStock(): HasMany
    {
        return $this->hasMany(VoucherStock::class)->where('used', false);
    }

    /**
     * Get used voucher stock for this voucher.
     */
    public function usedStock(): HasMany
    {
        return $this->hasMany(VoucherStock::class)->where('used', true);
    }

    /**
     * Scope to get only active vouchers
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get only inactive vouchers
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Mark voucher as active
     */
    public function markAsActive(): bool
    {
        return $this->update(['is_active' => true]);
    }

    /**
     * Mark voucher as inactive
     */
    public function markAsInactive(): bool
    {
        return $this->update(['is_active' => false]);
    }

    /**
     * Check if voucher has available stock
     */
    public function hasAvailableStock(): bool
    {
        return $this->unusedStock()->exists();
    }

    /**
     * Get total stock count
     */
    public function getTotalStockAttribute(): int
    {
        return $this->voucherStock()->count();
    }

    /**
     * Get available stock count
     */
    public function getAvailableStockAttribute(): int
    {
        return $this->unusedStock()->count();
    }

    /**
     * Register media collections for voucher avatars
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
     * Check if voucher has an avatar
     */
    public function hasAvatar(): bool
    {
        return $this->hasMedia('avatar');
    }
}