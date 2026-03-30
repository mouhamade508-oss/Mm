<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameRechargeRequest extends Model
{
    protected $fillable = [
        'game_id',
        'game_category_id',
        'game_name',
        'category_name',
        'player_id',
        'proof_image',
        'transaction_number',
        'customer_name',
        'customer_phone',
        'notes',
        'status',
    ];

    public function gameCategory()
    {
        return $this->belongsTo(GameCategory::class);
    }
}
