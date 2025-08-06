<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OffensiveWord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'word',
        'description',
        'severity',
        'is_active',
    ];

    protected $casts = [
        'severity' => 'string',
        'is_active' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeBySeverity($query, $severity)
    {
        return $query->where('severity', $severity);
    }

    public function scopeHighSeverity($query)
    {
        return $query->where('severity', 'high');
    }

    public function scopeMediumSeverity($query)
    {
        return $query->where('severity', 'medium');
    }

    public function scopeLowSeverity($query)
    {
        return $query->where('severity', 'low');
    }

    // Helper methods
    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function isHighSeverity(): bool
    {
        return $this->severity === 'high';
    }

    public function isMediumSeverity(): bool
    {
        return $this->severity === 'medium';
    }

    public function isLowSeverity(): bool
    {
        return $this->severity === 'low';
    }

    public function activate(): bool
    {
        return $this->update(['is_active' => true]);
    }

    public function deactivate(): bool
    {
        return $this->update(['is_active' => false]);
    }

    public function getSeverityBadgeColorAttribute(): string
    {
        return match($this->severity) {
            'high' => 'danger',
            'medium' => 'warning',
            'low' => 'info',
            default => 'gray',
        };
    }

    public function getSeverityLabelAttribute(): string
    {
        return match($this->severity) {
            'high' => __('messages.offensive_word.severity.high'),
            'medium' => __('messages.offensive_word.severity.medium'),
            'low' => __('messages.offensive_word.severity.low'),
            default => $this->severity,
        };
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return $this->is_active ? 'success' : 'gray';
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->is_active 
            ? __('messages.offensive_word.status.active')
            : __('messages.offensive_word.status.inactive');
    }
} 