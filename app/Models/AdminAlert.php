<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminAlert extends Model
{
    protected $table = 'admin_alerts';

    protected $fillable = [
        'type',
        'severity',
        'title',
        'message',
        'metadata',
        'read',
        'read_at',
        'read_by',
    ];

    protected $casts = [
        'metadata' => 'array',
        'read' => 'boolean',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function getUnreadCount(): int
    {
        return static::where('read', false)->count();
    }

    public static function getRecent(int $limit = 10)
    {
        return static::orderBy('created_at', 'desc')->limit($limit)->get();
    }

    public static function getUnread(int $limit = 20)
    {
        return static::where('read', false)
            ->orderBy('severity', 'asc')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function markAsRead(?int $adminId = null): void
    {
        $this->update([
            'read' => true,
            'read_at' => now(),
            'read_by' => $adminId,
        ]);
    }

    public static function createAlert(string $type, string $severity, string $title, string $message, array $metadata = []): self
    {
        return static::create([
            'type' => $type,
            'severity' => $severity,
            'title' => $title,
            'message' => $message,
            'metadata' => $metadata,
        ]);
    }

    public function getSeverityColorAttribute(): string
    {
        return match ($this->severity) {
            'critical' => 'red',
            'warning' => 'yellow',
            'info' => 'blue',
            default => 'gray',
        };
    }

    public function getTypeIconAttribute(): string
    {
        return match ($this->type) {
            'payment_failed' => 'credit-card',
            'critical_error' => 'exclamation-triangle',
            'suspicious_login' => 'shield-exclamation',
            'subscription_cancelled' => 'user-minus',
            'api_failure' => 'server',
            'system_warning' => 'cog',
            default => 'bell',
        };
    }

    public function readByAdmin()
    {
        return $this->belongsTo(AdminUser::class, 'read_by');
    }
}
