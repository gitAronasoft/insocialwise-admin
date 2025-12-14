<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-900">Payment Settings (Stripe)</h2>
        <p class="text-sm text-gray-600">Configure Stripe payment gateway credentials</p>
    </div>

    <form action="{{ route('admin.settings.stripe.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Stripe Publishable Key</label>
                <input type="text" name="stripe_publishable_key" value="{{ $stripeConfig['publishable_key'] ?? '' }}"
                    placeholder="pk_test_..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <p class="text-xs text-gray-500 mt-1">Your Stripe publishable key (starts with pk_)</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Stripe Secret Key</label>
                <input type="password" name="stripe_secret_key" value="{{ $stripeConfig['secret_key'] ?? '' }}"
                    placeholder="sk_test_..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <p class="text-xs text-gray-500 mt-1">Your Stripe secret key (starts with sk_)</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Stripe Webhook Secret</label>
                <input type="password" name="stripe_webhook_secret" value="{{ $stripeConfig['webhook_secret'] ?? '' }}"
                    placeholder="whsec_..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <p class="text-xs text-gray-500 mt-1">Webhook signing secret for verifying events</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Mode</label>
                <select name="stripe_mode" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="test" {{ ($stripeConfig['mode'] ?? 'test') === 'test' ? 'selected' : '' }}>Test Mode</option>
                    <option value="live" {{ ($stripeConfig['mode'] ?? 'test') === 'live' ? 'selected' : '' }}>Live Mode</option>
                </select>
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                Save Payment Settings
            </button>
        </div>
    </form>

    <form action="{{ route('admin.settings.stripe.test') }}" method="POST" class="mt-4">
        @csrf
        <button type="submit" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">
            Test Connection
        </button>
    </form>
</div>
