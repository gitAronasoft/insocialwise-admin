<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialUserPage;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $query = SocialUserPage::with(['socialUser', 'socialUser.customer']);

        if ($request->has('platform') && $request->platform !== 'all') {
            $query->where('platform', $request->platform);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('page_name', 'like', "%{$search}%")
                    ->orWhere('page_id', 'like', "%{$search}%");
            });
        }

        $pages = $query->orderBy('createdAt', 'desc')->paginate(20);

        $stats = [
            'total' => SocialUserPage::count(),
            'facebook' => SocialUserPage::where('platform', 'facebook')->count(),
            'instagram' => SocialUserPage::where('platform', 'instagram')->count(),
            'linkedin' => SocialUserPage::where('platform', 'linkedin')->count(),
        ];

        return view('admin.pages.index', compact('pages', 'stats'));
    }

    public function show(SocialUserPage $page)
    {
        $page->load(['socialUser', 'socialUser.customer']);
        return view('admin.pages.show', compact('page'));
    }
}
