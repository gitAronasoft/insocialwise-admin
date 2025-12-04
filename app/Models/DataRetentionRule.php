<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataRetentionRule extends Model
{
    protected $table = 'data_retention_rules';

    protected $fillable = [
        'data_type',
        'retention_days',
        'auto_delete',
        'last_cleanup_at',
        'active',
    ];

    protected $casts = [
        'auto_delete' => 'boolean',
        'active' => 'boolean',
        'last_cleanup_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function getActiveRules()
    {
        return static::where('active', true)->get();
    }

    public function getDataTypeLabelAttribute(): string
    {
        return match ($this->data_type) {
            'activity_logs' => 'Activity Logs',
            'error_logs' => 'Error Logs',
            'webhook_logs' => 'Webhook Logs',
            'session_data' => 'Session Data',
            'analytics_cache' => 'Analytics Cache',
            default => ucfirst(str_replace('_', ' ', $this->data_type)),
        };
    }

    public function getRetentionPeriodAttribute(): string
    {
        if ($this->retention_days >= 365) {
            $years = floor($this->retention_days / 365);
            return $years . ' year' . ($years > 1 ? 's' : '');
        } elseif ($this->retention_days >= 30) {
            $months = floor($this->retention_days / 30);
            return $months . ' month' . ($months > 1 ? 's' : '');
        } else {
            return $this->retention_days . ' day' . ($this->retention_days > 1 ? 's' : '');
        }
    }
}
