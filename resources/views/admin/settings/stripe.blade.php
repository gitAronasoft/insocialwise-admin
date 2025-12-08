@extends('admin.layouts.app')

@section('title', 'Stripe Configuration')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Settings', 'url' => null], ['label' => 'Stripe', 'url' => null]
    ]" />
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Stripe Configuration</h1>
            <p class="text-sm text-gray-500 mt-1">Configure Stripe API keys for payment processing</p>
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <form action="{{ route('admin.settings.stripe.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="stripe_mode" class="block text-sm font-medium text-gray-700 mb-1">Mode</label>
                        <select name="stripe_mode" id="stripe_mode" 
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="test" {{ ($config['stripe_mode'] ?? 'test') === 'test' ? 'selected' : '' }}>Test Mode</option>
                            <option value="live" {{ ($config['stripe_mode'] ?? '') === 'live' ? 'selected' : '' }}>Live Mode</option>
                        </select>
                        @error('stripe_mode')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="stripe_publishable_key" class="block text-sm font-medium text-gray-700 mb-1">Publishable Key</label>
                        <input type="text" name="stripe_publishable_key" id="stripe_publishable_key" 
                            value="{{ $config['stripe_publishable_key'] ?? '' }}"
                            placeholder="pk_test_..."
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono text-sm">
                        @error('stripe_publishable_key')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="stripe_secret_key" class="block text-sm font-medium text-gray-700 mb-1">Secret Key</label>
                        <input type="password" name="stripe_secret_key" id="stripe_secret_key" 
                            placeholder="{{ !empty($config['stripe_secret_key']) ? '••••••••••••••••' : 'sk_test_...' }}"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono text-sm">
                        <p class="mt-1 text-xs text-gray-500">Leave empty to keep current key</p>
                        @error('stripe_secret_key')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="stripe_webhook_secret" class="block text-sm font-medium text-gray-700 mb-1">Webhook Signing Secret</label>
                        <input type="password" name="stripe_webhook_secret" id="stripe_webhook_secret" 
                            placeholder="{{ !empty($config['stripe_webhook_secret']) ? '••••••••••••••••' : 'whsec_...' }}"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono text-sm">
                        <p class="mt-1 text-xs text-gray-500">Leave empty to keep current secret</p>
                        @error('stripe_webhook_secret')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <form action="{{ route('admin.settings.stripe.test') }}" method="POST" class="inline">
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
        </div>

        <div class="space-y-4">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Current Status</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Mode</span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ ($config['stripe_mode'] ?? 'test') === 'live' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($config['stripe_mode'] ?? 'test') }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Publishable Key</span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ !empty($config['stripe_publishable_key']) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ !empty($config['stripe_publishable_key']) ? 'Configured' : 'Not Set' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Secret Key</span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ !empty($config['stripe_secret_key']) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ !empty($config['stripe_secret_key']) ? 'Configured' : 'Not Set' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Webhook Secret</span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ !empty($config['stripe_webhook_secret']) ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ !empty($config['stripe_webhook_secret']) ? 'Configured' : 'Optional' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-purple-50 border border-purple-200 rounded-xl p-4">
                <h3 class="text-sm font-medium text-purple-800 mb-2">Getting Your Keys</h3>
                <ol class="text-sm text-purple-700 space-y-1 list-decimal list-inside">
                    <li>Log in to your Stripe Dashboard</li>
                    <li>Go to Developers > API Keys</li>
                    <li>Copy your Publishable and Secret keys</li>
                    <li>For webhooks, go to Developers > Webhooks</li>
                </ol>
                <a href="https://dashboard.stripe.com/apikeys" target="_blank" class="mt-3 inline-block text-purple-600 hover:text-purple-800 font-medium text-sm">
                    Open Stripe Dashboard &rarr;
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
