<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'view_dashboard', 'guard_name' => 'admin', 'description' => 'View dashboard'],
            ['name' => 'manage_users', 'guard_name' => 'admin', 'description' => 'Manage users'],
            ['name' => 'manage_subscriptions', 'guard_name' => 'admin', 'description' => 'Manage subscriptions'],
            ['name' => 'manage_billing', 'guard_name' => 'admin', 'description' => 'Manage billing'],
            ['name' => 'manage_content', 'guard_name' => 'admin', 'description' => 'Manage content'],
            ['name' => 'manage_campaigns', 'guard_name' => 'admin', 'description' => 'Manage ad campaigns'],
            ['name' => 'manage_analytics', 'guard_name' => 'admin', 'description' => 'View and manage analytics'],
            ['name' => 'manage_settings', 'guard_name' => 'admin', 'description' => 'Manage system settings'],
            ['name' => 'manage_admins', 'guard_name' => 'admin', 'description' => 'Manage admin users'],
            ['name' => 'view_audit_logs', 'guard_name' => 'admin', 'description' => 'View audit logs'],
            ['name' => 'manage_webhooks', 'guard_name' => 'admin', 'description' => 'Manage webhooks'],
            ['name' => 'manage_knowledge_base', 'guard_name' => 'admin', 'description' => 'Manage knowledge base'],
            ['name' => 'manage_compliance', 'guard_name' => 'admin', 'description' => 'Manage compliance policies'],
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert(array_merge($permission, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        $roles = [
            ['name' => 'super_admin', 'guard_name' => 'admin', 'description' => 'Super Administrator with full access'],
            ['name' => 'admin', 'guard_name' => 'admin', 'description' => 'Administrator with limited access'],
            ['name' => 'moderator', 'guard_name' => 'admin', 'description' => 'Content moderator'],
            ['name' => 'support', 'guard_name' => 'admin', 'description' => 'Customer support agent'],
            ['name' => 'analyst', 'guard_name' => 'admin', 'description' => 'Analytics viewer'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert(array_merge($role, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        $allPermissions = DB::table('permissions')->pluck('id');
        $superAdminRoleId = DB::table('roles')->where('name', 'super_admin')->value('id');
        foreach ($allPermissions as $permissionId) {
            DB::table('role_has_permissions')->insert([
                'permission_id' => $permissionId,
                'role_id' => $superAdminRoleId,
            ]);
        }

        $adminRoleId = DB::table('roles')->where('name', 'admin')->value('id');
        $adminPermissions = DB::table('permissions')
            ->whereIn('name', ['view_dashboard', 'manage_users', 'manage_subscriptions', 'manage_billing', 'manage_content', 'manage_campaigns', 'manage_analytics'])
            ->pluck('id');
        foreach ($adminPermissions as $permissionId) {
            DB::table('role_has_permissions')->insert([
                'permission_id' => $permissionId,
                'role_id' => $adminRoleId,
            ]);
        }

        $adminUsers = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@insocialwise.com',
                'password' => Hash::make('password'),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@insocialwise.com',
                'password' => Hash::make('password'),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($adminUsers as $index => $admin) {
            $adminId = DB::table('admin_users')->insertGetId($admin);
            
            DB::table('model_has_roles')->insert([
                'role_id' => $index === 0 ? $superAdminRoleId : $adminRoleId,
                'model_type' => 'App\\Models\\AdminUser',
                'model_id' => $adminId,
            ]);

            DB::table('admin_user_role')->insert([
                'admin_user_id' => $adminId,
                'role_id' => $index === 0 ? $superAdminRoleId : $adminRoleId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $settings = [
            ['key' => 'site_name', 'value' => 'InSocialWise', 'type' => 'string', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Social Media Marketing Platform', 'type' => 'string', 'group' => 'general'],
            ['key' => 'support_email', 'value' => 'support@insocialwise.com', 'type' => 'string', 'group' => 'general'],
            ['key' => 'maintenance_mode', 'value' => 'false', 'type' => 'boolean', 'group' => 'system'],
            ['key' => 'allow_registration', 'value' => 'true', 'type' => 'boolean', 'group' => 'system'],
            ['key' => 'default_timezone', 'value' => 'UTC', 'type' => 'string', 'group' => 'general'],
            ['key' => 'default_language', 'value' => 'en', 'type' => 'string', 'group' => 'general'],
        ];

        foreach ($settings as $setting) {
            DB::table('admin_settings')->insert(array_merge($setting, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        $featureFlags = [
            ['name' => 'enable_ai_features', 'is_enabled' => true, 'description' => 'Enable AI-powered features'],
            ['name' => 'enable_analytics', 'is_enabled' => true, 'description' => 'Enable analytics dashboard'],
            ['name' => 'enable_advertising', 'is_enabled' => true, 'description' => 'Enable advertising management'],
            ['name' => 'enable_team_collaboration', 'is_enabled' => false, 'description' => 'Enable team collaboration features'],
        ];

        foreach ($featureFlags as $flag) {
            DB::table('admin_feature_flags')->insert(array_merge($flag, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
