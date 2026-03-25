<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'إلكترونيات',
                'slug' => 'electronics',
                'description' => 'جميع المنتجات الإلكترونية والأجهزة الحديثة'
            ],
            [
                'name' => 'ملابس',
                'slug' => 'clothing',
                'description' => 'الملابس والموضة للرجال والنساء والأطفال'
            ],
            [
                'name' => 'إكسسوارات',
                'slug' => 'accessories',
                'description' => 'الإكسسوارات والمجوهرات والحقائب'
            ],
            [
                'name' => 'منزليات',
                'slug' => 'home',
                'description' => 'المنتجات المنزلية والديكور'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
