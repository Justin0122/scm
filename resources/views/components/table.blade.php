@props(['results', 'type', 'create' => false])
<div class="mx-4">
    <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-800 dark:text-gray-200">
        <thead>
        <tr>
            @foreach ($results->first()->getFillable() as $field)
                <th class="px-4 py-2 text-left">{{ ucfirst($field) }}</th>
            @endforeach
            <th class="px-4 py-2 text-left">Created At</th>
            <th class="px-4 py-2 text-left">Updated At</th>
            <th class="px-4 py-2 text-left">Deleted At</th>
            <th class="px-4 py-2 text-left">Actions</th>
        </tr>
        </thead>
        <tbody>
        @if ($create)
            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                <form wire:submit.prevent="create">
                    @foreach($results[0]->getFillable() as $fillable)
                        <td class="py-2 px-4">
                            <label for="{{ $results[0]->$fillable ?? $fillable }}"></label>
                            <x-input
                                type="text"
                                class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                                wire:model="form.{{ $fillable }}"
                            />
                        </td>
                    @endforeach

                    <td class="py-2 px-4 grid grid-cols-2 gap-2"></td>
                    <td class="py-2 px-4"></td>
                    <td></td>
                    <td class="py-2 px-4">
                        <x-button>Add</x-button>
                    </td>
                </form>
            </tr>
        @endif
        @foreach ($results as $result)
            <tr class="{{ $loop->odd ? 'bg-gray-50 dark:bg-gray-900' : '' }}">
                @foreach ($result->getFillable() as $field)
                    <td class="py-2 px-4">
                        {{ $result->$field }}
                    </td>
                @endforeach
                <td class="py-2 px-4">
                    {{ $result->created_at }}
                </td>
                <td class="py-2 px-4">
                    {{ $result->updated_at }}
                </td>
                <td class="py-2 px-4">
                    {{ $result->deleted_at }}
                </td>
                <td class="py-2 px-4">
                    <div class="flex">
                        <a href="{{'?type=' . $type . '&id=' . $result->id}}" class="mr-2">
                            <x-secondary-button>
                                Edit
                            </x-secondary-button>
                        </a>
                        @if ($result->deleted_at)
                            <x-button wire:click="restore({{ $result->id }})">
                                Restore
                            </x-button>
                            <x-danger-button wire:click="forceDelete({{ $result->id }})" wire:confirm="Are you sure you want to force delete {{ ucwords(join(' ', preg_split('/(?=[A-Z])/', $type))) }} {{ $result->key ?? $result->name }}?">
                                Force Delete
                            </x-danger-button>
                        @else
                        <x-danger-button wire:click="delete({{ $result->id }})">
                        Delete
                        </x-danger-button>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach

        @if ($results->count() == 0)
            <tr>
                <td colspan="4" class="py-2 text-center">No products found.</td>
            </tr>
        @endif
        </tbody>
    </table>

    <!-- Pagination links -->
    <div class="p-4">
        {{ $results->links() }}
    </div>
</div>
