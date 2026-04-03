<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    protected $fillable = [
        'name',
        'description',
        'original_price',
        'bundle_price',
        'discount_percentage',
        'image',
        'is_active',
        'max_quantity',
        'sold_quantity'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function bundleProducts()
    {
        return $this->hasMany(BundleProduct::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'bundle_products')
                    ->withPivot('quantity');
    }

    public function getTotalOriginalPrice()
    {
        return $this->bundleProducts->sum(function ($bundleProduct) {
            return $bundleProduct->product->price * $bundleProduct->quantity;
        });
    }

    public function getSavings()
    {
        return $this->getTotalOriginalPrice() - $this->bundle_price;
    }

    public function canPurchase($quantity = 1)
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->max_quantity && ($this->sold_quantity + $quantity) > $this->max_quantity) {
            return false;
        }

        return true;
    }
}
