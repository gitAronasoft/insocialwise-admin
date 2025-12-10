<?php

namespace App\Services;

use App\Models\AdminAuditLog;
use App\Models\AdminSession;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminAuditService
{
    public static function log(
        string $actionType,
        string $description,
        ?string $entityType = null,
        ?string $entityId = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        string $severity = 'info',
        ?array $metadata = null
    ): AdminAuditLog {
        $admin = Auth::guard('admin')->user();
        $request = request();

        return AdminAuditLog::create([
            'admin_id' => $admin?->id,
            'admin_email' => $admin?->email,
            'admin_name' => $admin?->name,
            'action_type' => $actionType,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => self::getClientIp($request),
            'user_agent' => $request->userAgent(),
            'request_method' => $request->method(),
            'request_url' => $request->url(),
            'session_id' => session()->getId(),
            'severity' => $severity,
            'metadata' => $metadata,
        ]);
    }

    public static function logLogin(AdminUser $admin, bool $success = true): AdminAuditLog
    {
        $request = request();
        
        return AdminAuditLog::create([
            'admin_id' => $admin->id,
            'admin_email' => $admin->email,
            'admin_name' => $admin->name,
            'action_type' => $success ? 'login' : 'login_failed',
            'description' => $success 
                ? "Admin {$admin->email} logged in successfully"
                : "Failed login attempt for {$admin->email}",
            'ip_address' => self::getClientIp($request),
            'user_agent' => $request->userAgent(),
            'request_method' => $request->method(),
            'request_url' => $request->url(),
            'session_id' => session()->getId(),
            'severity' => 'info',
        ]);
    }

    public static function logLogout(AdminUser $admin): AdminAuditLog
    {
        $request = request();

        return AdminAuditLog::create([
            'admin_id' => $admin->id,
            'admin_email' => $admin->email,
            'admin_name' => $admin->name,
            'action_type' => 'logout',
            'description' => "Admin {$admin->email} logged out",
            'ip_address' => self::getClientIp($request),
            'user_agent' => $request->userAgent(),
            'request_method' => $request->method(),
            'request_url' => $request->url(),
            'session_id' => session()->getId(),
            'severity' => 'info',
        ]);
    }

    public static function createSession(AdminUser $admin): AdminSession
    {
        $request = request();
        $userAgentInfo = AdminSession::parseUserAgent($request->userAgent());

        return AdminSession::create([
            'admin_id' => $admin->id,
            'session_token' => session()->getId(),
            'ip_address' => self::getClientIp($request),
            'user_agent' => $request->userAgent(),
            'device_type' => $userAgentInfo['device_type'],
            'browser' => $userAgentInfo['browser'],
            'os' => $userAgentInfo['os'],
            'is_current' => true,
            'last_activity_at' => now(),
            'logged_in_at' => now(),
            'status' => 'active',
        ]);
    }

    public static function endSession(?string $sessionToken = null): void
    {
        $token = $sessionToken ?? session()->getId();
        
        AdminSession::where('session_token', $token)
            ->where('status', 'active')
            ->update([
                'status' => 'expired',
                'logged_out_at' => now(),
            ]);
    }

    public static function updateSessionActivity(): void
    {
        $sessionToken = session()->getId();
        
        AdminSession::where('session_token', $sessionToken)
            ->where('status', 'active')
            ->update([
                'last_activity_at' => now(),
                'ip_address' => self::getClientIp(request()),
            ]);
    }

    public static function revokeSession(int $sessionId): bool
    {
        $session = AdminSession::find($sessionId);
        
        if ($session && $session->is_active) {
            $session->revoke();
            
            self::log(
                'other',
                "Session revoked for admin {$session->admin->email}",
                'AdminSession',
                (string) $sessionId,
                null,
                null,
                'warning'
            );
            
            return true;
        }
        
        return false;
    }

    public static function revokeAllOtherSessions(int $adminId): int
    {
        $currentToken = session()->getId();
        
        $count = AdminSession::where('admin_id', $adminId)
            ->where('session_token', '!=', $currentToken)
            ->where('status', 'active')
            ->update([
                'status' => 'revoked',
                'logged_out_at' => now(),
            ]);

        if ($count > 0) {
            self::log(
                'session_revoked',
                "Revoked {$count} other active sessions",
                'AdminSession',
                null,
                null,
                null,
                'warning',
                ['revoked_count' => $count]
            );
        }

        return $count;
    }

    public static function getActiveSessions(int $adminId): \Illuminate\Database\Eloquent\Collection
    {
        return AdminSession::where('admin_id', $adminId)
            ->where('status', 'active')
            ->orderBy('last_activity_at', 'desc')
            ->get();
    }

    public static function cleanupExpiredSessions(int $daysOld = 30): int
    {
        return AdminSession::where('status', 'active')
            ->where('last_activity_at', '<', now()->subDays($daysOld))
            ->update([
                'status' => 'expired',
                'logged_out_at' => now(),
            ]);
    }

    public static function getClientIp(?Request $request = null): ?string
    {
        $request = $request ?? request();
        
        $headers = [
            'HTTP_CF_CONNECTING_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_REAL_IP',
            'REMOTE_ADDR',
        ];

        foreach ($headers as $header) {
            $ip = $request->server($header);
            if ($ip) {
                $ip = explode(',', $ip)[0];
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }

        return $request->ip();
    }

    public static function getRecentActivity(int $limit = 50): \Illuminate\Database\Eloquent\Collection
    {
        return AdminAuditLog::with('admin')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public static function getActivityByAdmin(int $adminId, int $limit = 50): \Illuminate\Database\Eloquent\Collection
    {
        return AdminAuditLog::where('admin_user_id', $adminId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public static function getSecurityAlerts(int $days = 7): \Illuminate\Database\Eloquent\Collection
    {
        return AdminAuditLog::where('created_at', '>=', now()->subDays($days))
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public static function getLoginAttempts(int $days = 7): array
    {
        $logs = AdminAuditLog::whereIn('action_type', ['login', 'login_failed'])
            ->where('created_at', '>=', now()->subDays($days))
            ->get();

        return [
            'successful' => $logs->where('action_type', 'login')->count(),
            'failed' => $logs->where('action_type', 'login_failed')->count(),
            'unique_ips' => $logs->pluck('ip_address')->unique()->count(),
        ];
    }
}
