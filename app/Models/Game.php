<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'is_active',
    ];

    public function categories()
    {
        return $this->hasMany(GameCategory::class);
    }

    public function activeCategories()
    {
        return $this->hasMany(GameCategory::class)->where('is_active', true);
    }
}
