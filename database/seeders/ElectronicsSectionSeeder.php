<?php

namespace Database\Seeders;

use App\Models\Section;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ElectronicsSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the Electronics and Devices section
        $section = Section::firstOrCreate(
            ['slug' => 'electronics-and-devices'],
            [
                'name' => 'الأجهزة والالكترونيات',
                'description' => 'تصفح أحدث الأجهزة والإلكترونيات بأفضل الأسعار',
                'icon' => '⚡',
            ]
        );

        // Create Electronics categories under this section
        $categories = [
            [
                'name' => 'الهواتف الذكية',
                'slug' => 'smartphones',
                'description' => 'أحدث موديلات الهواتف الذكية',
            ],
            [
                'name' => 'أجهزة الحاسوب',
                'slug' => 'computers',
                'description' => 'أجهزة الكمبيوتر المكتبية والمحمولة',
            ],
            [
                'name' => 'الأجهزة اللوحية',
                'slug' => 'tablets',
                'description' => 'الأجهزة اللوحية والآيباد',
            ],
            [
                'name' => 'الأكسسوارات',
                'slug' => 'accessories',
                'description' => 'أكسسوارات الهواتف والأجهزة',
            ],
            [
                'name' => 'السماعات والصوتيات',
                'slug' => 'audio',
                'description' => 'السماعات والمكبرات الصوتية',
            ],
            [
                'name' => 'كاميرات ومصورات',
                'slug' => 'cameras',
                'description' => 'كاميرات التصوير الاحترافية والعادية',
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(
                ['slug' => $categoryData['slug']],
                array_merge($categoryData, ['section_id' => $section->id])
            );
        }
    }
}
