<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Email Configuration (SMTP)</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Configure email server for sending notifications</p>
            </div>
        </div>
    </div>

    <div x-data="{ 
        testing: false, 
        testResult: null,
        lastTested: localStorage.getItem('email_last_tested') || null,
        async testEmail() {
            this.testing = true;
            this.testResult = null;
            try {
                const response = await fetch('{{ route('admin.settings.email.test') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                this.testResult = data;
                if (data.success) {
                    this.lastTested = new Date().toLocaleString();
                    localStorage.setItem('email_last_tested', this.lastTested);
                }
            } catch (error) {
                this.testResult = { success: false, message: 'Failed to send test email' };
            }
            this.testing = false;
        }
    }" class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-xl p-4 border border-green-200 dark:border-green-800">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center"
                     :class="testResult?.success ? 'bg-green-100 dark:bg-green-900/30' : testResult?.success === false ? 'bg-red-100 dark:bg-red-900/30' : 'bg-white dark:bg-gray-700'">
                    <template x-if="testing">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 animate-spin" fill="none" viewBox="0 0 24 24">
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
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </template>
                </div>
                <div>
                    <p class="font-medium text-gray-900 dark:text-white" x-text="testing ? 'Sending test email...' : (testResult?.success ? 'Email Sent Successfully!' : testResult?.success === false ? 'Email Failed' : 'Test Email Delivery')"></p>
                    <p class="text-xs text-gray-500 dark:text-gray-400" x-show="lastTested">Last tested: <span x-text="lastTested"></span></p>
                    <p class="text-xs text-gray-500 dark:text-gray-400" x-show="!lastTested && !testResult">Send a test email to verify your SMTP configuration</p>
                    <p class="text-xs text-red-600 dark:text-red-400" x-show="testResult?.success === false" x-text="testResult?.message"></p>
                </div>
            </div>
            <button @click="testEmail()" :disabled="testing"
                class="px-4 py-2 bg-white dark:bg-gray-700 border border-green-300 dark:border-green-700 rounded-lg text-sm font-medium text-green-700 dark:text-green-400 hover:bg-green-50 dark:hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                <span x-show="!testing">Send Test Email</span>
                <span x-show="testing">Sending...</span>
            </button>
        </div>
    </div>

    <form action="{{ route('admin.settings.email.update') }}" method="POST" class="space-y-6" x-data="{ showPassword: false }">
        @csrf
        @method('PUT')

        <div class="border-l-4 border-blue-500 pl-4">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                </svg>
                Server Settings
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                        SMTP Host
                        <span class="ml-1 text-red-500">*</span>
                    </label>
                    <input type="text" name="smtp_host" value="{{ $emailConfig['smtp_host'] ?? '' }}"
                        placeholder="smtp.example.com" 
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <p class="text-xs text-gray-500 dark:text-gray-400">e.g., smtp.gmail.com, smtp.sendgrid.net</p>
                </div>

                <div class="space-y-2">
                    <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                        SMTP Port
                        <span class="ml-1 text-red-500">*</span>
                    </label>
                    <select name="smtp_port" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="587" {{ ($emailConfig['smtp_port'] ?? '587') == '587' ? 'selected' : '' }}>587 (TLS - Recommended)</option>
                        <option value="465" {{ ($emailConfig['smtp_port'] ?? '') == '465' ? 'selected' : '' }}>465 (SSL)</option>
                        <option value="25" {{ ($emailConfig['smtp_port'] ?? '') == '25' ? 'selected' : '' }}>25 (Unencrypted)</option>
                        <option value="2525" {{ ($emailConfig['smtp_port'] ?? '') == '2525' ? 'selected' : '' }}>2525 (Alternative)</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">SMTP Username</label>
                    <input type="text" name="smtp_username" value="{{ $emailConfig['smtp_username'] ?? '' }}"
                        placeholder="your@email.com" 
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">SMTP Password</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="smtp_password" value="{{ $emailConfig['smtp_password'] ?? '' }}"
                            placeholder="Enter password" 
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pr-10">
                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Encryption</label>
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center">
                            <input type="radio" name="smtp_encryption" value="tls" {{ ($emailConfig['smtp_encryption'] ?? 'tls') === 'tls' ? 'checked' : '' }}
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">TLS</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="smtp_encryption" value="ssl" {{ ($emailConfig['smtp_encryption'] ?? '') === 'ssl' ? 'checked' : '' }}
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">SSL</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="smtp_encryption" value="none" {{ ($emailConfig['smtp_encryption'] ?? '') === 'none' ? 'checked' : '' }}
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">None</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-l-4 border-purple-500 pl-4">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Sender Identity
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                        From Email Address
                        <span class="ml-1 text-red-500">*</span>
                    </label>
                    <input type="email" name="from_address" value="{{ $emailConfig['from_address'] ?? '' }}"
                        placeholder="noreply@example.com" 
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <p class="text-xs text-gray-500 dark:text-gray-400">The email address that will appear in the "From" field</p>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">From Name</label>
                    <input type="text" name="from_name" value="{{ $emailConfig['from_name'] ?? '' }}"
                        placeholder="InSocialWise" 
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <p class="text-xs text-gray-500 dark:text-gray-400">The sender name that recipients will see</p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
            <p class="text-xs text-gray-500 dark:text-gray-400">
                Save settings before sending a test email
            </p>
            <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 dark:focus:ring-indigo-800 transition-all font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Save Email Settings
            </button>
        </div>
    </form>
</div>
