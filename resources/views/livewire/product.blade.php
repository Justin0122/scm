<div class="mt-8 p-6 bg-white rounded-md shadow-md dark:bg-gray-800 dark:text-gray-200">
    <x-section-title>
        <x-slot name="title">Add {{ $product->name ? $product->name : 'New Product' }}</x-slot>
        <x-slot name="description">Add a new {{ $product->name ? $product->name : 'product' }} to the system.</x-slot>
    </x-section-title>

    <form wire:submit.prevent`="create">
        @csrf
        <div class="flex flex-col">
            <label for="supplier" class="text-lg font-semibold mb-2">Supplier</label>
            <select wire:model="form.supplier" name="supplier" id="supplier"
                    class="border rounded-md p-2 mb-4 dark:bg-gray-700 dark:text-gray-200">
                <option value="">Select a supplier</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-col">
            <label for="size_group" class="text-lg font-semibold mb-2">Size Group</label>
            <select wire:model="form.size_group"
                    class="border rounded-md p-2 mb-4 dark:bg-gray-700 dark:text-gray-200">
                <option value="">Select Size Group</option>
                @foreach ($sizeGroups as $sizeGroup)
                    <option value="{{ $sizeGroup->id }}">{{ $sizeGroup->name }}</option>
                @endforeach
            </select>
            </label>
        </div>

        <div class="flex flex-col">
            <label for="color" class="text-lg font-semibold mb-2">Color</label>
            <select wire:model="form.color" name="color" id="color"
                    class="border rounded-md p-2 mb-4 dark:bg-gray-700 dark:text-gray-200">
                <option value="">Select a color</option>
                @foreach($colors as $color)
                    <option value="{{ $color->id }}">{{ $color->key }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-col">
            <label for="stock" class="text-lg font-semibold mb-2">Stock</label>
            <input wire:model="form.stock" type="number" name="stock" id="stock"
                   class="border rounded-md p-2 mb-4 dark:bg-gray-700 dark:text-gray-200">
        </div>

        <x-button>Save</x-button>
    </form>
    <x-section-border/>
    <div class="mb-4">
        <select wire:model.live="filter.supplier"
                class="py-2 px-3 border rounded-lg focus:outline-none focus:ring focus:border-blue-300 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-700">
            <option value="all">All suppliers</option>
            @foreach($filter_suppliers as $supplier)
                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
            @endforeach
        </select>
        <select wire:model.live="filter.color"
                class="py-2 px-3 border rounded-lg focus:outline-none focus:ring focus:border-blue-300 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-700">
            <option value="all">All Colors</option>
            @foreach($filter_colors as $color)
                <option value="{{ $color->id }}">{{ $color->key }}</option>
            @endforeach
        </select>

        <select wire:model.live="filter.size"
                class="py-2 px-3 border rounded-lg focus:outline-none focus:ring focus:border-blue-300 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-700">
            <option value="all">All Sizes</option>
            @foreach($filter_sizes as $size)
                <option value="{{ $size->id }}">{{ $size->key }}</option>
            @endforeach
        </select>

    </div>
    @if ($productSpecifications->count() == 0)
        <p class="text-sm font-semibold text-gray-600">
            Nothing found.
        </p>
    @endif
<div class="mx-4 grid grid-cols-2 gap-4">
    @foreach($productSpecifications as $specification)
        <div class="mb-4 border-b pb-4">
            <p class="text-lg font-semibold">
                @if (isset($specification->supplier))
                    <span class="text-purple-500">{{ $specification->supplier->name }}</span>
                @endif
                @if (isset($specification->size))
                    - <span class="text-blue-500">{{ $specification->size->key }}</span>
                @else
                    - <span class="text-blue-500">N/A</span>
                @endif
                @if (isset($specification->color))
                    - <span class="text-green-500">{{ $specification->color->key }}</span>
                @else
                    - <span class="text-blue-500">N/A</span>
                @endif
                <x-danger-button wire:click="delete({{ $specification->id }})">Delete</x-danger-button>
            </p>
            <p class="text- {{ $specification->stock > 5 ? 'text-green-500' : 'text-red-500'}}">
                Stock: <span class="font-bold">{{ $specification->stock }}</span>
            </p>
        </div>
    @endforeach
</div>

</div>
