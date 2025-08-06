<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    // Scopes
    public function scopeForPost($query, $postId)
    {
        return $query->where('post_id', $postId);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Helper methods
    public static function toggleLike($postId, $userId): bool
    {
        $like = static::where('post_id', $postId)->where('user_id', $userId)->first();
        
        if ($like) {
            $like->delete();
            return false; // Unliked
        } else {
            static::create([
                'post_id' => $postId,
                'user_id' => $userId,
            ]);
            return true; // Liked
        }
    }

    public static function isLikedByUser($postId, $userId): bool
    {
        return static::where('post_id', $postId)->where('user_id', $userId)->exists();
    }
}
