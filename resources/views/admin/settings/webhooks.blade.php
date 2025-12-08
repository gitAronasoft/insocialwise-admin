@extends('admin.layouts.app')

@section('title', 'Webhook URLs')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Settings', 'url' => null], ['label' => 'Webhooks', 'url' => null]
    ]" />
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Webhook URLs</h1>
            <p class="text-sm text-gray-500 mt-1">Configure external webhook integrations for automation</p>
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
        <form action="{{ route('admin.settings.webhooks.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div class="border-b border-gray-200 pb-4">
                    <div class="flex items-center mb-2">
                        <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <label for="n8n_webhook_url" class="block text-sm font-medium text-gray-900">n8n Webhook URL</label>
                            <p class="text-xs text-gray-500">Automation workflow platform</p>
                        </div>
                    </div>
                    <input type="url" name="n8n_webhook_url" id="n8n_webhook_url" 
                        value="{{ $config['n8n_webhook_url'] ?? '' }}"
                        placeholder="https://your-n8n-instance.com/webhook/..."
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('n8n_webhook_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="border-b border-gray-200 pb-4">
                    <div class="flex items-center mb-2">
                        <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                            </svg>
                        </div>
                        <div>
                            <label for="zapier_webhook_url" class="block text-sm font-medium text-gray-900">Zapier Webhook URL</label>
                            <p class="text-xs text-gray-500">Connect to 5000+ apps</p>
                        </div>
                    </div>
                    <input type="url" name="zapier_webhook_url" id="zapier_webhook_url" 
                        value="{{ $config['zapier_webhook_url'] ?? '' }}"
                        placeholder="https://hooks.zapier.com/hooks/catch/..."
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('zapier_webhook_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="border-b border-gray-200 pb-4">
                    <div class="flex items-center mb-2">
                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                            </svg>
                        </div>
                        <div>
                            <label for="custom_webhook_url" class="block text-sm font-medium text-gray-900">Custom Webhook URL</label>
                            <p class="text-xs text-gray-500">Any HTTP endpoint for custom integrations</p>
                        </div>
                    </div>
                    <input type="url" name="custom_webhook_url" id="custom_webhook_url" 
                        value="{{ $config['custom_webhook_url'] ?? '' }}"
                        placeholder="https://your-api.com/webhook"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('custom_webhook_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex items-center mb-2">
                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <div>
                            <label for="webhook_secret" class="block text-sm font-medium text-gray-900">Webhook Secret</label>
                            <p class="text-xs text-gray-500">Used to sign outgoing webhook payloads</p>
                        </div>
                    </div>
                    <input type="password" name="webhook_secret" id="webhook_secret" 
                        placeholder="{{ !empty($config['webhook_secret']) ? '••••••••••••••••' : 'Enter a secret key' }}"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <p class="mt-1 text-xs text-gray-500">Leave empty to keep current secret</p>
                    @error('webhook_secret')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-200">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Webhook Events</h3>
        <p class="text-sm text-gray-600 mb-4">The following events will trigger webhook notifications:</p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="flex items-center space-x-2 text-sm text-gray-700">
                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                <span>subscription.created</span>
            </div>
            <div class="flex items-center space-x-2 text-sm text-gray-700">
                <span class="w-2 h-2 bg-yellow-500 rounded-full"></span>
                <span>subscription.updated</span>
            </div>
            <div class="flex items-center space-x-2 text-sm text-gray-700">
                <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                <span>subscription.canceled</span>
            </div>
            <div class="flex items-center space-x-2 text-sm text-gray-700">
                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                <span>payment.succeeded</span>
            </div>
            <div class="flex items-center space-x-2 text-sm text-gray-700">
                <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                <span>payment.failed</span>
            </div>
            <div class="flex items-center space-x-2 text-sm text-gray-700">
                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                <span>customer.created</span>
            </div>
            <div class="flex items-center space-x-2 text-sm text-gray-700">
                <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                <span>trial.ending</span>
            </div>
            <div class="flex items-center space-x-2 text-sm text-gray-700">
                <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                <span>invoice.created</span>
            </div>
        </div>
    </div>
</div>
@endsection
