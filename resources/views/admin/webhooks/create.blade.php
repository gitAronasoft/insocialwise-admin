@extends('admin.layouts.app')

@section('title', 'Create Webhook')

@section('content')
<div class="space-y-6" x-data="webhookForm()">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.webhooks.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 mb-2">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Webhooks
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create Webhook</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Configure a new webhook endpoint for event notifications</p>
        </div>
    </div>

    @if($errors->any())
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-4 py-3 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.webhooks.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Webhook Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="e.g., Stripe Payment Notifications">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="provider" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Provider</label>
                    <select name="provider" id="provider" required
                            x-model="selectedProvider"
                            @change="updateEventTypes()"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select a provider</option>
                        <option value="stripe" {{ old('provider') == 'stripe' ? 'selected' : '' }}>Stripe</option>
                        <option value="facebook" {{ old('provider') == 'facebook' ? 'selected' : '' }}>Facebook</option>
                        <option value="linkedin" {{ old('provider') == 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                        <option value="n8n" {{ old('provider') == 'n8n' ? 'selected' : '' }}>n8n</option>
                        <option value="custom" {{ old('provider') == 'custom' ? 'selected' : '' }}>Custom</option>
                    </select>
                    @error('provider')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="event_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Event Type</label>
                    <select name="event_type" id="event_type" required
                            x-model="selectedEventType"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select event type</option>
                        <template x-for="(label, value) in eventTypes[selectedProvider] || {}" :key="value">
                            <option :value="value" x-text="label"></option>
                        </template>
                    </select>
                    @error('event_type')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="endpoint_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Endpoint URL</label>
                    <input type="url" name="endpoint_url" id="endpoint_url" value="{{ old('endpoint_url') }}" required
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="https://your-domain.com/webhook">
                    @error('endpoint_url')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <div>
                    <label for="secret" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Webhook Secret
                        <span class="text-gray-400 font-normal">(Optional - will be auto-generated if empty)</span>
                    </label>
                    <div class="mt-1 relative">
                        <input :type="showSecret ? 'text' : 'password'" name="secret" id="secret" value="{{ old('secret') }}"
                            class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pr-10"
                            placeholder="Leave empty to auto-generate">
                        <button type="button" @click="showSecret = !showSecret" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg x-show="!showSecret" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showSecret" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('secret')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        This secret is used to verify webhook requests. Keep it secure and never share it publicly.
                    </p>
                </div>
            </div>

            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <div class="flex items-center">
                    <input type="checkbox" name="active" id="active" value="1" checked
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded">
                    <label for="active" class="ml-2 block text-sm text-gray-900 dark:text-white">
                        Active
                        <span class="text-gray-500 dark:text-gray-400 font-normal">- Enable this webhook to receive events</span>
                    </label>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.webhooks.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    Create Webhook
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function webhookForm() {
    return {
        selectedProvider: '{{ old('provider', '') }}',
        selectedEventType: '{{ old('event_type', '') }}',
        showSecret: false,
        eventTypes: @json($eventTypes),

        updateEventTypes() {
            this.selectedEventType = '';
        }
    }
}
</script>
@endsection
