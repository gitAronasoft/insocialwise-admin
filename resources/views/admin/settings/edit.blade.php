@extends('admin.layouts.app')
@use('App\Helpers\DateHelper')

@section('title', 'Edit System Setting')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Settings', 'url' => route('admin.settings.index')], ['label' => 'Edit', 'url' => null]
    ]" />
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900">Edit Setting: {{ $setting->key }}</h3>
        <a href="{{ route('admin.settings.index') }}" class="text-indigo-600 hover:text-indigo-900">Back to Settings</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 pb-6 border-b border-gray-200">
            <div>
                <p class="text-sm font-medium text-gray-500">Group</p>
                <p class="text-lg font-semibold text-gray-900">{{ ucfirst($setting->group) }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Type</p>
                <p class="text-lg font-semibold text-gray-900">{{ ucfirst($setting->type) }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Created</p>
                <p class="text-sm text-gray-900">{{ DateHelper::formatDateTime($setting->created_at) }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Updated</p>
                <p class="text-sm text-gray-900">{{ DateHelper::formatDateTime($setting->updated_at) }}</p>
            </div>
        </div>

        <form action="{{ route('admin.settings.update', $setting) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Value</label>
                    <textarea name="value" rows="6" placeholder="Enter the setting value" required
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $setting->value }}</textarea>
                    @error('value')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">Type</label>
                        <select name="type" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach($types as $type)
                                <option value="{{ $type }}" {{ $setting->type === $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                        @error('type')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">Section (Optional)</label>
                        <input type="text" name="section" value="{{ $setting->section }}" placeholder="e.g., SMTP Configuration"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">Description</label>
                <input type="text" name="description" value="{{ $setting->description }}" placeholder="What is this setting for?"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('description')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>

            <div class="flex space-x-3 pt-6">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Update Setting</button>
                <a href="{{ route('admin.settings.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
