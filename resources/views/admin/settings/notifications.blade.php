@extends('admin.layouts.app')

@section('title', 'Notification Settings')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Settings', 'url' => null], ['label' => 'Notifications', 'url' => null]
    ]" />
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Notification Settings</h1>
            <p class="text-sm text-gray-500 mt-1">Configure automated email notifications and reminders</p>
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

    <form action="{{ route('admin.settings.notifications.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Trial Reminders</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="text-sm font-medium text-gray-900">Enable Trial Reminders</label>
                            <p class="text-xs text-gray-500">Send email before trial expires</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="trial_reminder_enabled" value="1" 
                                {{ ($config['trial_reminder_enabled'] ?? false) ? 'checked' : '' }}
                                class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                    <div>
                        <label for="trial_reminder_hours" class="block text-sm font-medium text-gray-700 mb-1">Hours Before Trial Ends</label>
                        <input type="number" name="trial_reminder_hours" id="trial_reminder_hours" 
                            value="{{ $config['trial_reminder_hours'] ?? 24 }}"
                            min="1" max="168"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="mt-1 text-xs text-gray-500">Send reminder this many hours before trial expires (1-168)</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Renewal Reminders</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="text-sm font-medium text-gray-900">Enable Renewal Reminders</label>
                            <p class="text-xs text-gray-500">Send email before subscription renews</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="renewal_reminder_enabled" value="1" 
                                {{ ($config['renewal_reminder_enabled'] ?? false) ? 'checked' : '' }}
                                class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                    <div>
                        <label for="renewal_reminder_days" class="block text-sm font-medium text-gray-700 mb-1">Days Before Renewal</label>
                        <input type="number" name="renewal_reminder_days" id="renewal_reminder_days" 
                            value="{{ $config['renewal_reminder_days'] ?? 3 }}"
                            min="1" max="30"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="mt-1 text-xs text-gray-500">Send reminder this many days before renewal (1-30)</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 lg:col-span-2">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Transactional Emails</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <label class="text-sm font-medium text-gray-900">Payment Success</label>
                            <p class="text-xs text-gray-500">Send receipt after successful payment</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="payment_success_email" value="1" 
                                {{ ($config['payment_success_email'] ?? true) ? 'checked' : '' }}
                                class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <label class="text-sm font-medium text-gray-900">Payment Failed</label>
                            <p class="text-xs text-gray-500">Notify customer of failed payment</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="payment_failed_email" value="1" 
                                {{ ($config['payment_failed_email'] ?? true) ? 'checked' : '' }}
                                class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <label class="text-sm font-medium text-gray-900">Subscription Created</label>
                            <p class="text-xs text-gray-500">Welcome email for new subscribers</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="subscription_created_email" value="1" 
                                {{ ($config['subscription_created_email'] ?? true) ? 'checked' : '' }}
                                class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <label class="text-sm font-medium text-gray-900">Subscription Canceled</label>
                            <p class="text-xs text-gray-500">Confirmation of subscription cancellation</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="subscription_canceled_email" value="1" 
                                {{ ($config['subscription_canceled_email'] ?? true) ? 'checked' : '' }}
                                class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                Save Changes
            </button>
        </div>
    </form>

    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
        <h3 class="text-sm font-medium text-blue-800 mb-2">Email Configuration Required</h3>
        <p class="text-sm text-blue-700">
            Make sure you have configured your SMTP settings in the 
            <a href="{{ route('admin.settings.email') }}" class="underline font-medium">Email Configuration</a> 
            page for notifications to be sent successfully.
        </p>
    </div>
</div>
@endsection
