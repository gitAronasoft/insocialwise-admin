@extends('admin.layouts.app')

@section('title', 'System Settings')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Settings', 'url' => null]
    ]" />
    
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">System Settings</h1>
            <p class="text-gray-600 dark:text-gray-400">Manage all system configurations, API keys, and integrations in one place</p>
        </div>
        <div class="flex items-center space-x-3">
            <button onclick="exportSettings()" class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export
            </button>
            <a href="{{ route('admin.settings.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Setting
            </a>
        </div>
    </div>

    @php
        $stripeConfigured = !empty($stripeConfig['publishable_key'] ?? '') && !empty($stripeConfig['secret_key'] ?? '');
        $emailConfigured = !empty($emailConfig['smtp_host'] ?? '') && !empty($emailConfig['smtp_username'] ?? '');
        $socialConfigured = !empty($socialConfig['facebook_app_id'] ?? '') || !empty($socialConfig['linkedin_client_id'] ?? '') || !empty($socialConfig['twitter_api_key'] ?? '');
        $webhookConfigured = !empty($webhookConfig['n8n_webhook_url'] ?? '') || !empty($webhookConfig['zapier_webhook_url'] ?? '') || !empty($webhookConfig['custom_webhook_url'] ?? '');
        
        $stripeFields = collect([$stripeConfig['publishable_key'] ?? '', $stripeConfig['secret_key'] ?? '', $stripeConfig['webhook_secret'] ?? ''])->filter()->count();
        $emailFields = collect([$emailConfig['smtp_host'] ?? '', $emailConfig['smtp_port'] ?? '', $emailConfig['smtp_username'] ?? '', $emailConfig['from_address'] ?? ''])->filter()->count();
        $socialFields = collect([$socialConfig['facebook_app_id'] ?? '', $socialConfig['linkedin_client_id'] ?? '', $socialConfig['twitter_api_key'] ?? ''])->filter()->count();
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div onclick="switchTab('payment')" class="cursor-pointer bg-white dark:bg-gray-800 rounded-xl shadow-sm p-5 border-l-4 {{ $stripeConfigured ? 'border-green-500' : 'border-red-500' }} hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-lg {{ $stripeConfigured ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30' }} flex items-center justify-center">
                        <svg class="w-5 h-5 {{ $stripeConfigured ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Stripe</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $stripeFields }}/3 fields</p>
                    </div>
                </div>
                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $stripeConfigured ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' : 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400' }}">
                    {{ $stripeConfigured ? 'Ready' : 'Setup' }}
                </span>
            </div>
        </div>

        <div onclick="switchTab('email')" class="cursor-pointer bg-white dark:bg-gray-800 rounded-xl shadow-sm p-5 border-l-4 {{ $emailConfigured ? 'border-green-500' : 'border-yellow-500' }} hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-lg {{ $emailConfigured ? 'bg-green-100 dark:bg-green-900/30' : 'bg-yellow-100 dark:bg-yellow-900/30' }} flex items-center justify-center">
                        <svg class="w-5 h-5 {{ $emailConfigured ? 'text-green-600 dark:text-green-400' : 'text-yellow-600 dark:text-yellow-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Email</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $emailFields }}/4 fields</p>
                    </div>
                </div>
                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $emailConfigured ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' : 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400' }}">
                    {{ $emailConfigured ? 'Ready' : 'Partial' }}
                </span>
            </div>
        </div>

        <div onclick="switchTab('social')" class="cursor-pointer bg-white dark:bg-gray-800 rounded-xl shadow-sm p-5 border-l-4 {{ $socialConfigured ? 'border-green-500' : 'border-gray-300 dark:border-gray-600' }} hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-lg {{ $socialConfigured ? 'bg-green-100 dark:bg-green-900/30' : 'bg-gray-100 dark:bg-gray-700' }} flex items-center justify-center">
                        <svg class="w-5 h-5 {{ $socialConfigured ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Social APIs</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $socialFields }}/3 platforms</p>
                    </div>
                </div>
                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $socialConfigured ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300' }}">
                    {{ $socialConfigured ? 'Active' : 'None' }}
                </span>
            </div>
        </div>

        <div onclick="switchTab('webhooks')" class="cursor-pointer bg-white dark:bg-gray-800 rounded-xl shadow-sm p-5 border-l-4 {{ $webhookConfigured ? 'border-green-500' : 'border-gray-300 dark:border-gray-600' }} hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-lg {{ $webhookConfigured ? 'bg-green-100 dark:bg-green-900/30' : 'bg-gray-100 dark:bg-gray-700' }} flex items-center justify-center">
                        <svg class="w-5 h-5 {{ $webhookConfigured ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Webhooks</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Integrations</p>
                    </div>
                </div>
                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $webhookConfigured ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300' }}">
                    {{ $webhookConfigured ? 'Active' : 'None' }}
                </span>
            </div>
        </div>
    </div>

    <div x-data="{ activeTab: '{{ request('tab', 'general') }}' }" x-init="window.switchTab = (tab) => { activeTab = tab }">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm">
            <div class="border-b border-gray-200 dark:border-gray-700">
                <nav class="flex space-x-1 px-4" aria-label="Tabs">
                    <button @click="activeTab = 'general'" 
                        :class="activeTab === 'general' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'"
                        class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm transition-all rounded-t-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        General
                        <span class="ml-1 px-2 py-0.5 text-xs rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">{{ $settings->where('group', 'general')->count() }}</span>
                    </button>
                    <button @click="activeTab = 'payment'" 
                        :class="activeTab === 'payment' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'"
                        class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm transition-all rounded-t-lg flex items-center gap-2">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M13.976 9.15c-2.172-.806-3.356-1.426-3.356-2.409 0-.831.683-1.305 1.901-1.305 2.227 0 4.515.858 6.09 1.631l.89-5.494C18.252.975 15.697 0 12.165 0 9.667 0 7.589.654 6.104 1.872 4.56 3.147 3.757 4.992 3.757 7.218c0 4.039 2.467 5.76 6.476 7.219 2.585.92 3.445 1.574 3.445 2.583 0 .98-.84 1.545-2.354 1.545-1.875 0-4.965-.921-6.99-2.109l-.9 5.555C5.175 22.99 8.385 24 11.714 24c2.641 0 4.843-.624 6.328-1.813 1.664-1.305 2.525-3.236 2.525-5.732 0-4.128-2.524-5.851-6.591-7.305z"/>
                        </svg>
                        Stripe
                        <span class="ml-1 px-2 py-0.5 text-xs rounded-full {{ $stripeConfigured ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' }}">{{ $stripeFields }}/3</span>
                    </button>
                    <button @click="activeTab = 'email'" 
                        :class="activeTab === 'email' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'"
                        class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm transition-all rounded-t-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Email
                        <span class="ml-1 px-2 py-0.5 text-xs rounded-full {{ $emailConfigured ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400' }}">{{ $emailFields }}/4</span>
                    </button>
                    <button @click="activeTab = 'social'" 
                        :class="activeTab === 'social' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'"
                        class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm transition-all rounded-t-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                        </svg>
                        Social
                        <span class="ml-1 px-2 py-0.5 text-xs rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">{{ $socialFields }}</span>
                    </button>
                    <button @click="activeTab = 'webhooks'" 
                        :class="activeTab === 'webhooks' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'"
                        class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm transition-all rounded-t-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                        Webhooks
                    </button>
                    <button @click="activeTab = 'notifications'" 
                        :class="activeTab === 'notifications' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'"
                        class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm transition-all rounded-t-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        Notifications
                    </button>
                    <button @click="activeTab = 'all'" 
                        :class="activeTab === 'all' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'"
                        class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm transition-all rounded-t-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                        All
                        <span class="ml-1 px-2 py-0.5 text-xs rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">{{ $settings->count() }}</span>
                    </button>
                </nav>
            </div>

            <div class="p-6">
                <div x-show="activeTab === 'general'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    @include('admin.settings.partials.general')
                </div>

                <div x-show="activeTab === 'payment'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    @include('admin.settings.partials.payment')
                </div>

                <div x-show="activeTab === 'email'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    @include('admin.settings.partials.email')
                </div>

                <div x-show="activeTab === 'social'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    @include('admin.settings.partials.social')
                </div>

                <div x-show="activeTab === 'webhooks'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    @include('admin.settings.partials.webhooks')
                </div>

                <div x-show="activeTab === 'notifications'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    @include('admin.settings.partials.notifications')
                </div>

                <div x-show="activeTab === 'all'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    @include('admin.settings.partials.all-settings')
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-2"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 translate-y-2"
     class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
    </svg>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-2"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 translate-y-2"
     class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
    </svg>
    {{ session('error') }}
</div>
@endif

<script>
function exportSettings() {
    const settings = {
        exported_at: new Date().toISOString(),
        settings: @json($settings->toArray())
    };
    const blob = new Blob([JSON.stringify(settings, null, 2)], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'settings-export-' + new Date().toISOString().split('T')[0] + '.json';
    a.click();
    URL.revokeObjectURL(url);
}
</script>
@endsection
