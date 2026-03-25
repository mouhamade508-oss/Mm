<?php

namespace Database\Seeders;

use App\Models\Discount;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Discount عام للاختبار
        Discount::firstOrCreate(
            ['code' => 'TEST20'],
            [
                'percentage' => 20,
                'type' => 'general',
                'valid_from' => now(),
                'valid_until' => now()->addDays(30),
                'usage_limit' => 1000,
                'used_count' => 0,
                'is_active' => true,
                'description' => 'خصم تجريبي عام 20%',
            ]
        );

        Discount::firstOrCreate(
            ['code' => 'WELCOME'],
            [
                'percentage' => 15,
                'type' => 'general',
                'valid_from' => now(),
                'valid_until' => now()->addDays(60),
                'usage_limit' => 500,
                'used_count' => 0,
                'is_active' => true,
                'description' => 'كود ترحيب للعملاء الجدد - خصم 15%',
            ]
        );
    }
}
