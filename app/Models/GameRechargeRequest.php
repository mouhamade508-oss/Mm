<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ReferralLink;

class GameRechargeRequest extends Model
{
    protected $fillable = [
        'game_id',
        'game_category_id',
        'game_name',
        'category_name',
        'player_id',
        'proof_code',
        'transaction_number',
        'customer_name',
        'customer_phone',
        'notes',
        'referral_code',
        'discount_code',
        'discount_id',
        'discount_percentage',
        'discount_amount',
        'original_price',
        'final_price',
        'status',
    ];

    public function gameCategory()
    {
        return $this->belongsTo(GameCategory::class);
    }

    public function referralLink()
    {
        return $this->belongsTo(ReferralLink::class, 'referral_code', 'code');
    }

    public function discount()
    {
        return $this->belongsTo(\App\Models\Discount::class, 'discount_id');
    }
}
