<?php

namespace App\Services;

use App\Models\AdminFeatureFlag;
use Illuminate\Support\Facades\Cache;

class FeatureFlagService
{
    private const CACHE_KEY = 'feature_flags';
    private const CACHE_TTL = 3600;

    public static function isEnabled(string $featureKey): bool
    {
        $flags = self::getAllFlags();
        return $flags[$featureKey]['enabled'] ?? false;
    }

    public static function toggle(string $featureKey, bool $enabled, ?int $updatedBy = null): bool
    {
        $flag = AdminFeatureFlag::where('feature_key', $featureKey)->first();
        
        if (!$flag || $flag->force_enabled) {
            return false;
        }

        $flag->update([
            'enabled' => $enabled,
            'updated_by' => $updatedBy,
        ]);

        self::clearCache();
        return true;
    }

    public static function canToggle(string $featureKey): bool
    {
        $flag = AdminFeatureFlag::where('feature_key', $featureKey)->first();
        return $flag && !$flag->force_enabled;
    }

    public static function getAllFlags(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return AdminFeatureFlag::all()->keyBy('feature_key')->toArray();
        });
    }

    public static function getAllByCategory(): array
    {
        return AdminFeatureFlag::all()->groupBy('category')->toArray();
    }

    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    public static function seedDefaultFlags(): void
    {
        $defaultFlags = [
            ['feature_key' => 'posts_management', 'feature_name' => 'Posts Management', 'category' => 'core', 'enabled' => true, 'force_enabled' => false, 'description' => 'Enable/disable posts management feature'],
            ['feature_key' => 'analytics_insights', 'feature_name' => 'Analytics & Insights', 'category' => 'core', 'enabled' => true, 'force_enabled' => false, 'description' => 'Enable/disable analytics dashboard'],
            ['feature_key' => 'inbox_messaging', 'feature_name' => 'Inbox & Messaging', 'category' => 'core', 'enabled' => true, 'force_enabled' => false, 'description' => 'Enable/disable inbox messaging feature'],
            ['feature_key' => 'advertising_campaigns', 'feature_name' => 'Advertising Campaigns', 'category' => 'core', 'enabled' => true, 'force_enabled' => false, 'description' => 'Enable/disable ad campaigns feature'],
            ['feature_key' => 'comment_management', 'feature_name' => 'Comment Management', 'category' => 'core', 'enabled' => true, 'force_enabled' => false, 'description' => 'Enable/disable comment management'],
            
            ['feature_key' => 'user_management', 'feature_name' => 'User Management', 'category' => 'admin', 'enabled' => true, 'force_enabled' => true, 'description' => 'User management (cannot be disabled)'],
            ['feature_key' => 'subscription_management', 'feature_name' => 'Subscription Management', 'category' => 'admin', 'enabled' => true, 'force_enabled' => false, 'description' => 'Enable/disable subscription management'],
            ['feature_key' => 'system_settings', 'feature_name' => 'System Settings', 'category' => 'admin', 'enabled' => true, 'force_enabled' => true, 'description' => 'System settings (cannot be disabled)'],
            ['feature_key' => 'activity_logging', 'feature_name' => 'Activity Logging', 'category' => 'admin', 'enabled' => true, 'force_enabled' => false, 'description' => 'Enable/disable activity logging'],
            ['feature_key' => 'user_impersonation', 'feature_name' => 'User Impersonation', 'category' => 'admin', 'enabled' => false, 'force_enabled' => false, 'description' => 'Allow admins to login as users'],
            
            ['feature_key' => 'two_factor_auth', 'feature_name' => 'Two-Factor Authentication', 'category' => 'security', 'enabled' => true, 'force_enabled' => false, 'description' => 'Enable 2FA for admin accounts'],
            ['feature_key' => 'ip_whitelisting', 'feature_name' => 'IP Whitelisting', 'category' => 'security', 'enabled' => false, 'force_enabled' => false, 'description' => 'Restrict admin access by IP'],
            ['feature_key' => 'session_management', 'feature_name' => 'Session Management', 'category' => 'security', 'enabled' => true, 'force_enabled' => false, 'description' => 'View and manage admin sessions'],
            ['feature_key' => 'audit_logging', 'feature_name' => 'Audit Logging', 'category' => 'security', 'enabled' => true, 'force_enabled' => false, 'description' => 'Log all admin actions'],
            
            ['feature_key' => 'system_health_monitoring', 'feature_name' => 'System Health Monitoring', 'category' => 'monitoring', 'enabled' => true, 'force_enabled' => false, 'description' => 'Monitor system health metrics'],
            ['feature_key' => 'error_tracking', 'feature_name' => 'Error Tracking', 'category' => 'monitoring', 'enabled' => true, 'force_enabled' => false, 'description' => 'Track and log application errors'],
            ['feature_key' => 'alert_notifications', 'feature_name' => 'Alert Notifications', 'category' => 'monitoring', 'enabled' => true, 'force_enabled' => false, 'description' => 'Enable alert notifications'],
            ['feature_key' => 'performance_monitoring', 'feature_name' => 'Performance Monitoring', 'category' => 'monitoring', 'enabled' => false, 'force_enabled' => false, 'description' => 'Monitor performance metrics'],
            
            ['feature_key' => 'bulk_export', 'feature_name' => 'Bulk Export', 'category' => 'data', 'enabled' => true, 'force_enabled' => false, 'description' => 'Enable bulk data export'],
            ['feature_key' => 'scheduled_exports', 'feature_name' => 'Scheduled Exports', 'category' => 'data', 'enabled' => false, 'force_enabled' => false, 'description' => 'Enable scheduled report exports'],
            ['feature_key' => 'report_generation', 'feature_name' => 'Report Generation', 'category' => 'data', 'enabled' => true, 'force_enabled' => false, 'description' => 'Enable custom report generation'],
            ['feature_key' => 'analytics_export', 'feature_name' => 'Analytics Export', 'category' => 'data', 'enabled' => true, 'force_enabled' => false, 'description' => 'Enable analytics data export'],
        ];

        foreach ($defaultFlags as $flag) {
            AdminFeatureFlag::updateOrCreate(
                ['feature_key' => $flag['feature_key']],
                $flag
            );
        }

        self::clearCache();
    }
}
