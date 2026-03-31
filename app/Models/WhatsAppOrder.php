<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsAppOrder extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'customer_name',
        'customer_phone',
        'quantity',
        'total_price',
        'message',
        'status',
        'whatsapp_link',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total_price' => 'decimal:2',
        ];
    }

    /**
     * Get the product associated with this WhatsApp order
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Generate WhatsApp message link
     */
    public function generateWhatsAppLink(): string
    {
        $phone = $this->product->whatsapp_phone;
        $message = "مرحباً، أريد طلب {$this->quantity} من {$this->product->name}. الإجمالي: {$this->total_price} ريال. الاسم: {$this->customer_name} - الهاتف: {$this->customer_phone}";
        $encodedMessage = urlencode($message);
        return "https://wa.me/{$phone}?text={$encodedMessage}";
    }
}
