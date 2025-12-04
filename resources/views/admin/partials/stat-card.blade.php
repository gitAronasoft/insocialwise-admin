@props(['title', 'value', 'icon' => null, 'color' => 'primary', 'change' => null, 'changeType' => 'up', 'link' => null])

<div class="card p-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $title }}</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $value }}</p>
            @if($change)
                <p class="text-sm mt-2 flex items-center 
                    {{ $changeType === 'up' ? 'text-green-600' : ($changeType === 'down' ? 'text-red-600' : 'text-gray-500') }}">
                    @if($changeType === 'up')
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                        </svg>
                    @elseif($changeType === 'down')
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        </svg>
                    @endif
                    {{ $change }}
                </p>
            @endif
        </div>
        @if($icon)
        <div class="w-12 h-12 rounded-xl bg-{{ $color }}-100 dark:bg-{{ $color }}-900/30 flex items-center justify-center">
            {!! $icon !!}
        </div>
        @endif
    </div>
    @if($link)
    <a href="{{ $link }}" class="text-sm text-{{ $color }}-600 hover:text-{{ $color }}-700 dark:text-{{ $color }}-400 mt-3 inline-flex items-center">
        View details
        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </a>
    @endif
</div>
