<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'uuid' => Str::uuid()->toString(),
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'phone' => '+1234567890',
                'country' => 'United States',
                'timezone' => 'America/New_York',
                'status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now()->subMonths(6),
                'updated_at' => now(),
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'phone' => '+1987654321',
                'country' => 'United Kingdom',
                'timezone' => 'Europe/London',
                'status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now()->subMonths(4),
                'updated_at' => now(),
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'name' => 'Bob Wilson',
                'email' => 'bob@example.com',
                'password' => Hash::make('password'),
                'phone' => '+1122334455',
                'country' => 'Canada',
                'timezone' => 'America/Toronto',
                'status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now()->subMonths(3),
                'updated_at' => now(),
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'name' => 'Alice Johnson',
                'email' => 'alice@example.com',
                'password' => Hash::make('password'),
                'phone' => '+1555666777',
                'country' => 'Australia',
                'timezone' => 'Australia/Sydney',
                'status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now()->subMonths(2),
                'updated_at' => now(),
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'name' => 'Charlie Brown',
                'email' => 'charlie@example.com',
                'password' => Hash::make('password'),
                'phone' => '+1888999000',
                'country' => 'Germany',
                'timezone' => 'Europe/Berlin',
                'status' => 'inactive',
                'email_verified_at' => null,
                'created_at' => now()->subMonths(1),
                'updated_at' => now(),
            ],
        ];

        $professionalPlanId = DB::table('subscription_plans')->where('slug', 'professional')->value('id');
        $starterPlanId = DB::table('subscription_plans')->where('slug', 'starter')->value('id');
        $businessPlanId = DB::table('subscription_plans')->where('slug', 'business')->value('id');

        foreach ($users as $index => $user) {
            DB::table('users')->insert($user);

            $planId = match($index) {
                0 => $professionalPlanId,
                1 => $businessPlanId,
                2 => $starterPlanId,
                3 => $professionalPlanId,
                default => $starterPlanId,
            };

            $plan = DB::table('subscription_plans')->find($planId);

            if ($index < 4) {
                $subscriptionId = DB::table('subscriptions')->insertGetId([
                    'user_uuid' => $user['uuid'],
                    'plan_id' => $planId,
                    'status' => 'active',
                    'amount' => $plan->price,
                    'currency' => 'USD',
                    'current_period_start' => now()->subDays(15),
                    'current_period_end' => now()->addDays(15),
                    'created_at' => $user['created_at'],
                    'updated_at' => now(),
                ]);

                DB::table('transactions')->insert([
                    'user_uuid' => $user['uuid'],
                    'subscription_id' => $subscriptionId,
                    'amount' => $plan->price,
                    'currency' => 'USD',
                    'status' => 'succeeded',
                    'description' => 'Subscription payment for ' . $plan->name,
                    'paid_at' => now()->subDays(15),
                    'created_at' => now()->subDays(15),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
