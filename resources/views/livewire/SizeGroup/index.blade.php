<div class="container mx-auto px-4">
    @if($this->id)
        @include('livewire.SizeGroup.edit')
    @else
        <div class="flex row-auto gap-2">
            <label class="w-full block text-sm font-medium text-gray-900 dark:text-gray-400"
                   for="search">
                <input wire:model.live="search" type="text"
                       class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                       placeholder="Search...">
            </label>
            <x-select-per-page/>
        </div>
        {{ $results->links() }}
        <div class="mt-4">
            <x-table :results="$results" :type="'sizeGroup'" :create="true" :fillables="$fillables"/>
        </div>
    @endif
</div>
