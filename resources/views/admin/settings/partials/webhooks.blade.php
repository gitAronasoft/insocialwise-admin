<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-900">Webhook Settings</h2>
        <p class="text-sm text-gray-600">Configure webhook URLs for external integrations</p>
    </div>

    <form action="{{ route('admin.settings.webhooks.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div class="border border-gray-200 rounded-lg p-6">
                <h3 class="text-md font-semibold text-gray-900 mb-4">N8N Integration</h3>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">N8N Webhook URL</label>
                    <input type="url" name="n8n_webhook_url" value="{{ $webhookConfig['n8n_webhook_url'] ?? '' }}"
                        placeholder="https://n8n.example.com/webhook/..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <p class="text-xs text-gray-500 mt-1">Enter your N8N webhook endpoint URL</p>
                </div>
            </div>

            <div class="border border-gray-200 rounded-lg p-6">
                <h3 class="text-md font-semibold text-gray-900 mb-4">Zapier Integration</h3>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Zapier Webhook URL</label>
                    <input type="url" name="zapier_webhook_url" value="{{ $webhookConfig['zapier_webhook_url'] ?? '' }}"
                        placeholder="https://hooks.zapier.com/..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <p class="text-xs text-gray-500 mt-1">Enter your Zapier webhook endpoint URL</p>
                </div>
            </div>

            <div class="border border-gray-200 rounded-lg p-6">
                <h3 class="text-md font-semibold text-gray-900 mb-4">Custom Webhook</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Custom Webhook URL</label>
                        <input type="url" name="custom_webhook_url" value="{{ $webhookConfig['custom_webhook_url'] ?? '' }}"
                            placeholder="https://your-server.com/webhook" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Webhook Secret</label>
                        <input type="password" name="webhook_secret" value="{{ $webhookConfig['webhook_secret'] ?? '' }}"
                            placeholder="Your webhook signing secret" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                Save Webhook Settings
            </button>
        </div>
    </form>

    <div class="mt-8 pt-6 border-t border-gray-200">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-md font-semibold text-gray-900">Webhook Logs</h3>
                <p class="text-sm text-gray-600">View incoming webhook events and their status</p>
            </div>
            <a href="{{ route('admin.webhook-logs.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                View All Logs &rarr;
            </a>
        </div>
    </div>
</div>
