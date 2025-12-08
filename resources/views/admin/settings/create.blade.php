@extends('admin.layouts.app')

@section('title', 'Create System Setting')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Settings', 'url' => route('admin.settings.index')], ['label' => 'Create New', 'url' => null]
    ]" />
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900">Add New System Setting</h3>
        <a href="{{ route('admin.settings.index') }}" class="text-indigo-600 hover:text-indigo-900">Back to Settings</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.settings.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Key</label>
                    <input type="text" name="key" value="{{ old('key') }}" required placeholder="e.g., SMTP_HOST"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('key')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Group</label>
                    <select name="group" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select a group...</option>
                        @foreach($groups as $group)
                            <option value="{{ $group }}" {{ old('group') === $group ? 'selected' : '' }}>
                                {{ ucfirst($group) }}
                            </option>
                        @endforeach
                    </select>
                    @error('group')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Type</label>
                    <select name="type" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach($types as $type)
                            <option value="{{ $type }}" {{ old('type') === $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                    @error('type')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Section (Optional)</label>
                    <input type="text" name="section" value="{{ old('section') }}" placeholder="e.g., SMTP Configuration"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">Value</label>
                <textarea name="value" rows="4" placeholder="Enter the setting value"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('value') }}</textarea>
                @error('value')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                <p class="mt-2 text-xs text-gray-500">For JSON type, enter valid JSON. For boolean, use 0 or 1.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">Description</label>
                <input type="text" name="description" value="{{ old('description') }}" placeholder="What is this setting for?"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('description')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>

            <div class="flex space-x-3 pt-6">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Create Setting</button>
                <a href="{{ route('admin.settings.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
