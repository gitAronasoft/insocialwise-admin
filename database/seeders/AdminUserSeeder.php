<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@insocialwise.com');
        $password = env('ADMIN_PASSWORD', 'changeme');
        
        if (!AdminUser::where('email', $email)->exists()) {
            AdminUser::create([
                'name' => 'Super Admin',
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]);
        }
    }
}
