<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminAuditLog extends Model
{
    protected $fillable = [
        'admin_id',
        'admin_email',
        'admin_name',
        'action_type',
        'entity_type',
        'entity_id',
        'description',
        'old_values',
        'new_values',
        'metadata',
        'ip_address',
        'user_agent',
        'request_method',
        'request_url',
        'session_id',
        'severity',
    ];

    protected function casts(): array
    {
        return [
            'old_values' => 'array',
            'new_values' => 'array',
            'metadata' => 'array',
        ];
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(AdminUser::class, 'admin_id');
    }

    public function getActionLabelAttribute(): string
    {
        $labels = [
            'login' => 'Logged In',
            'logout' => 'Logged Out',
            'login_failed' => 'Login Failed',
            'password_changed' => 'Password Changed',
            'profile_updated' => 'Profile Updated',
            'customer_created' => 'Customer Created',
            'customer_updated' => 'Customer Updated',
            'customer_deleted' => 'Customer Deleted',
            'customer_status_changed' => 'Customer Status Changed',
            'subscription_created' => 'Subscription Created',
            'subscription_updated' => 'Subscription Updated',
            'subscription_canceled' => 'Subscription Canceled',
            'plan_created' => 'Plan Created',
            'plan_updated' => 'Plan Updated',
            'plan_deleted' => 'Plan Deleted',
            'setting_created' => 'Setting Created',
            'setting_updated' => 'Setting Updated',
            'setting_deleted' => 'Setting Deleted',
            'admin_created' => 'Admin Created',
            'admin_updated' => 'Admin Updated',
            'admin_deleted' => 'Admin Deleted',
            'role_assigned' => 'Role Assigned',
            'role_removed' => 'Role Removed',
            'webhook_created' => 'Webhook Created',
            'webhook_updated' => 'Webhook Updated',
            'webhook_deleted' => 'Webhook Deleted',
            'webhook_tested' => 'Webhook Tested',
            'policy_created' => 'Policy Created',
            'policy_updated' => 'Policy Updated',
            'data_request_handled' => 'Data Request Handled',
            'feature_flag_toggled' => 'Feature Flag Toggled',
            'knowledge_base_created' => 'Article Created',
            'knowledge_base_updated' => 'Article Updated',
            'knowledge_base_deleted' => 'Article Deleted',
            'bulk_action' => 'Bulk Action',
            'export_data' => 'Data Exported',
            'api_key_updated' => 'API Key Updated',
            'api_key_tested' => 'API Key Tested',
            'other' => 'Other Action',
        ];

        return $labels[$this->action_type] ?? ucfirst(str_replace('_', ' ', $this->action_type));
    }

    public function getActionIconAttribute(): string
    {
        $icons = [
            'login' => 'login',
            'logout' => 'logout',
            'login_failed' => 'x-circle',
            'password_changed' => 'key',
            'profile_updated' => 'user',
            'customer_created' => 'user-plus',
            'customer_updated' => 'user',
            'customer_deleted' => 'user-minus',
            'customer_status_changed' => 'toggle-right',
            'subscription_created' => 'credit-card',
            'subscription_updated' => 'credit-card',
            'subscription_canceled' => 'x-circle',
            'plan_created' => 'plus-circle',
            'plan_updated' => 'edit',
            'plan_deleted' => 'trash',
            'setting_created' => 'settings',
            'setting_updated' => 'settings',
            'setting_deleted' => 'settings',
            'admin_created' => 'user-plus',
            'admin_updated' => 'user',
            'admin_deleted' => 'user-minus',
            'webhook_created' => 'link',
            'webhook_updated' => 'link',
            'webhook_deleted' => 'unlink',
            'webhook_tested' => 'activity',
            'feature_flag_toggled' => 'toggle-right',
            'bulk_action' => 'layers',
            'export_data' => 'download',
            'api_key_updated' => 'key',
            'other' => 'activity',
        ];

        return $icons[$this->action_type] ?? 'activity';
    }

    public function getSeverityColorAttribute(): string
    {
        return match ($this->severity) {
            'critical' => 'red',
            'warning' => 'yellow',
            default => 'gray',
        };
    }

    public function scopeByAdmin($query, int $adminId)
    {
        return $query->where('admin_id', $adminId);
    }

    public function scopeByActionType($query, string $type)
    {
        return $query->where('action_type', $type);
    }

    public function scopeBySeverity($query, string $severity)
    {
        return $query->where('severity', $severity);
    }

    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeByIp($query, string $ip)
    {
        return $query->where('ip_address', $ip);
    }
}
