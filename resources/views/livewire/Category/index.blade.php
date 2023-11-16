<div class="container mx-auto px-4">
    @if($this->id)
        @include('livewire.crud.edit')
    @else
        <div class="flex row-auto gap-2">
            <label class="w-full block text-sm font-medium text-gray-900 dark:text-gray-400"
                   for="search">
                <input wire:model.live="search" type="text"
                       class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                       placeholder="Search...">
            </label>
            <label class="text-sm font-medium text-gray-900 dark:text-gray-400 flex items-center">
                <input wire:model.live="showDeleted" type="checkbox"
                       class="rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 mr-2">
                Show Deleted
            </label>
            <x-select-per-page/>
            <x-button wire:click="clearFilters">

                Clear Filters
            </x-button>
        </div>        {{ $results->links() }}
        <div class="mt-4">
            <x-table :results="$results" :type="'color'" :create="true" :fillables="$fillables"/>
        </div>
    @endif
</div>
