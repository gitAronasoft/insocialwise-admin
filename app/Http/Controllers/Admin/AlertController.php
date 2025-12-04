<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminAlert;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AlertController extends Controller
{
    public function index(Request $request)
    {
        $query = AdminAlert::query();

        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        if ($request->has('severity') && $request->severity !== 'all') {
            $query->where('severity', $request->severity);
        }

        if ($request->has('status')) {
            if ($request->status === 'unread') {
                $query->where('read', false);
            } elseif ($request->status === 'read') {
                $query->where('read', true);
            }
        }

        $alerts = $query->orderBy('created_at', 'desc')->paginate(20);

        $stats = [
            'total' => AdminAlert::count(),
            'unread' => AdminAlert::where('read', false)->count(),
            'critical' => AdminAlert::where('severity', 'critical')->where('read', false)->count(),
            'warning' => AdminAlert::where('severity', 'warning')->where('read', false)->count(),
        ];

        return view('admin.alerts.index', compact('alerts', 'stats'));
    }

    public function getUnread(): JsonResponse
    {
        $alerts = AdminAlert::getUnread(10);
        $count = AdminAlert::getUnreadCount();

        return response()->json([
            'success' => true,
            'count' => $count,
            'alerts' => $alerts->map(function ($alert) {
                return [
                    'id' => $alert->id,
                    'type' => $alert->type,
                    'severity' => $alert->severity,
                    'severity_color' => $alert->severity_color,
                    'type_icon' => $alert->type_icon,
                    'title' => $alert->title,
                    'message' => $alert->message,
                    'time' => $alert->created_at->diffForHumans(),
                ];
            }),
        ]);
    }

    public function markAsRead(AdminAlert $alert): JsonResponse
    {
        $alert->markAsRead(auth()->guard('admin')->id());

        return response()->json([
            'success' => true,
            'message' => 'Alert marked as read.',
        ]);
    }

    public function markAllAsRead(): JsonResponse
    {
        AdminAlert::where('read', false)->update([
            'read' => true,
            'read_at' => now(),
            'read_by' => auth()->guard('admin')->id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'All alerts marked as read.',
        ]);
    }

    public function destroy(AdminAlert $alert): JsonResponse
    {
        $alert->delete();

        return response()->json([
            'success' => true,
            'message' => 'Alert deleted.',
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'type' => 'required|in:payment_failed,critical_error,suspicious_login,subscription_cancelled,api_failure,system_warning,general',
            'severity' => 'required|in:critical,warning,info',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $alert = AdminAlert::createAlert(
            $request->type,
            $request->severity,
            $request->title,
            $request->message,
            $request->metadata ?? []
        );

        return response()->json([
            'success' => true,
            'message' => 'Alert created.',
            'alert' => $alert,
        ]);
    }
}
