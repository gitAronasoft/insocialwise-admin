<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        if (!AdminUser::where('email', 'admin@insocialwise.com')->exists()) {
            AdminUser::create([
                'name' => 'Super Admin',
                'email' => 'admin@insocialwise.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]);
        }
    }
}
