<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // الحصول على فئة الإلكترونيات
        $electronics = Category::where('slug', 'electronics')->first();

        if ($electronics) {
            // إضافة منتج واحد عينة
            Product::create([
                'name' => 'طابعة ليزر احترافية HP LaserJet Pro M404n',
                'description' => 'طابعة ليزر أسود وأبيض عالية السرعة 40 صفحة/دقيقة، مثالية للمكاتب والشركات الصغيرة. جودة طباعة 1200 dpi، دعم شبكة Ethernet، سعة ورق 350 ورقة، توفير طاقة حتى 50%.',
                'category_id' => $electronics->id,
                'price' => 1599.99,
                'image' => null, // لا صورة افتراضية
                'stock' => 25,
            ]);

            // إضافة منتج رقمي عينة
            Product::create([
                'name' => 'قالب تصميم موقع إلكتروني احترافي',
                'description' => 'قالب HTML/CSS/JS جاهز للاستخدام مع تصميم responsive، يتضمن 10 صفحات، دعم Bootstrap 5، ملفات PSD، ودليل الاستخدام الكامل.',
                'category_id' => $electronics->id,
                'price' => 99.99,
                'image' => null, // لا صورة افتراضية
                'stock' => 100,
                'is_digital' => true,
                'file_path' => 'digital_products/website-template.zip',
            ]);
        }

        // إضافة بيانات إضافية اختيارية باستخدام Factory للاختبار
        // Product::factory()->count(5)->create();
    }
}

