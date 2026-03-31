<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ElectronicsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::firstOrCreate(
            ['slug' => 'electronics-devices'],
            [
                'name' => 'الكترونيات واجهزه',
                'description' => 'قسم منتجات الإلكترونيات والأجهزة الكهربائية',
            ]
        );
    }
}
