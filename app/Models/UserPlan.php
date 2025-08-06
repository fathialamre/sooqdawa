<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'status',
        'starts_at',
        'ends_at',
        'cancelled_at',
        'expired_at',
        'is_expired',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'expired_at' => 'datetime',
            'is_expired' => 'boolean',
        ];
    }

    /**
     * Get the user that owns the user plan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the plan that belongs to the user plan.
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Check if the plan is currently active
     */
    public function isActive(): bool
    {
        return $this->status === 'active' 
            && $this->starts_at <= now() 
            && $this->ends_at >= now()
            && !$this->is_expired;
    }

    /**
     * Check if the plan has expired
     */
    public function isExpired(): bool
    {
        return $this->is_expired || $this->ends_at < now();
    }

    /**
     * Cancel the plan
     */
    public function cancel(): void
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);
    }

    /**
     * Activate the plan
     */
    public function activate(): void
    {
        // Deactivate any existing active plan for this user
        $this->user->userPlans()
            ->where('status', 'active')
            ->where('id', '!=', $this->id)
            ->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);

        $this->update([
            'status' => 'active',
            'starts_at' => now(),
            'ends_at' => now()->addMonths($this->plan->duration_months),
            'expired_at' => now()->addMonths($this->plan->duration_months),
            'cancelled_at' => null,
            'is_expired' => false,
        ]);
    }

    /**
     * Mark plan as expired
     */
    public function markAsExpired(): void
    {
        $this->update([
            'status' => 'expired',
            'is_expired' => true,
            'expired_at' => now(),
        ]);
    }

    /**
     * Scope to get active plans
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->where('is_expired', false);
    }

    /**
     * Scope to get expired plans
     */
    public function scopeExpired($query)
    {
        return $query->where(function ($q) {
            $q->where('is_expired', true)
              ->orWhere('ends_at', '<', now());
        });
    }

    /**
     * Scope to get plans by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        if ($this->isActive()) {
            return 'success';
        }
        
        if ($this->isExpired()) {
            return 'danger';
        }
        
        if ($this->status === 'cancelled') {
            return 'warning';
        }
        
        return 'gray';
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        if ($this->isActive()) {
            return 'Active';
        }
        
        if ($this->isExpired()) {
            return 'Expired';
        }
        
        if ($this->status === 'cancelled') {
            return 'Cancelled';
        }
        
        return ucfirst($this->status);
    }

    /**
     * Boot the model to handle automatic expiration
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($userPlan) {
            if (!$userPlan->starts_at) {
                $userPlan->starts_at = now();
            }
            if (!$userPlan->ends_at && $userPlan->plan) {
                $userPlan->ends_at = $userPlan->starts_at->addMonths($userPlan->plan->duration_months);
            }
            if (!$userPlan->expired_at && $userPlan->ends_at) {
                $userPlan->expired_at = $userPlan->ends_at;
            }
        });

        static::saving(function ($userPlan) {
            // Ensure only one active plan per user
            if ($userPlan->status === 'active' && $userPlan->isDirty('status')) {
                $userPlan->user->userPlans()
                    ->where('status', 'active')
                    ->where('id', '!=', $userPlan->id)
                    ->update([
                        'status' => 'cancelled',
                        'cancelled_at' => now(),
                    ]);
            }
        });
    }
}
