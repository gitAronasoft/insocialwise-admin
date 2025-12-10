<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KnowledgeBase;
use App\Models\KnowledgebaseMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KnowledgeBaseController extends Controller
{
    public function index(Request $request)
    {
        $query = KnowledgeBase::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('knowledgeBase_title', 'like', "%{$search}%")
                    ->orWhere('knowledgeBase_content', 'like', "%{$search}%");
            });
        }

        $articles = $query->orderBy('created_at', 'desc')->paginate(15);

        $categories = [];

        $stats = [
            'total' => KnowledgeBase::count(),
            'published' => KnowledgeBase::where('status', 'published')->count(),
            'draft' => KnowledgeBase::where('status', 'draft')->count(),
            'total_views' => 0,
        ];

        return view('admin.knowledge-base.index', compact('articles', 'categories', 'stats'));
    }

    public function create()
    {
        $categories = [];

        return view('admin.knowledge-base.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string|max:100',
            'status' => 'required|in:draft,published',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $article = KnowledgeBase::create($validated);

        if ($request->filled('meta_description')) {
            KnowledgebaseMeta::create([
                'knowledgebase_id' => $article->id,
                'meta_key' => 'description',
                'meta_value' => $request->meta_description,
            ]);
        }

        if ($request->filled('meta_keywords')) {
            KnowledgebaseMeta::create([
                'knowledgebase_id' => $article->id,
                'meta_key' => 'keywords',
                'meta_value' => $request->meta_keywords,
            ]);
        }

        return redirect()->route('admin.knowledge-base.index')
            ->with('success', 'Article created successfully.');
    }

    public function show(KnowledgeBase $knowledgeBase)
    {
        $knowledgeBase->load('meta');

        return view('admin.knowledge-base.show', compact('knowledgeBase'));
    }

    public function edit(KnowledgeBase $knowledgeBase)
    {
        $knowledgeBase->load('meta');

        $categories = [];

        return view('admin.knowledge-base.edit', compact('knowledgeBase', 'categories'));
    }

    public function update(Request $request, KnowledgeBase $knowledgeBase)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string|max:100',
            'status' => 'required|in:draft,published',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $knowledgeBase->update($validated);

        $knowledgeBase->meta()->where('meta_key', 'description')->delete();
        $knowledgeBase->meta()->where('meta_key', 'keywords')->delete();

        if ($request->filled('meta_description')) {
            KnowledgebaseMeta::create([
                'knowledgebase_id' => $knowledgeBase->id,
                'meta_key' => 'description',
                'meta_value' => $request->meta_description,
            ]);
        }

        if ($request->filled('meta_keywords')) {
            KnowledgebaseMeta::create([
                'knowledgebase_id' => $knowledgeBase->id,
                'meta_key' => 'keywords',
                'meta_value' => $request->meta_keywords,
            ]);
        }

        return redirect()->route('admin.knowledge-base.index')
            ->with('success', 'Article updated successfully.');
    }

    public function destroy(KnowledgeBase $knowledgeBase)
    {
        $knowledgeBase->meta()->delete();
        $knowledgeBase->delete();

        return redirect()->route('admin.knowledge-base.index')
            ->with('success', 'Article deleted successfully.');
    }
}
