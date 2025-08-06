<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'credit',
        'debit',
        'balance',
        'voucher_id',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'credit' => 'decimal:2',
            'debit' => 'decimal:2',
            'balance' => 'decimal:2',
        ];
    }

    /**
     * Get the user that owns this wallet transaction
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the voucher associated with this wallet transaction (if any)
     */
    public function voucher(): BelongsTo
    {
        return $this->belongsTo(Voucher::class);
    }

    /**
     * Scope to get credit transactions
     */
    public function scopeCredits($query)
    {
        return $query->where('credit', '>', 0);
    }

    /**
     * Scope to get debit transactions
     */
    public function scopeDebits($query)
    {
        return $query->where('debit', '>', 0);
    }

    /**
     * Scope to get transactions for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to get voucher-related transactions
     */
    public function scopeVoucherTransactions($query)
    {
        return $query->whereNotNull('voucher_id');
    }

    /**
     * Create a credit transaction
     */
    public static function createCredit(int $userId, float $amount, ?int $voucherId = null, ?string $description = null): self
    {
        // Get user's current balance
        $currentBalance = self::where('user_id', $userId)->sum('credit') - self::where('user_id', $userId)->sum('debit');
        $newBalance = $currentBalance + $amount;

        return self::create([
            'user_id' => $userId,
            'credit' => $amount,
            'debit' => 0,
            'balance' => $newBalance,
            'voucher_id' => $voucherId,
            'description' => $description ?? 'Credit transaction',
        ]);
    }

    /**
     * Create a debit transaction
     */
    public static function createDebit(int $userId, float $amount, ?string $description = null): self
    {
        // Get user's current balance
        $currentBalance = self::where('user_id', $userId)->sum('credit') - self::where('user_id', $userId)->sum('debit');
        $newBalance = $currentBalance - $amount;

        return self::create([
            'user_id' => $userId,
            'credit' => 0,
            'debit' => $amount,
            'balance' => $newBalance,
            'voucher_id' => null,
            'description' => $description ?? 'Debit transaction',
        ]);
    }

    /**
     * Get formatted credit amount
     */
    public function getFormattedCreditAttribute(): string
    {
        return $this->credit > 0 ? '+' . number_format((float) $this->credit, 2) : '';
    }

    /**
     * Get formatted debit amount
     */
    public function getFormattedDebitAttribute(): string
    {
        return $this->debit > 0 ? '-' . number_format((float) $this->debit, 2) : '';
    }

    /**
     * Get formatted balance
     */
    public function getFormattedBalanceAttribute(): string
    {
        return number_format((float) $this->balance, 2);
    }

    /**
     * Check if this is a credit transaction
     */
    public function isCredit(): bool
    {
        return $this->credit > 0;
    }

    /**
     * Check if this is a debit transaction
     */
    public function isDebit(): bool
    {
        return $this->debit > 0;
    }

    /**
     * Check if this transaction is voucher-related
     */
    public function isVoucherTransaction(): bool
    {
        return !is_null($this->voucher_id);
    }
}