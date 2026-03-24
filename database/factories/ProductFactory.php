<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'طابعة ليزر عالية الجودة HP LaserJet Pro',
                'لابتوب Lenovo ThinkPad Gaming',
                'هاتف آيفون 15 برو ماكس 256 جيجا',
                'سماعات بلوتوث Sony WH-1000XM5',
                'كاميرا DSLR Canon EOS R6'
            ]),
            'description' => $this->faker->paragraph(3),
            'category' => $this->faker->randomElement(['إلكترونيات', 'ملابس', 'إكسسوارات', 'أجهزة منزلية']),
            'price' => $this->faker->randomFloat(2, 50, 5000),
            'image' => 'products/sample-' . $this->faker->numberBetween(1,5) . '.jpg',
            'stock' => $this->faker->numberBetween(5, 100),
        ];
    }
}

