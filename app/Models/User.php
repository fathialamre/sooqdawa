<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'type',
        'fcm_token',
        'is_active',
        'country_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the country that the user belongs to.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Users that this user is following
     */
    public function following(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id')
            ->withTimestamps();
    }

    /**
     * Users that are following this user
     */
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id')
            ->withTimestamps();
    }

    /**
     * Check if this user is following another user
     */
    public function isFollowing(User $user): bool
    {
        return $this->following()->where('following_id', $user->id)->exists();
    }

    /**
     * Check if this user is followed by another user
     */
    public function isFollowedBy(User $user): bool
    {
        return $this->followers()->where('follower_id', $user->id)->exists();
    }

    /**
     * Follow a user
     */
    public function follow(User $user): void
    {
        if (!$this->isFollowing($user) && $this->id !== $user->id) {
            $this->following()->attach($user->id);
        }
    }

    /**
     * Unfollow a user
     */
    public function unfollow(User $user): void
    {
        $this->following()->detach($user->id);
    }

    /**
     * Get followers count
     */
    public function getFollowersCountAttribute(): int
    {
        return $this->followers()->count();
    }

    /**
     * Get following count
     */
    public function getFollowingCountAttribute(): int
    {
        return $this->following()->count();
    }

    /**
     * Register media collections for user avatars
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
     * Check if user has an avatar
     */
    public function hasAvatar(): bool
    {
        return $this->hasMedia('avatar');
    }

    /**
     * Get all user plans
     */
    public function userPlans(): HasMany
    {
        return $this->hasMany(UserPlan::class);
    }

    /**
     * Get the current active plan
     */
    public function activePlan(): HasOne
    {
        return $this->hasOne(UserPlan::class)
            ->where('status', 'active')
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->latest();
    }

    /**
     * Check if user has an active plan
     */
    public function hasActivePlan(): bool
    {
        return $this->activePlan()->exists();
    }

    /**
     * Get the current active plan record
     */
    public function getCurrentPlan(): ?UserPlan
    {
        return $this->activePlan;
    }

    /**
     * Subscribe to a plan
     */
    public function subscribeToPlan(Plan $plan, bool $cancelExisting = true): UserPlan
    {
        // Cancel existing active plan if requested
        if ($cancelExisting && $this->hasActivePlan()) {
            $this->activePlan->cancel();
        }

        // Create new user plan
        $userPlan = $this->userPlans()->create([
            'plan_id' => $plan->id,
            'status' => 'active',
            'starts_at' => now(),
            'ends_at' => now()->addMonths($plan->duration_months),
        ]);

        return $userPlan;
    }

    /**
     * Cancel current active plan
     */
    public function cancelActivePlan(): bool
    {
        $activePlan = $this->getCurrentPlan();
        
        if ($activePlan) {
            $activePlan->cancel();
            return true;
        }

        return false;
    }

    /**
     * Get all posts by this user
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get all comments by this user
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get all likes by this user
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Get all wallet transactions for this user
     */
    public function walletTransactions(): HasMany
    {
        return $this->hasMany(Wallet::class);
    }

    /**
     * Get all complaints by this user
     */
    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }

    /**
     * Get all posts saved by this user
     */
    public function savedPosts(): HasMany
    {
        return $this->hasMany(SavedPost::class);
    }

    /**
     * Get user's current wallet balance
     */
    public function getWalletBalanceAttribute(): float
    {
        $credits = $this->walletTransactions()->sum('credit');
        $debits = $this->walletTransactions()->sum('debit');
        return $credits - $debits;
    }

    /**
     * Get formatted wallet balance
     */
    public function getFormattedWalletBalanceAttribute(): string
    {
        return number_format($this->wallet_balance, 2);
    }

    /**
     * Add credit to user's wallet
     */
    public function addCredit(float $amount, ?int $voucherId = null, ?string $description = null): Wallet
    {
        return Wallet::createCredit($this->id, $amount, $voucherId, $description);
    }

    /**
     * Deduct amount from user's wallet
     */
    public function deductAmount(float $amount, ?string $description = null): Wallet
    {
        return Wallet::createDebit($this->id, $amount, $description);
    }

    /**
     * Check if user has sufficient wallet balance
     */
    public function hasSufficientBalance(float $amount): bool
    {
        return $this->wallet_balance >= $amount;
    }

    /**
     * Scope to get only active users
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
