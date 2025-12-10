<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminSession extends Model
{
    protected $fillable = [
        'admin_user_id',
        'session_token',
        'ip_address',
        'user_agent',
        'last_activity',
        'expires_at',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'last_activity' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(AdminUser::class, 'admin_user_id');
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->is_active) {
            true => ['label' => 'Active', 'color' => 'green'],
            false => ['label' => 'Inactive', 'color' => 'gray'],
            default => ['label' => 'Unknown', 'color' => 'gray'],
        };
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForAdmin($query, int $adminId)
    {
        return $query->where('admin_user_id', $adminId);
    }

    public function revoke(): void
    {
        $this->update([
            'is_active' => false,
        ]);
    }

    public function markAsExpired(): void
    {
        $this->update([
            'is_active' => false,
        ]);
    }

    public function touch($attribute = null)
    {
        $this->last_activity_at = now();
        return parent::touch($attribute);
    }

    public static function parseUserAgent(?string $userAgent): array
    {
        if (!$userAgent) {
            return [
                'device_type' => 'unknown',
                'browser' => 'Unknown',
                'os' => 'Unknown',
            ];
        }

        $browser = 'Unknown';
        $os = 'Unknown';
        $device = 'desktop';

        if (preg_match('/Firefox/i', $userAgent)) $browser = 'Firefox';
        elseif (preg_match('/Edg/i', $userAgent)) $browser = 'Edge';
        elseif (preg_match('/Chrome/i', $userAgent)) $browser = 'Chrome';
        elseif (preg_match('/Safari/i', $userAgent)) $browser = 'Safari';
        elseif (preg_match('/Opera|OPR/i', $userAgent)) $browser = 'Opera';

        if (preg_match('/Windows/i', $userAgent)) $os = 'Windows';
        elseif (preg_match('/Mac/i', $userAgent)) $os = 'macOS';
        elseif (preg_match('/Linux/i', $userAgent)) $os = 'Linux';
        elseif (preg_match('/Android/i', $userAgent)) { $os = 'Android'; $device = 'mobile'; }
        elseif (preg_match('/iPhone|iPad/i', $userAgent)) { $os = 'iOS'; $device = 'mobile'; }

        if (preg_match('/Mobile/i', $userAgent)) $device = 'mobile';
        elseif (preg_match('/Tablet/i', $userAgent)) $device = 'tablet';

        return [
            'device_type' => $device,
            'browser' => $browser,
            'os' => $os,
        ];
    }
}
