<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminSession extends Model
{
    protected $fillable = [
        'admin_id',
        'session_token',
        'ip_address',
        'user_agent',
        'device_type',
        'browser',
        'os',
        'location',
        'is_current',
        'last_activity_at',
        'logged_in_at',
        'logged_out_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'is_current' => 'boolean',
            'last_activity_at' => 'datetime',
            'logged_in_at' => 'datetime',
            'logged_out_at' => 'datetime',
        ];
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(AdminUser::class, 'admin_id');
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'active' => ['label' => 'Active', 'color' => 'green'],
            'expired' => ['label' => 'Expired', 'color' => 'gray'],
            'revoked' => ['label' => 'Revoked', 'color' => 'red'],
            default => ['label' => ucfirst($this->status), 'color' => 'gray'],
        };
    }

    public function getDeviceInfoAttribute(): string
    {
        $parts = [];
        if ($this->browser) $parts[] = $this->browser;
        if ($this->os) $parts[] = $this->os;
        return implode(' on ', $parts) ?: 'Unknown Device';
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeForAdmin($query, int $adminId)
    {
        return $query->where('admin_id', $adminId);
    }

    public function revoke(): void
    {
        $this->update([
            'status' => 'revoked',
            'logged_out_at' => now(),
        ]);
    }

    public function markAsExpired(): void
    {
        $this->update([
            'status' => 'expired',
            'logged_out_at' => now(),
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
