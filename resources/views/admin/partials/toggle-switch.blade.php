@props(['id', 'name', 'checked' => false, 'disabled' => false, 'label' => null, 'description' => null])

<div class="flex items-center justify-between py-4 border-b border-gray-200 dark:border-gray-700 last:border-0">
    <div class="flex-1 min-w-0 mr-4">
        @if($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-gray-900 dark:text-white">{{ $label }}</label>
        @endif
        @if($description)
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">{{ $description }}</p>
        @endif
    </div>
    <label class="relative inline-flex items-center {{ $disabled ? 'cursor-not-allowed' : 'cursor-pointer' }}">
        <input type="checkbox" 
               id="{{ $id }}" 
               name="{{ $name }}" 
               class="sr-only peer"
               {{ $checked ? 'checked' : '' }}
               {{ $disabled ? 'disabled' : '' }}
               {{ $attributes }}>
        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600 {{ $disabled ? 'opacity-50' : '' }}"></div>
    </label>
</div>
