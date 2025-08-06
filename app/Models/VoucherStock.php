<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VoucherStock extends Model
{
    use SoftDeletes;

    protected $table = 'voucher_stock';

    protected $fillable = [
        'voucher_id',
        'pin',
        'used',
        'used_at',
    ];

    protected function casts(): array
    {
        return [
            'used' => 'boolean',
            'used_at' => 'datetime',
        ];
    }

    /**
     * Get the voucher that owns this stock.
     */
    public function voucher(): BelongsTo
    {
        return $this->belongsTo(Voucher::class);
    }

    /**
     * Scope to get only unused stock
     */
    public function scopeUnused($query)
    {
        return $query->where('used', false);
    }

    /**
     * Scope to get only used stock
     */
    public function scopeUsed($query)
    {
        return $query->where('used', true);
    }

    /**
     * Mark stock as used
     */
    public function markAsUsed(): bool
    {
        return $this->update([
            'used' => true,
            'used_at' => now(),
        ]);
    }

    /**
     * Mark stock as unused
     */
    public function markAsUnused(): bool
    {
        return $this->update([
            'used' => false,
            'used_at' => null,
        ]);
    }

    /**
     * Check if this stock item is available (not used and not deleted)
     */
    public function isAvailable(): bool
    {
        return !$this->used && !$this->trashed();
    }

    /**
     * Generate a random unique 12-digit PIN
     */
    public static function generateUniquePin(): string
    {
        do {
            // Generate a 12-digit random number
            $pin = str_pad((string) random_int(0, 999999999999), 12, '0', STR_PAD_LEFT);
        } while (self::where('pin', $pin)->exists());

        return $pin;
    }

    /**
     * Create multiple voucher stock items with auto-generated PINs
     */
    public static function createBulkStock(int $voucherId, int $quantity): array
    {
        $stockItems = [];
        
        for ($i = 0; $i < $quantity; $i++) {
            $stockItems[] = self::create([
                'voucher_id' => $voucherId,
                'pin' => self::generateUniquePin(),
                'used' => false,
            ]);
        }

        return $stockItems;
    }
}