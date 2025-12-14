<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Webhook Integrations</h2>
                <p class="text-sm text-gray-600">Connect to external automation services</p>
            </div>
        </div>
        <a href="{{ route('admin.webhook-logs.index') }}" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            View Webhook Logs
        </a>
    </div>

    <form action="{{ route('admin.settings.webhooks.update') }}" method="POST" class="space-y-6" x-data="{ showSecrets: { n8n: false, zapier: false, custom: false } }">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-gradient-to-br from-orange-50 to-red-50 rounded-xl p-6 border border-orange-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-orange-500 flex items-center justify-center">
                            <span class="text-white font-bold text-sm">n8n</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">N8N</h3>
                            <p class="text-xs text-gray-500">Workflow automation</p>
                        </div>
                    </div>
                    @if(!empty($webhookConfig['n8n_webhook_url']))
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                            Active
                        </span>
                    @else
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">Inactive</span>
                    @endif
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Webhook URL</label>
                    <input type="url" name="n8n_webhook_url" value="{{ $webhookConfig['n8n_webhook_url'] ?? '' }}"
                        placeholder="https://n8n.example.com/webhook/..." 
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 font-mono text-sm">
                    <p class="text-xs text-gray-500">Enter your N8N webhook endpoint URL</p>
                </div>
                <a href="https://n8n.io" target="_blank" class="inline-flex items-center text-xs text-orange-600 hover:text-orange-800 mt-3">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Learn more about N8N
                </a>
            </div>

            <div class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-xl p-6 border border-orange-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-orange-400 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm-1.2 17.4L7.2 14l1.44-1.44 2.16 2.16 4.32-4.32L16.56 12l-5.76 5.4z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Zapier</h3>
                            <p class="text-xs text-gray-500">Connect 5000+ apps</p>
                        </div>
                    </div>
                    @if(!empty($webhookConfig['zapier_webhook_url']))
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                            Active
                        </span>
                    @else
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">Inactive</span>
                    @endif
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Webhook URL</label>
                    <input type="url" name="zapier_webhook_url" value="{{ $webhookConfig['zapier_webhook_url'] ?? '' }}"
                        placeholder="https://hooks.zapier.com/..." 
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 font-mono text-sm">
                    <p class="text-xs text-gray-500">Enter your Zapier webhook endpoint URL</p>
                </div>
                <a href="https://zapier.com/apps/webhook/integrations" target="_blank" class="inline-flex items-center text-xs text-orange-600 hover:text-orange-800 mt-3">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Learn more about Zapier
                </a>
            </div>
        </div>

        <div class="bg-gradient-to-r from-gray-50 to-slate-50 rounded-xl p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gray-600 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Custom Webhook</h3>
                        <p class="text-xs text-gray-500">Your own endpoint</p>
                    </div>
                </div>
                @if(!empty($webhookConfig['custom_webhook_url']))
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                        Active
                    </span>
                @else
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">Inactive</span>
                @endif
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Webhook URL</label>
                    <input type="url" name="custom_webhook_url" value="{{ $webhookConfig['custom_webhook_url'] ?? '' }}"
                        placeholder="https://your-server.com/webhook" 
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 font-mono text-sm">
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Signing Secret</label>
                    <div class="relative">
                        <input :type="showSecrets.custom ? 'text' : 'password'" name="webhook_secret" value="{{ $webhookConfig['webhook_secret'] ?? '' }}"
                            placeholder="Your webhook signing secret" 
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 pr-10 font-mono text-sm">
                        <button type="button" @click="showSecrets.custom = !showSecrets.custom" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                            <svg x-show="!showSecrets.custom" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showSecrets.custom" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500">Used to verify webhook payloads</p>
                </div>
            </div>
        </div>

        <div class="bg-blue-50 rounded-xl p-5 border border-blue-100">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-medium text-blue-900">How Webhooks Work</h4>
                    <p class="text-sm text-blue-700 mt-1">When events occur (payments, subscriptions, etc.), we'll send a POST request to your configured webhooks with event data. Your endpoints should return a 2xx status code to acknowledge receipt.</p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
            <p class="text-xs text-gray-500">
                Webhooks are sent in real-time when events occur
            </p>
            <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 transition-all font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Save Webhook Settings
            </button>
        </div>
    </form>
</div>
