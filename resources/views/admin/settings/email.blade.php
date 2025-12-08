@extends('admin.layouts.app')

@section('title', 'Email Configuration')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Settings', 'url' => null], ['label' => 'Email', 'url' => null]
    ]" />
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Email Configuration</h1>
            <p class="text-sm text-gray-500 mt-1">Configure SMTP settings for sending emails</p>
        </div>
        <a href="{{ route('admin.settings.index') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Settings
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.settings.email.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="smtp_host" class="block text-sm font-medium text-gray-700 mb-1">SMTP Host</label>
                    <input type="text" name="smtp_host" id="smtp_host" 
                        value="{{ $config['smtp_host'] ?? '' }}"
                        placeholder="smtp.example.com"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('smtp_host')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="smtp_port" class="block text-sm font-medium text-gray-700 mb-1">SMTP Port</label>
                    <input type="number" name="smtp_port" id="smtp_port" 
                        value="{{ $config['smtp_port'] ?? 587 }}"
                        placeholder="587"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('smtp_port')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="smtp_username" class="block text-sm font-medium text-gray-700 mb-1">SMTP Username</label>
                    <input type="text" name="smtp_username" id="smtp_username" 
                        value="{{ $config['smtp_username'] ?? '' }}"
                        placeholder="your-email@example.com"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('smtp_username')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="smtp_password" class="block text-sm font-medium text-gray-700 mb-1">SMTP Password</label>
                    <input type="password" name="smtp_password" id="smtp_password" 
                        placeholder="{{ !empty($config['smtp_password']) ? '••••••••' : 'Enter password' }}"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <p class="mt-1 text-xs text-gray-500">Leave empty to keep current password</p>
                    @error('smtp_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="smtp_encryption" class="block text-sm font-medium text-gray-700 mb-1">Encryption</label>
                    <select name="smtp_encryption" id="smtp_encryption" 
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="tls" {{ ($config['smtp_encryption'] ?? 'tls') === 'tls' ? 'selected' : '' }}>TLS</option>
                        <option value="ssl" {{ ($config['smtp_encryption'] ?? '') === 'ssl' ? 'selected' : '' }}>SSL</option>
                        <option value="none" {{ ($config['smtp_encryption'] ?? '') === 'none' ? 'selected' : '' }}>None</option>
                    </select>
                    @error('smtp_encryption')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="from_address" class="block text-sm font-medium text-gray-700 mb-1">From Email Address</label>
                    <input type="email" name="from_address" id="from_address" 
                        value="{{ $config['from_address'] ?? '' }}"
                        placeholder="noreply@example.com"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('from_address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="from_name" class="block text-sm font-medium text-gray-700 mb-1">From Name</label>
                    <input type="text" name="from_name" id="from_name" 
                        value="{{ $config['from_name'] ?? '' }}"
                        placeholder="InSocialWise"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('from_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                <form action="{{ route('admin.settings.email.test') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-indigo-600 hover:text-indigo-800 font-medium">
                        Test Connection
                    </button>
                </form>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
        <h3 class="text-sm font-medium text-blue-800 mb-2">Common SMTP Providers</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-blue-700">
            <div>
                <strong>Gmail:</strong><br>
                Host: smtp.gmail.com<br>
                Port: 587 (TLS)
            </div>
            <div>
                <strong>SendGrid:</strong><br>
                Host: smtp.sendgrid.net<br>
                Port: 587 (TLS)
            </div>
            <div>
                <strong>Mailgun:</strong><br>
                Host: smtp.mailgun.org<br>
                Port: 587 (TLS)
            </div>
        </div>
    </div>
</div>
@endsection
