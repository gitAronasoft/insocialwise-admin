@extends('admin.layouts.app')

@section('title', 'Master Control Panel')

@section('content')
<div x-data="masterControl()" class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'System', 'url' => null],
        ['label' => 'Master Control', 'url' => null]
    ]" />

    <div x-show="toast.show" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-2"
         :class="toast.type === 'success' ? 'bg-green-500' : 'bg-red-500'"
         class="fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-medium flex items-center space-x-2">
        <template x-if="toast.type === 'success'">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </template>
        <template x-if="toast.type === 'error'">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </template>
        <span x-text="toast.message"></span>
    </div>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Master Control Panel</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage feature flags and system controls</p>
        </div>
        <button @click="seedFlags()" 
                :disabled="seeding"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
            <svg x-show="!seeding" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
            </svg>
            <svg x-show="seeding" class="w-5 h-5 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span x-text="seeding ? 'Seeding...' : 'Seed Default Flags'"></span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        @php
            $categoryOrder = ['core', 'admin', 'security', 'monitoring', 'data'];
        @endphp
        @foreach($categoryOrder as $category)
            @if(isset($categories[$category]))
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $categories[$category]['label'] }}</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ count($flagsByCategory[$category] ?? []) }}</p>
                </div>
            @endif
        @endforeach
    </div>

    <div class="space-y-4">
        @foreach($categoryOrder as $categoryKey)
            @if(isset($categories[$categoryKey]) && isset($flagsByCategory[$categoryKey]))
                @php
                    $category = $categories[$categoryKey];
                    $flags = $flagsByCategory[$categoryKey];
                @endphp
                <div x-data="{ open: true }" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                    <button @click="open = !open" 
                            class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <div class="flex items-center space-x-3">
                            @switch($category['icon'])
                                @case('cube')
                                    <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                    @break
                                @case('cog')
                                    <div class="p-2 bg-purple-100 dark:bg-purple-900 rounded-lg">
                                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    @break
                                @case('shield-check')
                                    <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    </div>
                                    @break
                                @case('chart-bar')
                                    <div class="p-2 bg-orange-100 dark:bg-orange-900 rounded-lg">
                                        <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                        </svg>
                                    </div>
                                    @break
                                @case('database')
                                    <div class="p-2 bg-cyan-100 dark:bg-cyan-900 rounded-lg">
                                        <svg class="w-5 h-5 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                                        </svg>
                                    </div>
                                    @break
                            @endswitch
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $category['label'] }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $category['description'] }}</p>
                            </div>
                        </div>
                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-2"
                         class="border-t border-gray-200 dark:border-gray-700">
                        <div class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($flags as $flag)
                                <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <div class="flex items-center space-x-4">
                                        @if($flag['force_enabled'])
                                            <div class="flex-shrink-0">
                                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" title="Force Enabled - Cannot be disabled">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <h4 class="font-medium text-gray-900 dark:text-white">{{ $flag['feature_name'] }}</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $flag['description'] ?? 'No description available' }}</p>
                                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                                Key: <code class="bg-gray-100 dark:bg-gray-700 px-1 rounded">{{ $flag['feature_key'] }}</code>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        @if($flag['force_enabled'])
                                            <span class="text-xs text-amber-600 dark:text-amber-400 font-medium">Force Enabled</span>
                                        @endif
                                        <label class="relative inline-flex items-center cursor-pointer {{ $flag['force_enabled'] ? 'opacity-50 cursor-not-allowed' : '' }}">
                                            <input type="checkbox" 
                                                   class="sr-only peer"
                                                   data-feature-key="{{ $flag['feature_key'] }}"
                                                   {{ $flag['enabled'] ? 'checked' : '' }}
                                                   {{ $flag['force_enabled'] ? 'disabled' : '' }}
                                                   @change="toggleFlag('{{ $flag['feature_key'] }}', $event.target.checked)">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-500 peer-checked:bg-indigo-600"></div>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

        @if(empty($flagsByCategory) || count($flagsByCategory) === 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No Feature Flags Found</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Get started by seeding the default feature flags.</p>
                <button @click="seedFlags()" 
                        :disabled="seeding"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 disabled:opacity-50 transition-colors">
                    <span x-text="seeding ? 'Seeding...' : 'Seed Default Flags'"></span>
                </button>
            </div>
        @endif
    </div>
</div>

<script>
function masterControl() {
    return {
        seeding: false,
        toast: {
            show: false,
            message: '',
            type: 'success'
        },

        showToast(message, type = 'success') {
            this.toast = { show: true, message, type };
            setTimeout(() => {
                this.toast.show = false;
            }, 3000);
        },

        async toggleFlag(featureKey, enabled) {
            try {
                const response = await fetch('{{ route('admin.master-control.toggle') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ feature_key: featureKey, enabled })
                });

                const data = await response.json();

                if (data.success) {
                    this.showToast(data.message, 'success');
                } else {
                    this.showToast(data.message || 'Failed to toggle feature', 'error');
                    const checkbox = document.querySelector(`input[data-feature-key="${featureKey}"]`);
                    if (checkbox) checkbox.checked = !enabled;
                }
            } catch (error) {
                this.showToast('An error occurred. Please try again.', 'error');
                const checkbox = document.querySelector(`input[data-feature-key="${featureKey}"]`);
                if (checkbox) checkbox.checked = !enabled;
            }
        },

        async seedFlags() {
            if (this.seeding) return;
            
            this.seeding = true;
            try {
                const response = await fetch('{{ route('admin.master-control.seed') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    this.showToast(data.message, 'success');
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    this.showToast(data.message || 'Failed to seed flags', 'error');
                }
            } catch (error) {
                this.showToast('An error occurred. Please try again.', 'error');
            } finally {
                this.seeding = false;
            }
        }
    }
}
</script>
@endsection
