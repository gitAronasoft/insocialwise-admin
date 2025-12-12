@extends('admin.layouts.app')

@section('title', 'Two-Factor Authentication')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Profile', 'url' => route('admin.profile.show')],
        ['label' => 'Two-Factor Authentication', 'url' => null]
    ]" />

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-500 to-purple-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Two-Factor Authentication</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Add extra security to your account</p>
                    </div>
                </div>
                @if($enabled)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                        Enabled
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                        <span class="w-2 h-2 bg-gray-400 rounded-full mr-2"></span>
                        Disabled
                    </span>
                @endif
            </div>
        </div>

        <div class="p-6">
            @if(session('success'))
                <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-red-700 dark:text-red-300">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if(!$enabled)
                <div class="text-center py-8">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Secure your account</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6 max-w-md mx-auto">
                        Two-factor authentication adds an extra layer of security by requiring a code from your authenticator app when signing in.
                    </p>
                    <a href="{{ route('admin.two-factor.enable') }}" class="btn btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        Enable Two-Factor Authentication
                    </a>
                </div>
            @else
                <div class="space-y-6">
                    <div class="p-4 rounded-lg bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800">
                        <div class="flex">
                            <svg class="w-5 h-5 text-blue-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-sm text-blue-700 dark:text-blue-300">
                                    Two-factor authentication is currently <strong>enabled</strong> for your account. You will need to enter a code from your authenticator app when signing in.
                                </p>
                            </div>
                        </div>
                    </div>

                    @if(session('recoveryCodes') || count($recoveryCodes) > 0)
                    <div class="p-4 rounded-lg bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-amber-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-amber-800 dark:text-amber-300 mb-2">Recovery Codes</h4>
                                <p class="text-sm text-amber-700 dark:text-amber-400 mb-3">
                                    Store these recovery codes securely. They can be used to access your account if you lose your authenticator device.
                                </p>
                                <div class="grid grid-cols-2 gap-2 p-3 bg-white dark:bg-gray-800 rounded-lg font-mono text-sm">
                                    @foreach(session('recoveryCodes') ?? $recoveryCodes as $code)
                                        <code class="text-gray-900 dark:text-gray-100">{{ $code }}</code>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="button" onclick="document.getElementById('regenerate-modal').classList.remove('hidden')" class="btn btn-secondary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Regenerate Recovery Codes
                        </button>
                        <button type="button" onclick="document.getElementById('disable-modal').classList.remove('hidden')" class="btn btn-danger">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>
                            Disable Two-Factor
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<div id="disable-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="min-h-screen px-4 text-center">
        <div class="fixed inset-0 bg-black/50 transition-opacity" onclick="document.getElementById('disable-modal').classList.add('hidden')"></div>
        <span class="inline-block h-screen align-middle">&#8203;</span>
        <div class="inline-block w-full max-w-md p-6 my-8 text-left align-middle bg-white dark:bg-gray-800 rounded-2xl shadow-xl transform transition-all">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Disable Two-Factor Authentication</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Enter your password to disable two-factor authentication.</p>
            <form action="{{ route('admin.two-factor.disable') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input w-full" required>
                    @error('password')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('disable-modal').classList.add('hidden')" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-danger">Disable</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="regenerate-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="min-h-screen px-4 text-center">
        <div class="fixed inset-0 bg-black/50 transition-opacity" onclick="document.getElementById('regenerate-modal').classList.add('hidden')"></div>
        <span class="inline-block h-screen align-middle">&#8203;</span>
        <div class="inline-block w-full max-w-md p-6 my-8 text-left align-middle bg-white dark:bg-gray-800 rounded-2xl shadow-xl transform transition-all">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Regenerate Recovery Codes</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">This will invalidate your existing recovery codes. Enter your password to continue.</p>
            <form action="{{ route('admin.two-factor.regenerate') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input w-full" required>
                    @error('password')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('regenerate-modal').classList.add('hidden')" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Regenerate</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
