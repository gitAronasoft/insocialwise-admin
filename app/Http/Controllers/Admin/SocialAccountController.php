<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialUser;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SocialAccountController extends Controller
{
    public function index(Request $request)
    {
        $query = SocialUser::with(['customer', 'pages']);

        if ($request->has('platform') && $request->platform !== 'all') {
            $query->where('social_user_platform', $request->platform);
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status === 'active' ? 'Connected' : 'notConnected');
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $accounts = $query->orderBy('created_at', 'desc')->paginate(20);

        $stats = [
            'total' => SocialUser::count(),
            'connected' => SocialUser::where('status', 'Connected')->count(),
            'disconnected' => SocialUser::where('status', 'notConnected')->count(),
        ];

        return view('admin.social-accounts.index', compact('accounts', 'stats'));
    }

    public function show(SocialUser $socialAccount)
    {
        $socialAccount->load(['customer', 'pages']);
        return view('admin.social-accounts.show', compact('socialAccount'));
    }

    public function getHealthStatus(SocialUser $socialAccount)
    {
        if ($socialAccount->status === 'notConnected') {
            $status = 'disconnected';
            $message = 'Account is disconnected';
            $color = 'gray';
        } else {
            $status = 'connected';
            $message = 'Account is active';
            $color = 'green';
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'color' => $color,
        ]);
    }
}
