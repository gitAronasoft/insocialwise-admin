<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminAuditLog;
use App\Models\AdminSession;
use App\Models\AdminUser;
use App\Services\AdminAuditService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AdminAuditLog::with('admin');

        if ($request->filled('admin_id')) {
            $query->where('admin_id', $request->admin_id);
        }

        if ($request->filled('action_type')) {
            $query->where('action_type', $request->action_type);
        }

        if ($request->filled('severity')) {
            $query->where('severity', $request->severity);
        }

        if ($request->filled('ip_address')) {
            $query->where('ip_address', 'like', "%{$request->ip_address}%");
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('admin_email', 'like', "%{$search}%")
                    ->orWhere('admin_name', 'like', "%{$search}%")
                    ->orWhere('entity_type', 'like', "%{$search}%")
                    ->orWhere('entity_id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(30);

        $actionTypes = AdminAuditLog::select('action_type')
            ->distinct()
            ->pluck('action_type');

        $admins = AdminUser::select('id', 'name', 'email')->get();

        $stats = $this->getAuditStats();

        return view('admin.audit-logs.index', compact('logs', 'actionTypes', 'admins', 'stats'));
    }

    public function show(AdminAuditLog $auditLog)
    {
        $auditLog->load('admin');
        
        $relatedLogs = AdminAuditLog::where('id', '!=', $auditLog->id)
            ->where(function ($query) use ($auditLog) {
                $query->where('session_id', $auditLog->session_id)
                    ->orWhere(function ($q) use ($auditLog) {
                        $q->where('entity_type', $auditLog->entity_type)
                            ->where('entity_id', $auditLog->entity_id);
                    });
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.audit-logs.show', compact('auditLog', 'relatedLogs'));
    }

    public function sessions(Request $request)
    {
        $query = AdminSession::with('admin');

        if ($request->filled('admin_id')) {
            $query->where('admin_id', $request->admin_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('ip_address')) {
            $query->where('ip_address', 'like', "%{$request->ip_address}%");
        }

        $sessions = $query->orderBy('last_activity_at', 'desc')->paginate(30);

        $admins = AdminUser::select('id', 'name', 'email')->get();

        $stats = [
            'total_active' => AdminSession::where('status', 'active')->count(),
            'total_today' => AdminSession::whereDate('logged_in_at', today())->count(),
            'unique_ips' => AdminSession::where('status', 'active')->distinct('ip_address')->count('ip_address'),
            'revoked_count' => AdminSession::where('status', 'revoked')->count(),
        ];

        return view('admin.audit-logs.sessions', compact('sessions', 'admins', 'stats'));
    }

    public function mySessions()
    {
        $admin = Auth::guard('admin')->user();
        $currentToken = session()->getId();
        
        $sessions = AdminSession::where('admin_id', $admin->id)
            ->orderBy('last_activity_at', 'desc')
            ->get()
            ->map(function ($session) use ($currentToken) {
                $session->is_current = $session->session_token === $currentToken;
                return $session;
            });

        return view('admin.audit-logs.my-sessions', compact('sessions'));
    }

    public function revokeSession(AdminSession $session): JsonResponse
    {
        $currentAdmin = Auth::guard('admin')->user();
        
        if ($session->session_token === session()->getId()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot revoke your current session.',
            ], 400);
        }

        if ($session->admin_id !== $currentAdmin->id && !$currentAdmin->isSuperAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to revoke this session.',
            ], 403);
        }

        AdminAuditService::revokeSession($session->id);

        return response()->json([
            'success' => true,
            'message' => 'Session revoked successfully.',
        ]);
    }

    public function revokeAllOtherSessions(): JsonResponse
    {
        $admin = Auth::guard('admin')->user();
        $count = AdminAuditService::revokeAllOtherSessions($admin->id);

        return response()->json([
            'success' => true,
            'message' => $count > 0 
                ? "Revoked {$count} other session(s) successfully."
                : 'No other active sessions to revoke.',
            'revoked_count' => $count,
        ]);
    }

    public function securityOverview()
    {
        $loginAttempts = AdminAuditService::getLoginAttempts(7);
        $securityAlerts = AdminAuditService::getSecurityAlerts(7);
        
        $suspiciousActivity = AdminAuditLog::where('severity', '!=', 'info')
            ->where('created_at', '>=', now()->subDays(7))
            ->select('ip_address', DB::raw('count(*) as count'))
            ->groupBy('ip_address')
            ->having('count', '>', 5)
            ->orderBy('count', 'desc')
            ->get();

        $recentLogins = AdminAuditLog::whereIn('action_type', ['login', 'login_failed'])
            ->where('created_at', '>=', now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        $loginsByDay = AdminAuditLog::where('action_type', 'login')
            ->where('created_at', '>=', now()->subDays(7))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $failedLoginsByDay = AdminAuditLog::where('action_type', 'login_failed')
            ->where('created_at', '>=', now()->subDays(7))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.audit-logs.security', compact(
            'loginAttempts',
            'securityAlerts',
            'suspiciousActivity',
            'recentLogins',
            'loginsByDay',
            'failedLoginsByDay'
        ));
    }

    private function getAuditStats(): array
    {
        return [
            'total_today' => AdminAuditLog::whereDate('created_at', today())->count(),
            'total_week' => AdminAuditLog::where('created_at', '>=', now()->subDays(7))->count(),
            'warnings' => AdminAuditLog::where('severity', 'warning')
                ->where('created_at', '>=', now()->subDays(7))->count(),
            'critical' => AdminAuditLog::where('severity', 'critical')
                ->where('created_at', '>=', now()->subDays(7))->count(),
            'unique_admins_today' => AdminAuditLog::whereDate('created_at', today())
                ->distinct('admin_id')->count('admin_id'),
        ];
    }
}
