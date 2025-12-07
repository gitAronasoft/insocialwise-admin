@props([
    'type' => 'text',
    'lines' => 1,
    'width' => 'full',
])

@php
    $widthClasses = [
        'xs' => 'w-12',
        'sm' => 'w-24',
        'md' => 'w-32',
        'lg' => 'w-48',
        'xl' => 'w-64',
        'full' => 'w-full',
        '1/2' => 'w-1/2',
        '1/3' => 'w-1/3',
        '2/3' => 'w-2/3',
        '1/4' => 'w-1/4',
        '3/4' => 'w-3/4',
    ];
    $widthClass = $widthClasses[$width] ?? 'w-full';
@endphp

@if($type === 'card')
<div {{ $attributes->merge(['class' => 'animate-pulse']) }}>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div class="space-y-3 flex-1">
                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-24"></div>
                <div class="h-8 bg-gray-200 dark:bg-gray-700 rounded w-32"></div>
                <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded w-20"></div>
            </div>
            <div class="w-12 h-12 bg-gray-200 dark:bg-gray-700 rounded-xl"></div>
        </div>
    </div>
</div>

@elseif($type === 'table-row')
<tr class="animate-pulse">
    @for($i = 0; $i < 5; $i++)
    <td class="px-4 py-4">
        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded {{ $i === 0 ? 'w-32' : ($i === 4 ? 'w-16' : 'w-24') }}"></div>
    </td>
    @endfor
</tr>

@elseif($type === 'avatar')
<div {{ $attributes->merge(['class' => 'animate-pulse flex items-center space-x-3']) }}>
    <div class="w-10 h-10 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
    <div class="space-y-2">
        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-24"></div>
        <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded w-32"></div>
    </div>
</div>

@elseif($type === 'chart')
<div {{ $attributes->merge(['class' => 'animate-pulse']) }}>
    <div class="h-64 bg-gray-200 dark:bg-gray-700 rounded-lg"></div>
</div>

@else
<div {{ $attributes->merge(['class' => 'animate-pulse space-y-2']) }}>
    @for($i = 0; $i < $lines; $i++)
    <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded {{ $widthClass }} {{ $i === $lines - 1 && $lines > 1 ? 'w-3/4' : '' }}"></div>
    @endfor
</div>
@endif
