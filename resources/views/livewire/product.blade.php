<div class="max-w-md mt-8 p-6 bg-white rounded-md shadow-md dark:bg-gray-800 dark:text-gray-200">
    @if (isset($product))
        <h1 class="text-2xl font-bold mb-4">{{ $product->name }}</h1>
    @endif

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
            <label for="size" class="text-lg font-semibold mb-2">Size</label>
            <select wire:model="form.size" name="size" id="size"
                    class="border rounded-md p-2 mb-4 dark:bg-gray-700 dark:text-gray-200">
                <option value="">Select a size</option>
                @foreach($sizes as $size)
                    <option value="{{ $size->id }}">{{ $size->key }}</option>
                @endforeach
            </select>
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

    </form>
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
                <button wire:click="delete({{ $specification->id }})"
                        class="text-red-500 hover:text-red-700">Delete
                </button>
            </p>
            <p class="text- {{ $specification->stock > 5 ? 'text-green-500' : 'text-red-500'}}">
                Stock: <span class="font-bold">{{ $specification->stock }}</span>
            </p>
        </div>
    @endforeach
</div>
