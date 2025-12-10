<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComplianceSeeder extends Seeder
{
    public function run(): void
    {
        $policies = [
            [
                'name' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '<h1>Privacy Policy</h1><p>Last updated: ' . now()->format('F d, Y') . '</p><p>This Privacy Policy describes how InSocialWise ("we", "us", or "our") collects, uses, and shares information about you when you use our services.</p><h2>Information We Collect</h2><p>We collect information you provide directly to us, such as when you create an account, connect social media accounts, or contact us for support.</p><h2>How We Use Your Information</h2><p>We use the information we collect to provide, maintain, and improve our services, and to communicate with you.</p><h2>Information Sharing</h2><p>We do not sell your personal information. We may share your information with third-party service providers who perform services on our behalf.</p>',
                'version' => '1.0',
                'is_active' => true,
                'requires_acceptance' => true,
                'effective_date' => now(),
            ],
            [
                'name' => 'Terms of Service',
                'slug' => 'terms-of-service',
                'content' => '<h1>Terms of Service</h1><p>Last updated: ' . now()->format('F d, Y') . '</p><p>By accessing or using InSocialWise, you agree to be bound by these Terms of Service.</p><h2>Use of Service</h2><p>You must be at least 18 years old to use our service. You are responsible for maintaining the security of your account.</p><h2>Acceptable Use</h2><p>You agree not to use the service for any unlawful purpose or in any way that could damage, disable, or impair the service.</p><h2>Termination</h2><p>We may terminate or suspend your account at any time for violations of these terms.</p>',
                'version' => '1.0',
                'is_active' => true,
                'requires_acceptance' => true,
                'effective_date' => now(),
            ],
            [
                'name' => 'Cookie Policy',
                'slug' => 'cookie-policy',
                'content' => '<h1>Cookie Policy</h1><p>This Cookie Policy explains how InSocialWise uses cookies and similar technologies.</p><h2>What Are Cookies</h2><p>Cookies are small text files stored on your device when you visit our website.</p><h2>Types of Cookies We Use</h2><ul><li><strong>Essential Cookies</strong>: Required for the operation of our service.</li><li><strong>Analytics Cookies</strong>: Help us understand how you use our service.</li><li><strong>Preference Cookies</strong>: Remember your settings and preferences.</li></ul>',
                'version' => '1.0',
                'is_active' => true,
                'requires_acceptance' => false,
                'effective_date' => now(),
            ],
        ];

        foreach ($policies as $policy) {
            DB::table('compliance_policies')->insert(array_merge($policy, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        $retentionRules = [
            [
                'name' => 'User Activity Logs',
                'data_type' => 'activity_logs',
                'retention_days' => 365,
                'description' => 'User activity logs are retained for 1 year',
                'is_active' => true,
            ],
            [
                'name' => 'Analytics Data',
                'data_type' => 'analytics',
                'retention_days' => 730,
                'description' => 'Analytics data is retained for 2 years',
                'is_active' => true,
            ],
            [
                'name' => 'Deleted User Data',
                'data_type' => 'deleted_users',
                'retention_days' => 30,
                'description' => 'Deleted user data is purged after 30 days',
                'is_active' => true,
            ],
            [
                'name' => 'Session Data',
                'data_type' => 'sessions',
                'retention_days' => 7,
                'description' => 'Session data is retained for 7 days',
                'is_active' => true,
            ],
        ];

        foreach ($retentionRules as $rule) {
            DB::table('data_retention_rules')->insert(array_merge($rule, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
