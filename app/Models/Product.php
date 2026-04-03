<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'price',
        'image',
        'stock',
        'is_digital',
        'file_path',
        'parent_id',
        'currency',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if (! $this->image) {
            return null;
        }

        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        return Storage::disk('public')->url($this->image);
    }

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_digital' => 'boolean',
        ];
    }

    /**
     * Get the product's specific discounts.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the parent product (if this is a variant).
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'parent_id');
    }

    /**
     * Get the product variants.
     */
    public function variants(): HasMany
    {
        return $this->hasMany(Product::class, 'parent_id');
    }

    /**
     * Get the product's specific discounts.
     */
    public function discounts(): HasMany
    {
        return $this->hasMany(Discount::class);
    }

    /**
     * Get the active specific discount for this product
     */
    public function getActiveDiscount(): ?Discount
    {
        return $this->discounts()
            ->where('type', 'specific')
            ->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->where('used_count', '<', \DB::raw('usage_limit'))
            ->first();
    }
}
