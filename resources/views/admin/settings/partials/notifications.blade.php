<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Notification Settings</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Configure email notification preferences</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.settings.notifications.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="border-l-4 border-yellow-500 pl-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-r-xl p-5">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="font-semibold text-gray-900 dark:text-white">Trial & Renewal Reminders</h3>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-lg border border-yellow-200 dark:border-yellow-800">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">Trial Expiry Reminder</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Send reminder emails before trial expires</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="trial_reminder_enabled" value="1" 
                            {{ ($notificationConfig['trial_reminder_enabled'] ?? false) ? 'checked' : '' }}
                            class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 dark:bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-yellow-200 dark:peer-focus:ring-yellow-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-yellow-500"></div>
                    </label>
                </div>
                <div class="flex items-center gap-4 pl-4">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">Hours before trial ends:</label>
                    <input type="number" name="trial_reminder_hours" value="{{ $notificationConfig['trial_reminder_hours'] ?? 48 }}"
                        min="1" max="168" 
                        class="w-24 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-yellow-500 focus:ring-yellow-500 text-center">
                    <span class="text-sm text-gray-500 dark:text-gray-400">hours (1-168)</span>
                </div>
            </div>
        </div>

        <div class="border-l-4 border-green-500 pl-4 bg-green-50 dark:bg-green-900/20 rounded-r-xl p-5">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                <h3 class="font-semibold text-gray-900 dark:text-white">Payment Notifications</h3>
            </div>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-lg border border-green-200 dark:border-green-800">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">Payment Success Email</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Send confirmation when payment succeeds</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="payment_success_email" value="1"
                            {{ ($notificationConfig['payment_success_email'] ?? true) ? 'checked' : '' }}
                            class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 dark:bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-200 dark:peer-focus:ring-green-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                    </label>
                </div>
                <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-lg border border-green-200 dark:border-green-800">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">Payment Failed Email</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Notify when payment fails</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="payment_failed_email" value="1"
                            {{ ($notificationConfig['payment_failed_email'] ?? true) ? 'checked' : '' }}
                            class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 dark:bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-200 dark:peer-focus:ring-green-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                    </label>
                </div>
            </div>
        </div>

        <div class="border-l-4 border-purple-500 pl-4 bg-purple-50 dark:bg-purple-900/20 rounded-r-xl p-5">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <h3 class="font-semibold text-gray-900 dark:text-white">Subscription Notifications</h3>
            </div>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-lg border border-purple-200 dark:border-purple-800">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">Subscription Created</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Welcome email when subscription starts</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="subscription_created_email" value="1"
                            {{ ($notificationConfig['subscription_created_email'] ?? true) ? 'checked' : '' }}
                            class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 dark:bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-200 dark:peer-focus:ring-purple-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-500"></div>
                    </label>
                </div>
                <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-lg border border-purple-200 dark:border-purple-800">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">Subscription Canceled</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Confirmation when subscription is canceled</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="subscription_canceled_email" value="1"
                            {{ ($notificationConfig['subscription_canceled_email'] ?? true) ? 'checked' : '' }}
                            class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 dark:bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-200 dark:peer-focus:ring-purple-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-500"></div>
                    </label>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-5 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <h3 class="font-semibold text-gray-900 dark:text-white">Notification Summary</h3>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                <div class="bg-white dark:bg-gray-700 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                    <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ ($notificationConfig['trial_reminder_enabled'] ?? false) ? '1' : '0' }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Trial Reminders</p>
                </div>
                <div class="bg-white dark:bg-gray-700 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                        {{ (($notificationConfig['payment_success_email'] ?? true) ? 1 : 0) + (($notificationConfig['payment_failed_email'] ?? true) ? 1 : 0) }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Payment Emails</p>
                </div>
                <div class="bg-white dark:bg-gray-700 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                    <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                        {{ (($notificationConfig['subscription_created_email'] ?? true) ? 1 : 0) + (($notificationConfig['subscription_canceled_email'] ?? true) ? 1 : 0) }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Subscription Emails</p>
                </div>
                <div class="bg-white dark:bg-gray-700 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                        {{ 
                            (($notificationConfig['trial_reminder_enabled'] ?? false) ? 1 : 0) +
                            (($notificationConfig['payment_success_email'] ?? true) ? 1 : 0) +
                            (($notificationConfig['payment_failed_email'] ?? true) ? 1 : 0) +
                            (($notificationConfig['subscription_created_email'] ?? true) ? 1 : 0) +
                            (($notificationConfig['subscription_canceled_email'] ?? true) ? 1 : 0)
                        }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Total Active</p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
            <p class="text-xs text-gray-500 dark:text-gray-400">
                Email notifications require valid SMTP configuration
            </p>
            <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 dark:focus:ring-indigo-800 transition-all font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Save Notification Settings
            </button>
        </div>
    </form>
</div>
