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
            <select wire:model.live="sort"
                    class="py-2 px-3 border rounded-lg focus:outline-none focus:ring focus:border-blue-300 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-700">
                <option value="all">All Sizes</option>
                <option value="integer">Integer Sizes Only</option>
                <option value="string">String Sizes Only</option>
            </select>
            <label class="text-sm font-medium text-gray-900 dark:text-gray-400 flex items-center">
                <input wire:model.live="showDeleted" type="checkbox"
                       class="rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 mr-2">
                Show Deleted
            </label>
            <x-select-per-page/>
        </div>
        {{ $results->links() }}
        <div class="mt-4">
            <x-table :results="$results" :type="'size'" :create="true" :fillables="$fillables"/>
        </div>
    @endif
</div>
