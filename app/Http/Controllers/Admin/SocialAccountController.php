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
            $query->where('platform', $request->platform);
        }

        if ($request->has('status') && $request->status !== 'all') {
            switch ($request->status) {
                case 'active':
                    $query->where('status', 'active')
                        ->where(function ($q) {
                            $q->whereNull('token_expires_at')
                                ->orWhere('token_expires_at', '>', now());
                        });
                    break;
                case 'expiring':
                    $query->where('token_expires_at', '>', now())
                        ->where('token_expires_at', '<', now()->addDays(7));
                    break;
                case 'expired':
                    $query->where('token_expires_at', '<', now());
                    break;
                case 'disconnected':
                    $query->where('status', 'disconnected');
                    break;
            }
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
            'active' => SocialUser::where('status', 'active')
                ->where(function ($q) {
                    $q->whereNull('token_expires_at')
                        ->orWhere('token_expires_at', '>', now());
                })->count(),
            'expiring_soon' => SocialUser::where('token_expires_at', '>', now())
                ->where('token_expires_at', '<', now()->addDays(7))->count(),
            'expired' => SocialUser::where('token_expires_at', '<', now())->count(),
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
        $status = 'active';
        $message = 'Token is valid';
        $color = 'green';

        if ($socialAccount->status === 'disconnected') {
            $status = 'disconnected';
            $message = 'Account is disconnected';
            $color = 'gray';
        } elseif ($socialAccount->access_token_expiry) {
            $expiry = Carbon::parse($socialAccount->access_token_expiry);
            
            if ($expiry->isPast()) {
                $status = 'expired';
                $message = 'Token expired ' . $expiry->diffForHumans();
                $color = 'red';
            } elseif ($expiry->diffInDays(now()) < 7) {
                $status = 'expiring';
                $message = 'Token expires ' . $expiry->diffForHumans();
                $color = 'yellow';
            }
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'color' => $color,
            'expiry' => $socialAccount->access_token_expiry,
        ]);
    }
}
