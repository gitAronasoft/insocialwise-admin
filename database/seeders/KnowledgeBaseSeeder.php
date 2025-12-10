<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KnowledgeBaseSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Getting Started with InSocialWise',
                'slug' => 'getting-started',
                'content' => '<h2>Welcome to InSocialWise!</h2><p>This guide will help you get started with our social media marketing platform.</p><h3>Step 1: Connect Your Social Accounts</h3><p>Navigate to the Social Accounts section and click "Add Account" to connect your social media profiles.</p><h3>Step 2: Schedule Your First Post</h3><p>Go to the Content section and create your first post. You can schedule it for a specific time or publish immediately.</p><h3>Step 3: Monitor Analytics</h3><p>Visit the Analytics dashboard to track your social media performance.</p>',
                'category' => 'Getting Started',
                'tags' => json_encode(['beginner', 'tutorial', 'onboarding']),
                'status' => 'published',
                'order' => 1,
            ],
            [
                'title' => 'Connecting Social Media Accounts',
                'slug' => 'connecting-social-accounts',
                'content' => '<h2>How to Connect Your Social Accounts</h2><p>InSocialWise supports multiple social media platforms including Facebook, Instagram, Twitter, LinkedIn, and more.</p><h3>Facebook & Instagram</h3><p>Click "Connect Facebook" and authorize InSocialWise to access your pages.</p><h3>Twitter</h3><p>Click "Connect Twitter" and log in with your Twitter credentials.</p><h3>LinkedIn</h3><p>Click "Connect LinkedIn" and authorize access to your company pages.</p>',
                'category' => 'Social Accounts',
                'tags' => json_encode(['social', 'connection', 'facebook', 'instagram', 'twitter']),
                'status' => 'published',
                'order' => 2,
            ],
            [
                'title' => 'Understanding Analytics',
                'slug' => 'understanding-analytics',
                'content' => '<h2>Analytics Overview</h2><p>Our analytics dashboard provides comprehensive insights into your social media performance.</p><h3>Key Metrics</h3><ul><li><strong>Engagement Rate</strong>: Measures how actively your audience interacts with your content.</li><li><strong>Reach</strong>: The number of unique users who saw your content.</li><li><strong>Impressions</strong>: Total number of times your content was displayed.</li></ul><h3>Reports</h3><p>Generate custom reports to share with your team or clients.</p>',
                'category' => 'Analytics',
                'tags' => json_encode(['analytics', 'metrics', 'reports']),
                'status' => 'published',
                'order' => 3,
            ],
            [
                'title' => 'Managing Subscriptions',
                'slug' => 'managing-subscriptions',
                'content' => '<h2>Subscription Management</h2><p>Learn how to upgrade, downgrade, or cancel your subscription.</p><h3>Upgrading Your Plan</h3><p>Go to Settings > Subscription and select a higher tier plan. Changes take effect immediately.</p><h3>Downgrading</h3><p>Downgrades are applied at the end of your current billing period.</p><h3>Cancellation</h3><p>You can cancel anytime. You\'ll retain access until your billing period ends.</p>',
                'category' => 'Billing',
                'tags' => json_encode(['billing', 'subscription', 'payment']),
                'status' => 'published',
                'order' => 4,
            ],
            [
                'title' => 'Ad Campaign Best Practices',
                'slug' => 'ad-campaign-best-practices',
                'content' => '<h2>Creating Effective Ad Campaigns</h2><p>Follow these best practices to maximize your advertising ROI.</p><h3>Define Clear Objectives</h3><p>Know what you want to achieve: brand awareness, traffic, or conversions.</p><h3>Target the Right Audience</h3><p>Use detailed targeting options to reach your ideal customers.</p><h3>Test and Optimize</h3><p>A/B test your creatives and continuously optimize based on performance data.</p>',
                'category' => 'Advertising',
                'tags' => json_encode(['ads', 'campaigns', 'marketing', 'optimization']),
                'status' => 'published',
                'order' => 5,
            ],
        ];

        $adminUserId = DB::table('admin_users')->first()->id ?? null;

        foreach ($articles as $article) {
            DB::table('knowledge_base')->insert(array_merge($article, [
                'views' => rand(10, 500),
                'helpful_count' => rand(5, 50),
                'not_helpful_count' => rand(0, 10),
                'created_by' => $adminUserId,
                'updated_by' => $adminUserId,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
