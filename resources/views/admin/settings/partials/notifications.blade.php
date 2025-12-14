<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-900">Notification Settings</h2>
        <p class="text-sm text-gray-600">Configure email notification preferences</p>
    </div>

    <form action="{{ route('admin.settings.notifications.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div class="border border-gray-200 rounded-lg p-6">
                <h3 class="text-md font-semibold text-gray-900 mb-4">Trial & Renewal Reminders</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="font-medium text-gray-900">Trial Expiry Reminder</label>
                            <p class="text-sm text-gray-600">Send reminder emails before trial expires</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="trial_reminder_enabled" value="1" 
                                {{ ($notificationConfig['trial_reminder_enabled'] ?? false) ? 'checked' : '' }}
                                class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hours Before Trial Ends</label>
                        <input type="number" name="trial_reminder_hours" value="{{ $notificationConfig['trial_reminder_hours'] ?? 48 }}"
                            min="1" max="168" class="w-32 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
            </div>

            <div class="border border-gray-200 rounded-lg p-6">
                <h3 class="text-md font-semibold text-gray-900 mb-4">Payment Notifications</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="font-medium text-gray-900">Payment Success Email</label>
                            <p class="text-sm text-gray-600">Send confirmation when payment succeeds</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="payment_success_email" value="1"
                                {{ ($notificationConfig['payment_success_email'] ?? true) ? 'checked' : '' }}
                                class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="font-medium text-gray-900">Payment Failed Email</label>
                            <p class="text-sm text-gray-600">Notify when payment fails</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="payment_failed_email" value="1"
                                {{ ($notificationConfig['payment_failed_email'] ?? true) ? 'checked' : '' }}
                                class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="border border-gray-200 rounded-lg p-6">
                <h3 class="text-md font-semibold text-gray-900 mb-4">Subscription Notifications</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="font-medium text-gray-900">Subscription Created</label>
                            <p class="text-sm text-gray-600">Welcome email when subscription starts</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="subscription_created_email" value="1"
                                {{ ($notificationConfig['subscription_created_email'] ?? true) ? 'checked' : '' }}
                                class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="font-medium text-gray-900">Subscription Canceled</label>
                            <p class="text-sm text-gray-600">Confirmation when subscription is canceled</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="subscription_canceled_email" value="1"
                                {{ ($notificationConfig['subscription_canceled_email'] ?? true) ? 'checked' : '' }}
                                class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                Save Notification Settings
            </button>
        </div>
    </form>
</div>
