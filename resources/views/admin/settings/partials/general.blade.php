<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">General Settings</h2>
            <p class="text-sm text-gray-600">Configure general application settings</p>
        </div>
        <a href="{{ route('admin.settings.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
            Add Setting
        </a>
    </div>

    @php
        $generalSettings = $settings->filter(fn($s) => $s->group === 'general');
    @endphp

    @if($generalSettings->count() > 0)
    <div class="space-y-4">
        @foreach($generalSettings as $setting)
        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
            <div class="flex-1">
                <p class="font-medium text-gray-900">{{ $setting->key }}</p>
                <p class="text-sm text-gray-600">{{ $setting->description ?? 'No description' }}</p>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-700 max-w-xs truncate">{{ Str::limit($setting->value, 30) }}</span>
                <a href="{{ route('admin.settings.edit', $setting) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Edit</a>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-8 text-gray-500">
        <p>No general settings configured yet.</p>
        <a href="{{ route('admin.settings.create') }}" class="text-indigo-600 hover:text-indigo-800 mt-2 inline-block">Add your first setting</a>
    </div>
    @endif
</div>
