<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameCategory extends Model
{
    protected $fillable = [
        'game_id',
        'name',
        'description',
        'price',
        'is_active',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
