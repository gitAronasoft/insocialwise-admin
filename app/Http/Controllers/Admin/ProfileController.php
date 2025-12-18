<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helpers\DateHelper;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::guard('admin')->user();
        return view('admin.profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::guard('admin')->user();
        $timezones = DateHelper::getCommonTimezones();
        return view('admin.profile.edit', compact('user', 'timezones'));
    }

    public function update(Request $request)
    {
        $user = Auth::guard('admin')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admin_users,email,' . $user->id,
            'timezone' => 'required|string|timezone',
        ]);

        $user->update($validated);

        return redirect()->route('admin.profile.show')
            ->with('success', 'Profile updated successfully.');
    }

    public function changePassword()
    {
        return view('admin.profile.change-password');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password:admin',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Auth::guard('admin')->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.profile.show')
            ->with('success', 'Password changed successfully.');
    }
}
