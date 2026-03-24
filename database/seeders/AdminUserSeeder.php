<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'mouhamad.deop@gmail.com'],
            [
                'name' => 'Admin',
                'email' => 'mouhamad.deop@gmail.com',
                'password' => Hash::make('admin123'),
            ]
        );

        echo "✅ Admin user created/updated: mouhamad.deop@gmail.com / admin123\n";
    }
}

