<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-900">Email Settings (SMTP)</h2>
        <p class="text-sm text-gray-600">Configure email server settings for sending notifications</p>
    </div>

    <form action="{{ route('admin.settings.email.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Host</label>
                <input type="text" name="smtp_host" value="{{ $emailConfig['smtp_host'] ?? '' }}"
                    placeholder="smtp.example.com" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Port</label>
                <input type="number" name="smtp_port" value="{{ $emailConfig['smtp_port'] ?? '587' }}"
                    placeholder="587" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Username</label>
                <input type="text" name="smtp_username" value="{{ $emailConfig['smtp_username'] ?? '' }}"
                    placeholder="your@email.com" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Password</label>
                <input type="password" name="smtp_password" value="{{ $emailConfig['smtp_password'] ?? '' }}"
                    placeholder="••••••••" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Encryption</label>
                <select name="smtp_encryption" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="tls" {{ ($emailConfig['smtp_encryption'] ?? 'tls') === 'tls' ? 'selected' : '' }}>TLS</option>
                    <option value="ssl" {{ ($emailConfig['smtp_encryption'] ?? '') === 'ssl' ? 'selected' : '' }}>SSL</option>
                    <option value="none" {{ ($emailConfig['smtp_encryption'] ?? '') === 'none' ? 'selected' : '' }}>None</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">From Address</label>
                <input type="email" name="from_address" value="{{ $emailConfig['from_address'] ?? '' }}"
                    placeholder="noreply@example.com" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">From Name</label>
                <input type="text" name="from_name" value="{{ $emailConfig['from_name'] ?? '' }}"
                    placeholder="InSocialWise" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
        </div>

        <div class="flex items-center space-x-4 pt-4">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                Save Email Settings
            </button>
            <form action="{{ route('admin.settings.email.test') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">
                    Send Test Email
                </button>
            </form>
        </div>
    </form>
</div>
