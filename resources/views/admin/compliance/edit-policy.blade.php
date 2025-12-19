@extends('admin.layouts.app')
@use('App\Helpers\DateHelper')

@section('title', 'Edit Policy')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Compliance', 'url' => null], ['label' => 'Edit Policy', 'url' => null]
    ]" />
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Policy</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ str_replace('_', ' ', ucfirst($policy->policy_type)) }}</p>
        </div>
        <a href="{{ route('admin.compliance.policies') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">Back to Policies</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.compliance.policies.update', $policy) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Policy Content</label>
                <textarea name="content" rows="20" required
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono text-sm"
                    placeholder="Enter the policy content...">{{ old('content', $policy->content) }}</textarea>
                @error('content')<span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span>@enderror
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">You can use HTML formatting for rich content.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Version</label>
                    <input type="text" name="version" value="{{ old('version', $policy->version) }}" required
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="e.g., 1.0, 2.1">
                    @error('version')<span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Effective Date</label>
                    <input type="date" name="effective_date" value="{{ old('effective_date', \Carbon\Carbon::parse($policy->effective_date)->format('Y-m-d')) }}" required
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('effective_date')<span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="active" id="active" value="1" {{ old('active', $policy->active) ? 'checked' : '' }}
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded">
                <label for="active" class="ml-2 block text-sm text-gray-900 dark:text-white">
                    Active
                </label>
                <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">(Only active policies are displayed to users)</span>
            </div>

            <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Last updated: {{ DateHelper::formatDateTime($policy->updated_at) }}
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.compliance.policies') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600">Cancel</a>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Update Policy</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
