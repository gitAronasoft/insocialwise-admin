<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-900">Social Media API Keys</h2>
        <p class="text-sm text-gray-600">Configure social media platform integrations</p>
    </div>

    <form action="{{ route('admin.settings.social.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div class="border border-gray-200 rounded-lg p-6">
                <h3 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    Facebook
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">App ID</label>
                        <input type="text" name="facebook_app_id" value="{{ $socialConfig['facebook_app_id'] ?? '' }}"
                            placeholder="Your Facebook App ID" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">App Secret</label>
                        <input type="password" name="facebook_app_secret" value="{{ $socialConfig['facebook_app_secret'] ?? '' }}"
                            placeholder="Enter new secret to update" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
            </div>

            <div class="border border-gray-200 rounded-lg p-6">
                <h3 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-700" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                    LinkedIn
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Client ID</label>
                        <input type="text" name="linkedin_client_id" value="{{ $socialConfig['linkedin_client_id'] ?? '' }}"
                            placeholder="Your LinkedIn Client ID" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Client Secret</label>
                        <input type="password" name="linkedin_client_secret" value="{{ $socialConfig['linkedin_client_secret'] ?? '' }}"
                            placeholder="Enter new secret to update" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
            </div>

            <div class="border border-gray-200 rounded-lg p-6">
                <h3 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                    </svg>
                    X (Twitter)
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">API Key</label>
                        <input type="text" name="twitter_api_key" value="{{ $socialConfig['twitter_api_key'] ?? '' }}"
                            placeholder="Your Twitter API Key" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">API Secret</label>
                        <input type="password" name="twitter_api_secret" value="{{ $socialConfig['twitter_api_secret'] ?? '' }}"
                            placeholder="Enter new secret to update" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                Save Social API Settings
            </button>
        </div>
    </form>
</div>
