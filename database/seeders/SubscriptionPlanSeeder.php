<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => 'Perfect for individuals and small businesses getting started with social media marketing.',
                'price' => 29.00,
                'currency' => 'USD',
                'billing_interval' => 'monthly',
                'trial_days' => 14,
                'features' => json_encode([
                    '5 Social Media Accounts',
                    '50 Scheduled Posts/month',
                    'Basic Analytics',
                    'Email Support',
                ]),
                'max_social_accounts' => 5,
                'max_posts_per_month' => 50,
                'max_team_members' => 1,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'Ideal for growing businesses and marketing professionals.',
                'price' => 79.00,
                'currency' => 'USD',
                'billing_interval' => 'monthly',
                'trial_days' => 14,
                'features' => json_encode([
                    '15 Social Media Accounts',
                    '200 Scheduled Posts/month',
                    'Advanced Analytics',
                    'Ad Campaign Management',
                    'Priority Support',
                    'Team Collaboration (3 members)',
                ]),
                'max_social_accounts' => 15,
                'max_posts_per_month' => 200,
                'max_team_members' => 3,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Business',
                'slug' => 'business',
                'description' => 'For agencies and large businesses with advanced needs.',
                'price' => 199.00,
                'currency' => 'USD',
                'billing_interval' => 'monthly',
                'trial_days' => 14,
                'features' => json_encode([
                    'Unlimited Social Media Accounts',
                    'Unlimited Scheduled Posts',
                    'Custom Analytics & Reports',
                    'Advanced Ad Campaign Management',
                    'Dedicated Account Manager',
                    'API Access',
                    'Team Collaboration (10 members)',
                    'White-label Options',
                ]),
                'max_social_accounts' => 100,
                'max_posts_per_month' => 10000,
                'max_team_members' => 10,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'Custom solutions for large enterprises with specific requirements.',
                'price' => 499.00,
                'currency' => 'USD',
                'billing_interval' => 'monthly',
                'trial_days' => 30,
                'features' => json_encode([
                    'Everything in Business',
                    'Custom Integrations',
                    'SLA Guarantee',
                    'Dedicated Infrastructure',
                    'Custom Training',
                    'Unlimited Team Members',
                ]),
                'max_social_accounts' => 1000,
                'max_posts_per_month' => 100000,
                'max_team_members' => 100,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($plans as $plan) {
            DB::table('subscription_plans')->insert($plan);
        }
    }
}
