<div class="edit flex flex-col p-4 bg-white shadow-md rounded-lg dark:bg-gray-800">
    <form wire:submit.prevent="update" class="space-y-4">
        @foreach($fillables as $fillable)
            <div class="flex flex-col">
                <label for="{{ $results->$fillable }}" class="text-sm font-semibold text-gray-600">
                    {{ ucfirst($fillable) }}
                </label>
                <x-input
                    type="text"
                    class="py-2 px-3 border rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                    placeholder="{{ $results->$fillable }}"
                    wire:model="form.{{ $fillable }}"
                />
            </div>
        @endforeach
        <button type="submit"
                class="py-2 px-4 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300">
            Submit
        </button>
    </form>
    <x-danger-button wire:click="delete({{ $results->id }})"
                     class="mt-4 py-2 px-4 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300"
                     wire:confirm="Are you sure you want to delete this size group?">
        Delete
    </x-danger-button>
    <x-section-border />

    <p class="text-sm font-semibold text-gray-600">
        Create and assign a size
    </p>
    @include('livewire.Size.create')
<x-section-border />
    <div class="mb-4">
        <label class="text-sm font-semibold text-gray-600">Filter Unassigned Sizes:</label>
        <select wire:model.live="sortUnassignedSizes" class="py-2 px-3 border rounded-lg focus:outline-none focus:ring focus:border-blue-300 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-700">
            <option value="all">All Sizes</option>
            <option value="integer">Integer Sizes Only</option>
            <option value="string">String Sizes Only</option>
        </select>
    </div>

@if ($results->sizes->count() == 0)
        <p class="text-sm font-semibold text-gray-600">
            No sizes assigned to this group
        </p>
    @else
        <p class="text-sm font-semibold text-gray-600">
            Sizes assigned to this group
        </p>

        <ul class="text-sm font-semibold text-gray-600">
            @foreach ($results->sizes as $size)
                <li class="flex justify-between items-center w-full px-4 py-2 border-b border-gray-200 hover:bg-gray-100 transition duration-300 ease-in-out dark:hover:bg-gray-700 dark:text-gray-300 dark:border-gray-700">
                    <span>{{ $size->key }}</span>
                    <x-danger-button wire:click="removeSize({{ $size->id }})">Unassign</x-danger-button>
                </li>
            @endforeach
        </ul>
    @endif
    <input type="text" wire:model.live="searchUnassignedSizes" placeholder="Search Sizes"
           class="py-2 px-3 border rounded-lg focus:outline-none focus:ring focus:border-blue-300 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-700">
    @if ($sizes->count() == 0)
        <p class="text-sm font-semibold text-gray-600">
            No sizes available to assign
        </p>
    @else

        <ul class="text-sm font-semibold text-gray-600">
            @foreach ($sizes as $size)
                @unless($results->sizes->contains($size->id))
                    <li class="flex justify-between items-center w-full px-4 py-2 border-b border-gray-200 hover:bg-gray-100 transition duration-300 ease-in-out dark:hover:bg-gray-700 dark:text-gray-300 dark:border-gray-700">
                        <span>{{ $size->key }}</span>
                        <x-secondary-button wire:click="assignSize({{ $size->id }})">Assign</x-secondary-button>
                    </li>
                @endunless
            @endforeach
        </ul>
    @endif
</div>

