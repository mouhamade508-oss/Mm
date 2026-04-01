<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Game extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'is_active',
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

        // Old Local disk images fallback
        return Storage::disk('public')->url($this->image);
    }

    public function categories()
    {
        return $this->hasMany(GameCategory::class);
    }

    public function activeCategories()
    {
        return $this->hasMany(GameCategory::class)->where('is_active', true);
    }
}
