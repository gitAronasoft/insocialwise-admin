@props([
    'title',
    'value',
    'subtitle' => null,
    'icon' => null,
    'color' => 'indigo',
    'trend' => null,
    'trendValue' => null,
    'trendLabel' => null,
    'link' => null,
    'border' => true,
])

@php
    $colorClasses = [
        'green' => [
            'border' => 'border-l-4 border-green-500',
            'icon_bg' => 'from-green-100 to-green-200 dark:from-green-900/50 dark:to-green-800/50',
            'icon_text' => 'text-green-600 dark:text-green-400',
            'link' => 'text-green-600 hover:text-green-700 dark:text-green-400',
        ],
        'blue' => [
            'border' => 'border-l-4 border-blue-500',
            'icon_bg' => 'from-blue-100 to-blue-200 dark:from-blue-900/50 dark:to-blue-800/50',
            'icon_text' => 'text-blue-600 dark:text-blue-400',
            'link' => 'text-blue-600 hover:text-blue-700 dark:text-blue-400',
        ],
        'indigo' => [
            'border' => 'border-l-4 border-indigo-500',
            'icon_bg' => 'from-indigo-100 to-indigo-200 dark:from-indigo-900/50 dark:to-indigo-800/50',
            'icon_text' => 'text-indigo-600 dark:text-indigo-400',
            'link' => 'text-indigo-600 hover:text-indigo-700 dark:text-indigo-400',
        ],
        'purple' => [
            'border' => 'border-l-4 border-purple-500',
            'icon_bg' => 'from-purple-100 to-purple-200 dark:from-purple-900/50 dark:to-purple-800/50',
            'icon_text' => 'text-purple-600 dark:text-purple-400',
            'link' => 'text-purple-600 hover:text-purple-700 dark:text-purple-400',
        ],
        'red' => [
            'border' => 'border-l-4 border-red-500',
            'icon_bg' => 'from-red-100 to-red-200 dark:from-red-900/50 dark:to-red-800/50',
            'icon_text' => 'text-red-600 dark:text-red-400',
            'link' => 'text-red-600 hover:text-red-700 dark:text-red-400',
        ],
        'amber' => [
            'border' => 'border-l-4 border-amber-500',
            'icon_bg' => 'from-amber-100 to-amber-200 dark:from-amber-900/50 dark:to-amber-800/50',
            'icon_text' => 'text-amber-600 dark:text-amber-400',
            'link' => 'text-amber-600 hover:text-amber-700 dark:text-amber-400',
        ],
        'yellow' => [
            'border' => 'border-l-4 border-yellow-500',
            'icon_bg' => 'from-yellow-100 to-yellow-200 dark:from-yellow-900/50 dark:to-yellow-800/50',
            'icon_text' => 'text-yellow-600 dark:text-yellow-400',
            'link' => 'text-yellow-600 hover:text-yellow-700 dark:text-yellow-400',
        ],
        'cyan' => [
            'border' => 'border-l-4 border-cyan-500',
            'icon_bg' => 'from-cyan-100 to-cyan-200 dark:from-cyan-900/50 dark:to-cyan-800/50',
            'icon_text' => 'text-cyan-600 dark:text-cyan-400',
            'link' => 'text-cyan-600 hover:text-cyan-700 dark:text-cyan-400',
        ],
        'gray' => [
            'border' => 'border-l-4 border-gray-500',
            'icon_bg' => 'from-gray-100 to-gray-200 dark:from-gray-700/50 dark:to-gray-600/50',
            'icon_text' => 'text-gray-600 dark:text-gray-400',
            'link' => 'text-gray-600 hover:text-gray-700 dark:text-gray-400',
        ],
    ];
    $colors = $colorClasses[$color] ?? $colorClasses['indigo'];
@endphp

<div {{ $attributes->merge([
    'class' => 'bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 transition-all duration-200 hover:shadow-md ' . 
               ($border ? $colors['border'] : 'border border-gray-200 dark:border-gray-700') .
               ($link ? ' cursor-pointer hover:-translate-y-0.5' : '')
]) }}
@if($link) onclick="window.location='{{ $link }}'" @endif
>
    <div class="flex items-center justify-between">
        <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ $title }}</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $value }}</p>
            
            @if($trend || $trendValue)
            <div class="mt-2 flex items-center text-sm">
                @if($trend === 'up')
                    <span class="inline-flex items-center text-green-600 dark:text-green-400 font-medium">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        {{ $trendValue }}
                    </span>
                @elseif($trend === 'down')
                    <span class="inline-flex items-center text-red-600 dark:text-red-400 font-medium">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path>
                        </svg>
                        {{ $trendValue }}
                    </span>
                @elseif($trendValue)
                    <span class="inline-flex items-center text-gray-600 dark:text-gray-400 font-medium">
                        {{ $trendValue }}
                    </span>
                @endif
                @if($trendLabel)
                    <span class="text-gray-500 dark:text-gray-400 ml-2">{{ $trendLabel }}</span>
                @endif
            </div>
            @elseif($subtitle)
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">{{ $subtitle }}</p>
            @endif
        </div>
        
        @if($icon)
        <div class="p-3 bg-gradient-to-br {{ $colors['icon_bg'] }} rounded-xl flex-shrink-0 ml-4">
            <svg class="w-6 h-6 {{ $colors['icon_text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $icon !!}
            </svg>
        </div>
        @endif
    </div>
    
    {{ $slot }}
</div>
