@extends('admin.layouts.app')

@section('title', 'Change Password')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Profile', 'url' => null], ['label' => 'Change Password', 'url' => null]
    ]" />
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900">Change Password</h3>
        <a href="{{ route('admin.profile.show') }}" class="text-indigo-600 hover:text-indigo-900">Back to Profile</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 max-w-2xl">
        <form action="{{ route('admin.profile.update-password') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">Current Password</label>
                <input type="password" name="current_password" required
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('current_password')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">New Password</label>
                <input type="password" name="password" required
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <p class="mt-1 text-xs text-gray-500">Minimum 8 characters</p>
                @error('password')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('password_confirmation')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>

            <div class="flex space-x-3 pt-6">
                <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700">Change Password</button>
                <a href="{{ route('admin.profile.show') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
