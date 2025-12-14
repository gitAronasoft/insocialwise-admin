<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">All Settings</h2>
            <p class="text-sm text-gray-600">View and manage all system settings in table format</p>
        </div>
        <a href="{{ route('admin.settings.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
            New Setting
        </a>
    </div>

    <form action="{{ route('admin.settings.index') }}" method="GET" class="flex flex-wrap gap-4 mb-6">
        <input type="hidden" name="tab" value="all">
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search settings..." 
                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        <div>
            <select name="group" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                <tr class="border-b border-gray-200">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Key</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Value</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Group</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($settings as $setting)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="px-6 py-4 font-mono text-gray-900">{{ $setting->key }}</td>
                        <td class="px-6 py-4 text-gray-700 max-w-xs truncate">
                            @if($setting->type === 'encrypted')
                                <span class="text-gray-400">••••••••</span>
                            @elseif($setting->type === 'boolean')
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $setting->value ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $setting->value ? 'True' : 'False' }}
                                </span>
                            @else
                                {{ Str::limit($setting->value, 40) }}
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                {{ $setting->type }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                @if($setting->group === 'general') bg-blue-100 text-blue-800
                                @elseif($setting->group === 'email') bg-green-100 text-green-800
                                @elseif($setting->group === 'payment' || $setting->group === 'stripe') bg-orange-100 text-orange-800
                                @elseif($setting->group === 'api') bg-purple-100 text-purple-800
                                @else bg-gray-100 text-gray-800
                                @endif
                            ">{{ ucfirst($setting->group) }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex space-x-3">
                                <a href="{{ route('admin.settings.edit', $setting) }}" class="text-indigo-600 hover:text-indigo-800">Edit</a>
                                <form action="{{ route('admin.settings.destroy', $setting) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            No settings found. <a href="{{ route('admin.settings.create') }}" class="text-indigo-600 hover:text-indigo-800">Create one</a>
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
