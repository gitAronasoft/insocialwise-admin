<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = AdminUser::with('roles');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('roles.id', $request->role);
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active' ? 1 : 0);
        }

        $adminUsers = $query->orderBy('created_at', 'desc')->paginate(15);
        $roles = Role::all();

        return view('admin.admin-users.index', compact('adminUsers', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.admin-users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admin_users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['exists:roles,id'],
        ]);

        $adminUser = AdminUser::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_active' => true,
        ]);

        $adminUser->syncRoles($validated['roles']);

        return redirect()->route('admin.admin-users.index')
            ->with('success', 'Admin user created successfully.');
    }

    public function edit(AdminUser $adminUser)
    {
        $roles = Role::all();
        $userRoleIds = $adminUser->roles->pluck('id')->toArray();
        $currentUser = Auth::guard('admin')->user();
        $isSelf = $currentUser->id === $adminUser->id;

        return view('admin.admin-users.edit', compact('adminUser', 'roles', 'userRoleIds', 'isSelf'));
    }

    public function update(Request $request, AdminUser $adminUser)
    {
        $currentUser = Auth::guard('admin')->user();
        $isSelf = $currentUser->id === $adminUser->id;

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admin_users,email,' . $adminUser->id],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['exists:roles,id'],
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['confirmed', Password::defaults()];
        }

        $validated = $request->validate($rules);

        $superAdminRole = Role::where('name', 'super_admin')->first();
        if ($isSelf && $superAdminRole && $adminUser->hasRole($superAdminRole->name)) {
            if (!in_array($superAdminRole->id, $validated['roles'])) {
                return redirect()->back()
                    ->withErrors(['roles' => 'You cannot remove the Super Admin role from yourself.'])
                    ->withInput();
            }
        }

        $adminUser->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($request->filled('password')) {
            $adminUser->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        $adminUser->syncRoles($validated['roles']);

        return redirect()->route('admin.admin-users.index')
            ->with('success', 'Admin user updated successfully.');
    }

    public function destroy(AdminUser $adminUser)
    {
        $currentUser = Auth::guard('admin')->user();

        if ($currentUser->id === $adminUser->id) {
            return redirect()->back()
                ->with('error', 'You cannot delete your own account.');
        }

        $superAdminRole = Role::where('name', 'super_admin')->first();
        if ($superAdminRole && $adminUser->hasRole($superAdminRole->name)) {
            $superAdminCount = AdminUser::whereHas('roles', function ($q) use ($superAdminRole) {
                $q->where('roles.id', $superAdminRole->id);
            })->count();

            if ($superAdminCount <= 1) {
                return redirect()->back()
                    ->with('error', 'Cannot delete the last Super Admin user.');
            }
        }

        $adminUser->roles()->detach();
        $adminUser->delete();

        return redirect()->route('admin.admin-users.index')
            ->with('success', 'Admin user deleted successfully.');
    }

    public function toggleStatus(AdminUser $adminUser)
    {
        $currentUser = Auth::guard('admin')->user();

        if ($currentUser->id === $adminUser->id) {
            return redirect()->back()
                ->with('error', 'You cannot deactivate your own account.');
        }

        $adminUser->update(['status' => $adminUser->status === 'active' ? 'inactive' : 'active']);

        $status = $adminUser->status === 'active' ? 'deactivated' : 'activated';

        return redirect()->back()
            ->with('success', "Admin user {$status} successfully.");
    }
}
