<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Discount extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'description',
        'percentage',
        'type',
        'product_id',
        'applies_to',
        'valid_from',
        'valid_until',
        'usage_limit',
        'used_count',
        'is_active',
    ];

    protected $casts = [
        'percentage' => 'decimal:2',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the product that this discount belongs to (if specific discount).
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Check if discount is still valid
     */
    public function isValid(): bool
    {
        $now = now();
        
        return $this->is_active 
            && $now->greaterThanOrEqualTo($this->valid_from) 
            && $now->lessThanOrEqualTo($this->valid_until)
            && $this->used_count < $this->usage_limit;
    }

    /**
     * Check if discount is valid for the given purpose.
     */
    public function isValidForPurpose(string $purpose = 'products', ?int $productId = null): bool
    {
        if (! $this->isValid()) {
            return false;
        }

        if ($this->type === 'specific') {
            if ($productId === null) {
                return false;
            }
            if ($this->product_id !== $productId) {
                return false;
            }
        }

        if ($this->applies_to === 'all') {
            return true;
        }

        if ($purpose === 'game_recharge') {
            return $this->applies_to === 'game_recharge';
        }

        return $this->applies_to === 'products';
    }

    /**
     * Calculate discount amount based on price
     */
    public function calculateDiscount($price): float
    {
        if (!$this->isValid()) {
            return 0;
        }
        
        return ($price * $this->percentage) / 100;
    }

    /**
     * Calculate final price after discount
     */
    public function calculateFinalPrice($price): float
    {
        return $price - $this->calculateDiscount($price);
    }

    /**
     * Increment usage count
     */
    public function incrementUsage(): void
    {
        if ($this->used_count < $this->usage_limit) {
            $this->increment('used_count');
        }
    }
}

