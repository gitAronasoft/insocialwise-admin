@props([
    'title' => null,
    'subtitle' => null,
    'action' => null,
    'actionUrl' => null,
    'actionLabel' => 'View All',
    'noPadding' => false,
    'collapsible' => false,
    'defaultCollapsed' => false,
])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden']) }}
    @if($collapsible) x-data="{ collapsed: {{ $defaultCollapsed ? 'true' : 'false' }} }" @endif
>
    @if($title || $subtitle || $action || isset($header))
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
        <div>
            @if($title)
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                {{ $title }}
                @if($collapsible)
                <button @click="collapsed = !collapsed" class="ml-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <svg class="w-5 h-5 transform transition-transform" :class="{ 'rotate-180': !collapsed }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                @endif
            </h3>
            @endif
            @if($subtitle)
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">{{ $subtitle }}</p>
            @endif
        </div>
        
        <div class="flex items-center gap-3">
            @if(isset($header))
                {{ $header }}
            @endif
            
            @if($actionUrl)
            <a href="{{ $actionUrl }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors inline-flex items-center">
                {{ $actionLabel }}
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            @endif
        </div>
    </div>
    @endif
    
    <div @if($collapsible) x-show="!collapsed" x-collapse @endif class="{{ $noPadding ? '' : 'p-6' }}">
        {{ $slot }}
    </div>
    
    @if(isset($footer))
    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
        {{ $footer }}
    </div>
    @endif
</div>
