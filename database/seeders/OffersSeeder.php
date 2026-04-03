<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\FlashSale;
use App\Models\Bundle;
use App\Models\BundleProduct;
use Carbon\Carbon;

class OffersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some products for flash sales
        $products = Product::all();

        if ($products->count() >= 1) {
            // Create Flash Sales
            foreach ($products as $index => $product) {
                FlashSale::create([
                    'product_id' => $product->id,
                    'name' => 'عرض فلاش ' . ($index + 1),
                    'description' => 'خصم محدود الوقت على ' . $product->name,
                    'original_price' => $product->price,
                    'sale_price' => $product->price * 0.7, // 30% discount
                    'discount_percentage' => 30,
                    'start_at' => Carbon::now(),
                    'end_at' => Carbon::now()->addHours(24),
                    'is_active' => true,
                ]);
            }
        }

        // Create a Bundle if we have at least 2 products
        if ($products->count() >= 2) {
            $bundleProducts = $products->take(2);
            $bundle = Bundle::create([
                'name' => 'باقة الإلكترونيات الرائعة',
                'description' => 'احصل على منتجين بتخفيض كبير',
                'original_price' => $bundleProducts->sum('price'),
                'bundle_price' => $bundleProducts->sum('price') * 0.8, // 20% discount
                'discount_percentage' => 20,
                'is_active' => true,
            ]);

            // Add products to bundle
            foreach ($bundleProducts as $product) {
                BundleProduct::create([
                    'bundle_id' => $bundle->id,
                    'product_id' => $product->id,
                    'quantity' => 1,
                ]);
            }
        }
    }
}
