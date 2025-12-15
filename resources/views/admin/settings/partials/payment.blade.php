<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M13.976 9.15c-2.172-.806-3.356-1.426-3.356-2.409 0-.831.683-1.305 1.901-1.305 2.227 0 4.515.858 6.09 1.631l.89-5.494C18.252.975 15.697 0 12.165 0 9.667 0 7.589.654 6.104 1.872 4.56 3.147 3.757 4.992 3.757 7.218c0 4.039 2.467 5.76 6.476 7.219 2.585.92 3.445 1.574 3.445 2.583 0 .98-.84 1.545-2.354 1.545-1.875 0-4.965-.921-6.99-2.109l-.9 5.555C5.175 22.99 8.385 24 11.714 24c2.641 0 4.843-.624 6.328-1.813 1.664-1.305 2.525-3.236 2.525-5.732 0-4.128-2.524-5.851-6.591-7.305z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Stripe Payment Gateway</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Configure Stripe for payment processing</p>
            </div>
        </div>
        <a href="https://dashboard.stripe.com/apikeys" target="_blank" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            Open Stripe Dashboard
        </a>
    </div>

    <div x-data="{ 
        testing: false, 
        testResult: null,
        lastTested: localStorage.getItem('stripe_last_tested') || null,
        async testConnection() {
            this.testing = true;
            this.testResult = null;
            try {
                const response = await fetch('{{ route('admin.settings.stripe.test') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });
                const data = await response.json();
                this.testResult = data;
                if (data.success) {
                    this.lastTested = new Date().toLocaleString();
                    localStorage.setItem('stripe_last_tested', this.lastTested);
                }
            } catch (error) {
                this.testResult = { success: false, message: 'Connection test failed' };
            }
            this.testing = false;
        }
    }" class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" 
                     :class="testResult?.success ? 'bg-green-100 dark:bg-green-900/30' : testResult?.success === false ? 'bg-red-100 dark:bg-red-900/30' : 'bg-gray-100 dark:bg-gray-600'">
                    <template x-if="testing">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </template>
                    <template x-if="!testing && testResult?.success">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </template>
                    <template x-if="!testing && testResult?.success === false">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </template>
                    <template x-if="!testing && testResult === null">
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </template>
                </div>
                <div>
                    <p class="font-medium text-gray-900 dark:text-white" x-text="testing ? 'Testing connection...' : (testResult?.success ? 'Connected' : testResult?.success === false ? 'Connection Failed' : 'Connection Status')"></p>
                    <p class="text-xs text-gray-500 dark:text-gray-400" x-show="lastTested">Last tested: <span x-text="lastTested"></span></p>
                    <p class="text-xs text-gray-500 dark:text-gray-400" x-show="!lastTested && !testResult">Click to verify your Stripe credentials</p>
                    <p class="text-xs text-red-600 dark:text-red-400" x-show="testResult?.success === false" x-text="testResult?.message"></p>
                </div>
            </div>
            <button @click="testConnection()" :disabled="testing" 
                class="px-4 py-2 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                <span x-show="!testing">Test Connection</span>
                <span x-show="testing">Testing...</span>
            </button>
        </div>
    </div>

    <form action="{{ route('admin.settings.stripe.update') }}" method="POST" class="space-y-6" x-data="{ showSecrets: { publishable: false, secret: false, webhook: false } }">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                    Publishable Key
                    <span class="ml-1 text-red-500">*</span>
                    <span class="ml-2 px-2 py-0.5 text-xs bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded">Public</span>
                </label>
                <div class="relative">
                    <input :type="showSecrets.publishable ? 'text' : 'password'" name="stripe_publishable_key" 
                        value="{{ $stripeConfig['publishable_key'] ?? '' }}"
                        placeholder="pk_test_51..."
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pr-20 font-mono text-sm">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 space-x-2">
                        <button type="button" @click="showSecrets.publishable = !showSecrets.publishable" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg x-show="!showSecrets.publishable" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showSecrets.publishable" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                        <button type="button" onclick="navigator.clipboard.writeText(this.closest('.relative').querySelector('input').value)" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Starts with <code class="bg-gray-100 dark:bg-gray-700 px-1 rounded">pk_test_</code> or <code class="bg-gray-100 dark:bg-gray-700 px-1 rounded">pk_live_</code></p>
            </div>

            <div class="space-y-2">
                <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                    Secret Key
                    <span class="ml-1 text-red-500">*</span>
                    <span class="ml-2 px-2 py-0.5 text-xs bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded">Secret</span>
                </label>
                <div class="relative">
                    <input :type="showSecrets.secret ? 'text' : 'password'" name="stripe_secret_key" 
                        value="{{ $stripeConfig['secret_key'] ?? '' }}"
                        placeholder="sk_test_51..."
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pr-20 font-mono text-sm">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 space-x-2">
                        <button type="button" @click="showSecrets.secret = !showSecrets.secret" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg x-show="!showSecrets.secret" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showSecrets.secret" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                        <button type="button" onclick="navigator.clipboard.writeText(this.closest('.relative').querySelector('input').value)" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Starts with <code class="bg-gray-100 dark:bg-gray-700 px-1 rounded">sk_test_</code> or <code class="bg-gray-100 dark:bg-gray-700 px-1 rounded">sk_live_</code></p>
            </div>

            <div class="space-y-2">
                <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                    Webhook Secret
                    <span class="ml-2 px-2 py-0.5 text-xs bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 rounded">Optional</span>
                </label>
                <div class="relative">
                    <input :type="showSecrets.webhook ? 'text' : 'password'" name="stripe_webhook_secret" 
                        value="{{ $stripeConfig['webhook_secret'] ?? '' }}"
                        placeholder="whsec_..."
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pr-20 font-mono text-sm">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 space-x-2">
                        <button type="button" @click="showSecrets.webhook = !showSecrets.webhook" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg x-show="!showSecrets.webhook" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showSecrets.webhook" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                        <button type="button" onclick="navigator.clipboard.writeText(this.closest('.relative').querySelector('input').value)" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Used to verify webhook events from Stripe</p>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Environment Mode</label>
                <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                        <input type="radio" name="stripe_mode" value="test" {{ ($stripeConfig['mode'] ?? 'test') === 'test' ? 'checked' : '' }}
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300 flex items-center">
                            <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></span>
                            Test Mode
                        </span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="stripe_mode" value="live" {{ ($stripeConfig['mode'] ?? 'test') === 'live' ? 'checked' : '' }}
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300 flex items-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                            Live Mode
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
            <p class="text-xs text-gray-500 dark:text-gray-400">
                Changes will take effect immediately after saving
            </p>
            <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 dark:focus:ring-indigo-800 transition-all font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Save Stripe Settings
            </button>
        </div>
    </form>
</div>
