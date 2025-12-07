@props([
    'status',
    'size' => 'sm',
    'pulse' => false,
])

@php
    $statusConfig = [
        'active' => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-800 dark:text-green-400', 'dot' => 'bg-green-500'],
        'success' => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-800 dark:text-green-400', 'dot' => 'bg-green-500'],
        'paid' => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-800 dark:text-green-400', 'dot' => 'bg-green-500'],
        'trialing' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-800 dark:text-blue-400', 'dot' => 'bg-blue-500'],
        'pending' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-800 dark:text-yellow-400', 'dot' => 'bg-yellow-500'],
        'processing' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-800 dark:text-yellow-400', 'dot' => 'bg-yellow-500'],
        'past_due' => ['bg' => 'bg-orange-100 dark:bg-orange-900/30', 'text' => 'text-orange-800 dark:text-orange-400', 'dot' => 'bg-orange-500'],
        'canceled' => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-800 dark:text-red-400', 'dot' => 'bg-red-500'],
        'failed' => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-800 dark:text-red-400', 'dot' => 'bg-red-500'],
        'expired' => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-800 dark:text-red-400', 'dot' => 'bg-red-500'],
        'inactive' => ['bg' => 'bg-gray-100 dark:bg-gray-700', 'text' => 'text-gray-800 dark:text-gray-300', 'dot' => 'bg-gray-500'],
        'default' => ['bg' => 'bg-indigo-100 dark:bg-indigo-900/30', 'text' => 'text-indigo-800 dark:text-indigo-400', 'dot' => 'bg-indigo-500'],
    ];
    
    $config = $statusConfig[strtolower($status)] ?? $statusConfig['inactive'];
    
    $sizeClasses = [
        'xs' => 'px-1.5 py-0.5 text-xs',
        'sm' => 'px-2 py-1 text-xs',
        'md' => 'px-2.5 py-1.5 text-sm',
        'lg' => 'px-3 py-2 text-sm',
    ];
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['sm'];
    
    $displayStatus = ucfirst(str_replace('_', ' ', $status));
@endphp

<span {{ $attributes->merge(['class' => "{$sizeClass} inline-flex items-center leading-5 font-semibold rounded-full {$config['bg']} {$config['text']}"]) }}>
    @if($pulse)
    <span class="relative flex h-2 w-2 mr-1.5">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $config['dot'] }} opacity-75"></span>
        <span class="relative inline-flex rounded-full h-2 w-2 {{ $config['dot'] }}"></span>
    </span>
    @endif
    {{ $displayStatus }}
</span>
