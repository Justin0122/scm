<div class="container px-4 pt-10 mx-auto sm:px-6 lg:px-8 dark:text-gray-200">
    <div class="mb-4">
        <div class="flex row-auto gap-2">
            <select wire:model.live="selectedUser"
                    class="rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                <option value="">All Users</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>

            <select wire:model.live="selectedEvent"
                    class="rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                <option value="">All Events</option>
                @php $events = ['created', 'updated', 'restored', 'deleted']; @endphp
                @foreach ($events as $event)
                    <option value="{{ $event }}">{{ $event }}</option>
                @endforeach
            </select>
            <select wire:model.live="selectedAuditableType"
                    class="rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                <option value="">All Auditable Types</option>
                @foreach ($auditableTypes as $auditableType)
                    <option value="{{ $auditableType }}">{{ ucwords(join(' ', preg_split('/(?=[A-Z])/', $auditableType))) }}
                    </option>
                @endforeach
            </select>
            <label class="w-full block text-sm font-medium text-gray-900 dark:text-gray-400"
                   for="search">
                <input wire:model.live="search" type="text"
                       class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                       placeholder="Search values...">
            </label>

            <select wire:model.live="perPage"
                    class="rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                @foreach ([10, 20, 50, 100] as $value)
                    <option value="{{ $value }}">{{ $value }} per page</option>
                @endforeach
            </select>

            <x-danger-button wire:click="clearFilters">
                Clear Filters
            </x-danger-button>
        </div>
    </div>
    <div class="p-4">
        {{ $results->links() }}
    </div>
    <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-800 dark:text-gray-200">
        <thead>
        <tr>
            <th class="px-4 py-2 text-left">
                <button wire:click="sort('user_id')">
                    User
                    @if ($sortField === 'user_id')
                        <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                    @endif</button>
            </th>
            <th class="px-4 py-2 text-left">
                <button wire:click="sort('event')">
                    Event
                    @if ($sortField === 'event')
                        <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                    @endif</button>
            </th>
            <th class="px-4 py-2 text-left">
                <button wire:click="sort('auditable_type')">
                    Auditable Type
                    @if ($sortField === 'auditable_type')
                        <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                    @endif</button>
            </th>
            <th class="px-4 py-2 text-left">
                <button wire:click="sort('auditable_id')">
                    Auditable ID
                    @if ($sortField === 'auditable_id')
                        <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                    @endif</button>
            </th>
            <th class="px-4 py-2 text-left">Old Values</th>
            <th class="px-4 py-2 text-left">New Values</th>
            <th class="px-4 py-2 text-left">
                <button wire:click="sort('ip_address')">
                    IP Address
                    @if ($sortField === 'ip_address')
                        <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                    @endif</button>
            </th>
            <th class="px-4 py-2 text-left">
                <button wire:click="sort('user_agent')">
                    User Agent
                    @if ($sortField === 'user_agent')
                        <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                    @endif</button>
            </th>
            <th class="px-4 py-2 text-left">
                <button wire:click="sort('created_at')">
                    Created At
                    @if ($sortField === 'created_at')
                        <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                    @endif</button>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($results as $result)
            <tr class="{{ $loop->odd ? 'bg-gray-50 dark:bg-gray-900' : '' }}">
                <td class="py-2 px-4">
                    <button wire:click="$set('selectedUser', '{{ $result->user_id }}')">
                        {{ $result->user->name ?? 'Unknown' }}
                    </button>
                </td>
                <td class="py-2 px-4">
                    <button wire:click="$set('selectedEvent', '{{ $result->event }}')">
                        {{ $result->event }}
                    </button>
                </td>
                <td class="py-2 px-4">
                    {{ ucwords(join(' ', preg_split('/(?=[A-Z])/', Str::after($result->auditable_type, 'App\Models\\')))) }}

                </td>
                <td class="py-2 px-4">
                    {{ $result->auditable_id }}
                </td>
                <td class="py-2 px-4">
                    @foreach ($result->old_values as $key => $value)
                        @if ($key == 'password')
                            {{ $key }}: {{ '********' }}
                            @continue
                        @endif
                        <div class="flex">
                            <div class="mr-2">
                                {{ $key }}:
                            </div>
                            <div class="truncate w-64">
                                {{ $value }}
                            </div>
                        </div>
                    @endforeach
                </td>
                <td class="py-2 px-4">
                    @foreach ($result->new_values as $key => $value)
                        @if ($key == 'password')
                            {{ $key }}: {{ '********' }}
                            @continue
                        @endif
                        <div class="flex">
                            <div class="mr-2">
                                {{ $key }}:
                            </div>
                            <div class="truncate w-64">
                                {{ $value }}
                            </div>
                        </div>
                    @endforeach
                </td>
                <td class="py-2 px-4">
                    <button wire:click="$set('ipAddressFilter', '{{ $result->ip_address }}')">
                        {{ $result->ip_address }}
                    </button>
                </td>
                <td class="py-2 px-4">
                    {{ $result->user_agent }}
                </td>
                <td class="py-2 px-4">
                    {{ $result->created_at }}
                </td>
            </tr>
        @endforeach

        @if ($results->count() == 0)
            <tr>
                <td colspan="4" class="py-2 text-center">No results found</td>
            </tr>
        @endif
        </tbody>
    </table>
    <div class="p-5">
        {{ $results->links() }}
    </div>
</div>
