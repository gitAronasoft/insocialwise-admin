@props(['status', 'size' => 'sm'])

@php
    $statusColors = [
        'active' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
        'success' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
        'completed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
        'processing' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
        'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
        'critical' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
        'failed' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
        'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
        'inactive' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
        'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
        'expired' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
        'expiring' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400',
    ];
    
    $colorClass = $statusColors[strtolower($status)] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
    $sizeClass = $size === 'xs' ? 'text-xs px-2 py-0.5' : ($size === 'lg' ? 'text-base px-4 py-1.5' : 'text-sm px-2.5 py-0.5');
@endphp

<span class="inline-flex items-center rounded-full font-medium {{ $colorClass }} {{ $sizeClass }}">
    {{ ucfirst($status) }}
</span>
