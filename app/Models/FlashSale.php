<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    protected $fillable = [
        'name',
        'description',
        'product_id',
        'discount_percentage',
        'original_price',
        'sale_price',
        'start_at',
        'end_at',
        'is_active',
        'max_quantity',
        'sold_quantity'
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function isActive()
    {
        return $this->is_active && now()->between($this->start_at, $this->end_at);
    }

    public function getRemainingTime()
    {
        if (!$this->isActive()) {
            return null;
        }

        return now()->diff($this->end_at);
    }

    public function canPurchase($quantity = 1)
    {
        if (!$this->isActive()) {
            return false;
        }

        if ($this->max_quantity && ($this->sold_quantity + $quantity) > $this->max_quantity) {
            return false;
        }

        return true;
    }

    public function timeRemaining()
    {
        if (!$this->isActive()) {
            return 0;
        }

        return now()->diffInSeconds($this->end_at, false);
    }
}
