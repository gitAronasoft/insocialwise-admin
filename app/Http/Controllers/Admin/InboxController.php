<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InboxConversation;
use App\Models\InboxMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InboxController extends Controller
{
    public function index(Request $request)
    {
        $query = InboxConversation::with(['customer', 'page']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('external_username', 'like', "%{$search}%")
                    ->orWhere('snippet', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('firstName', 'like', "%{$search}%")
                            ->orWhere('lastName', 'like', "%{$search}%");
                    });
            });
        }

        $conversations = $query->orderBy('updated_at', 'desc')->paginate(20);

        $stats = [
            'total' => InboxConversation::count(),
            'with_unread' => InboxConversation::where('status', 'Active')->count(),
            'total_messages' => InboxMessage::count(),
            'messages_today' => InboxMessage::whereDate('created_at', today())->count(),
        ];

        return view('admin.inbox.index', compact('conversations', 'stats'));
    }

    public function show(InboxConversation $conversation)
    {
        $conversation->load(['customer', 'page']);

        $messages = $conversation->messages()
            ->orderBy('timestamp', 'asc')
            ->paginate(50);

        return view('admin.inbox.show', compact('conversation', 'messages'));
    }

    public function messages(Request $request)
    {
        $query = InboxMessage::with('conversation.customer');

        if ($request->filled('sender_type')) {
            $query->where('sender_type', $request->sender_type);
        }

        if ($request->filled('search')) {
            $query->where('message_text', 'like', "%{$request->search}%");
        }

        $messages = $query->orderBy('timestamp', 'desc')->paginate(30);

        return view('admin.inbox.messages', compact('messages'));
    }

    public function stats()
    {
        $hourlyMessages = InboxMessage::where('timestamp', '>=', now()->subDay())
            ->select(
                DB::raw('HOUR(timestamp) as hour'),
                DB::raw('count(*) as count')
            )
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        $avgResponseTime = 0;

        $messagesByType = InboxMessage::select('sender_type', DB::raw('count(*) as count'))
            ->groupBy('sender_type')
            ->get();

        return view('admin.inbox.stats', compact('hourlyMessages', 'avgResponseTime', 'messagesByType'));
    }
}
