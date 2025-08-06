<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complaint extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'body',
        'user_id',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Helper methods
    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    public function isResolved(): bool
    {
        return $this->status === 'resolved';
    }

    public function markAsResolved(): bool
    {
        return $this->update(['status' => 'resolved']);
    }

    public function markAsOpen(): bool
    {
        return $this->update(['status' => 'open']);
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'open' => 'warning',
            'resolved' => 'success',
            default => 'gray',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'open' => __('messages.complaint.status.open'),
            'resolved' => __('messages.complaint.status.resolved'),
            default => $this->status,
        };
    }
} 