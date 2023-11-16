<div class="">
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
                    <option
                        value="{{ $auditableType }}">{{ ucwords(join(' ', preg_split('/(?=[A-Z])/', $auditableType))) }}
                    </option>
                @endforeach
            </select>
            <label class="w-full block text-sm font-medium text-gray-900 dark:text-gray-400"
                   for="search">
                <input wire:model.live="search" type="text"
                       class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                       placeholder="Search values...">
            </label>

            <x-select-per-page/>
            <x-button wire:click="clearFilters">
                Clear Filters
            </x-button>
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
            <th class="px-4 py-2 text-left">Old Values</th>
            <th class="px-4 py-2 text-left">New Values</th>
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
                    <button wire:click="$set('selectedUser', '{{ $result->user_id }}')"
                            class="flex items-center gap-2 hover:text-blue-500">
                        <img class="h-8 w-8 rounded-full object-cover"
                             src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"/>
                        {{ $result->user->name ?? 'Unknown' }}
                    </button>
                </td>
                <td class="py-2 px-4">
                    <button wire:click="$set('selectedEvent', '{{ $result->event }}')">
                        @if ($result->event == 'deleted')
                            <x-badge type="danger" :text="$result->event"/>
                        @elseif ($result->event == 'restored')
                            <x-badge type="info" :text="$result->event"/>
                        @elseif ($result->event == 'updated')
                            <x-badge type="warning" :text="$result->event"/>
                        @else
                            <x-badge type="success" :text="$result->event"/>
                        @endif
                    </button>
                </td>
                <td class="py-2 px-4">
                    @php $auditableType = ucwords(join('', preg_split('/(?=[A-Z])/', Str::after($result->auditable_type, 'App\Models\\')))); @endphp
                    <button wire:click="$set('selectedAuditableType', '{{  $auditableType }}')">
                        <x-badge type="light" :text="$auditableType"/>
                    </button>
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
                            <div wire:click="$set('search', '{{ $value }}')" class="cursor-pointer {{ strtolower($search) == strtolower($value) ? 'text-yellow-200' : '' }}">
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
                            <div wire:click="$set('search', '{{ $value }}')" class="cursor-pointer {{ strtolower($search) == strtolower($value) ? 'text-yellow-200' : '' }}">
                                {{ $value }}
                            </div>
                        </div>
                    @endforeach
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
