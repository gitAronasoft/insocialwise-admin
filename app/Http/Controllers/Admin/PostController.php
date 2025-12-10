<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserPost;
use App\Models\PostComment;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = UserPost::with(['customer', 'page']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('platform')) {
            $query->where('post_platform', $request->platform);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('content', 'ilike', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->whereRaw("CONCAT(firstname, ' ', lastname) ILIKE ?", ["%{$search}%"]);
                    });
            });
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(15);

        $stats = [
            'total' => UserPost::count(),
            'published' => UserPost::where('status', UserPost::STATUS_PUBLISHED)->count(),
            'scheduled' => UserPost::where('status', UserPost::STATUS_SCHEDULED)->count(),
            'draft' => UserPost::where('status', UserPost::STATUS_DRAFT)->count(),
        ];

        return view('admin.posts.index', compact('posts', 'stats'));
    }

    public function show(UserPost $post)
    {
        $post->load(['customer', 'page', 'comments']);

        return view('admin.posts.show', compact('post'));
    }

    public function comments(Request $request)
    {
        $query = PostComment::with('post');

        if ($request->filled('platform')) {
            $query->where('platform', $request->platform);
        }

        if ($request->filled('search')) {
            $query->where('comment', 'like', "%{$request->search}%");
        }

        $comments = $query->orderBy('created_at', 'desc')->paginate(20);

        $stats = [
            'total' => PostComment::count(),
            'facebook' => PostComment::where('platform', 'facebook')->count(),
            'instagram' => PostComment::where('platform', 'instagram')->count(),
            'linkedin' => PostComment::where('platform', 'linkedin')->count(),
        ];

        return view('admin.posts.comments', compact('comments', 'stats'));
    }
}
