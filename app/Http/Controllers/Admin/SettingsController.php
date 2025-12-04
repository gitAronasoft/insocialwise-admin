<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    protected $groups = ['general', 'email', 'api', 'payment', 'feature', 'system'];
    protected $types = ['string', 'integer', 'boolean', 'json', 'email'];

    public function index(Request $request)
    {
        $query = AdminSetting::query();

        if ($request->filled('group')) {
            $query->where('group', $request->group);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('key', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $settings = $query->orderBy('group')->orderBy('key')->paginate(20);

        $stats = [
            'total' => AdminSetting::count(),
            'general' => AdminSetting::where('group', 'general')->count(),
            'email' => AdminSetting::where('group', 'email')->count(),
            'api' => AdminSetting::where('group', 'api')->count(),
            'payment' => AdminSetting::where('group', 'payment')->count(),
        ];

        $groups = $this->groups;
        return view('admin.settings.index', compact('settings', 'stats', 'groups'));
    }

    public function create()
    {
        $groups = $this->groups;
        $types = $this->types;
        return view('admin.settings.create', compact('groups', 'types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:255|unique:admin_settings,key',
            'value' => 'nullable|string',
            'type' => 'required|in:' . implode(',', $this->types),
            'group' => 'required|in:' . implode(',', $this->groups),
            'description' => 'nullable|string|max:500',
            'section' => 'nullable|string|max:100',
        ]);

        AdminSetting::create($validated);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Setting created successfully.');
    }

    public function edit(AdminSetting $setting)
    {
        $groups = $this->groups;
        $types = $this->types;
        return view('admin.settings.edit', compact('setting', 'groups', 'types'));
    }

    public function update(Request $request, AdminSetting $setting)
    {
        $validated = $request->validate([
            'value' => 'nullable|string',
            'type' => 'required|in:' . implode(',', $this->types),
            'description' => 'nullable|string|max:500',
            'section' => 'nullable|string|max:100',
        ]);

        $setting->update($validated);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Setting updated successfully.');
    }

    public function destroy(AdminSetting $setting)
    {
        $key = $setting->key;
        $setting->delete();

        return redirect()->route('admin.settings.index')
            ->with('success', "Setting '{$key}' deleted successfully.");
    }
}
