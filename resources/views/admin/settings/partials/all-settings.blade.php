<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">All Settings</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">View and manage all system settings in table format</p>
        </div>
        <a href="{{ route('admin.settings.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
            New Setting
        </a>
    </div>

    <form action="{{ route('admin.settings.index') }}" method="GET" class="flex flex-wrap gap-4 mb-6">
        <input type="hidden" name="tab" value="all">
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search settings..." 
                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        <div>
            <select name="group" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">All Groups</option>
                @foreach($groups as $group)
                    <option value="{{ $group }}" {{ request('group') === $group ? 'selected' : '' }}>{{ ucfirst($group) }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Search</button>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Key</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Value</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Group</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($settings as $setting)
                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 font-mono text-gray-900 dark:text-white">{{ $setting->key }}</td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300 max-w-xs truncate">
                            @if($setting->type === 'encrypted')
                                <span class="text-gray-400 dark:text-gray-500">••••••••</span>
                            @elseif($setting->type === 'boolean')
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $setting->value ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' : 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400' }}">
                                    {{ $setting->value ? 'True' : 'False' }}
                                </span>
                            @else
                                {{ Str::limit($setting->value, 40) }}
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                {{ $setting->type }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                @if($setting->group === 'general') bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400
                                @elseif($setting->group === 'email') bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400
                                @elseif($setting->group === 'payment' || $setting->group === 'stripe') bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-400
                                @elseif($setting->group === 'api') bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-400
                                @else bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300
                                @endif
                            ">{{ ucfirst($setting->group) }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex space-x-3">
                                <a href="{{ route('admin.settings.edit', $setting) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">Edit</a>
                                <form action="{{ route('admin.settings.destroy', $setting) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                            No settings found. <a href="{{ route('admin.settings.create') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">Create one</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($settings->hasPages())
    <div class="mt-4">
        {{ $settings->appends(['tab' => 'all'])->links() }}
    </div>
    @endif
</div>
