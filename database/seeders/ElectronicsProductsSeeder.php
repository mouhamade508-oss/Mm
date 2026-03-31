<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ElectronicsProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $electronicsCategory = Category::where('slug', 'electronics-devices')->firstOrFail();

        $products = [
            [
                'name' => 'شاحن سريع 65W',
                'description' => 'شاحن سريع عالي الجودة بقوة 65W مع منافذ USB متعددة، آمن وسريع',
                'price' => 89.99,
                'requires_whatsapp' => true,
                'order_method' => 'whatsapp',
                'whatsapp_phone' => '966501234567',
            ],
            [
                'name' => 'كابل USB-C عالي السرعة',
                'description' => 'كابل USB-C أصلي بدعم البيانات السريعة والشحن السريع',
                'price' => 29.99,
                'requires_whatsapp' => true,
                'order_method' => 'whatsapp',
                'whatsapp_phone' => '966501234567',
            ],
            [
                'name' => 'شاشة حماية الهاتف',
                'description' => 'شاشة حماية زجاجية مقسّاة ضد الخدوش والكسور بدقة 9H',
                'price' => 19.99,
                'requires_whatsapp' => true,
                'order_method' => 'whatsapp',
                'whatsapp_phone' => '966501234567',
            ],
            [
                'name' => 'سماعات بلوتوث لاسلكية',
                'description' => 'سماعات بلوتوث بجودة صوت عالية مع بطارية تدوم 30 ساعة',
                'price' => 149.99,
                'requires_whatsapp' => true,
                'order_method' => 'whatsapp',
                'whatsapp_phone' => '966501234567',
            ],
            [
                'name' => 'حامل الهاتف للسيارة',
                'description' => 'حامل آمن وثابت للهاتف في السيارة بتصميم عصري',
                'price' => 39.99,
                'requires_whatsapp' => true,
                'order_method' => 'whatsapp',
                'whatsapp_phone' => '966501234567',
            ],
            [
                'name' => 'بطارية خارجية 20000mAh',
                'description' => 'بطارية قوية بسعة 20000mAh مع منافذ متعددة وشحن سريع',
                'price' => 79.99,
                'requires_whatsapp' => true,
                'order_method' => 'whatsapp',
                'whatsapp_phone' => '966501234567',
            ],
            [
                'name' => 'حقيبة حماية الهاتف',
                'description' => 'حقيبة قوية مع حماية ضد الصدمات والماء لجميع أحجام الهواتف',
                'price' => 49.99,
                'requires_whatsapp' => true,
                'order_method' => 'whatsapp',
                'whatsapp_phone' => '966501234567',
            ],
            [
                'name' => 'كاميرا ويب بجودة 1080p',
                'description' => 'كاميرا ويب احترافية لمكالمات الفيديو والبث المباشر',
                'price' => 129.99,
                'requires_whatsapp' => true,
                'order_method' => 'whatsapp',
                'whatsapp_phone' => '966501234567',
            ],
        ];

        foreach ($products as $productData) {
            Product::create([
                'category_id' => $electronicsCategory->id,
                'name' => $productData['name'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'requires_whatsapp' => $productData['requires_whatsapp'],
                'order_method' => $productData['order_method'],
                'whatsapp_phone' => $productData['whatsapp_phone'],
            ]);
        }
    }
}
