@extends('admin.layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Profile', 'url' => route('admin.profile.show')], ['label' => 'View Details', 'url' => null]
    ]" />
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900">My Profile</h3>
        <a href="{{ route('admin.profile.edit') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Edit Profile</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h4 class="text-lg font-semibold text-gray-900 mb-4">Account Information</h4>
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Name</p>
                    <p class="text-gray-900">{{ $user->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Email</p>
                    <p class="text-gray-900">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Role</p>
                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">Administrator</span>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Timezone</p>
                    <p class="text-gray-900">{{ $user->timezone ?? 'UTC' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Last Updated</p>
                    <p class="text-gray-900">@formatDate($user->updated_at)</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h4 class="text-lg font-semibold text-gray-900 mb-4">Security</h4>
            <div class="space-y-4">
                <p class="text-sm text-gray-600">Manage your password and security settings.</p>
                <a href="{{ route('admin.profile.change-password') }}" class="inline-block bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700">Change Password</a>
                
                @if($user->email_verified_at)
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-500">Email Verification</p>
                        <p class="text-sm text-green-600 flex items-center mt-1">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            Verified on @formatDate($user->email_verified_at, 'M d, Y')
                        </p>
                    </div>
                @else
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-500">Email Verification</p>
                        <p class="text-sm text-red-600 flex items-center mt-1">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                            Not verified
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
