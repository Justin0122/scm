<div class="mx-4">
    <div class="mb-4">
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400" for="search">
            <input wire:model.live="search" type="text"
                   class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                   placeholder="Search products...">
        </label>
    </div>
    @if ($products->count() >= 10)
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    @endif
    <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-800 dark:text-gray-200">
        <thead>
        <tr>
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">
                <label class="block">
                    <select wire:model.live="category"
                            class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </label>
            </th>
            <th class="px-4 py-2">Supplier</th>
            <th class="px-4 py-2">Specs</th>
            <th class="px-4 py-2">Stock</th>
            <th class="px-4 py-2 grid grid-cols-2">
                <label class="block">
                    <select wire:model.live="sortBy"
                            class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                        <option value="name">Name</option>
                        <option value="created_at">Created At</option>
                        <option value="updated_at">Updated At</option>
                        <option value="deleted_at">Deleted At</option>
                    </select>
                </label>

                <label class="block">
                    <select wire:model.live="sortDirection"
                            class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </label>
            </th>
            <th class="px-4 py-2">Actions</th>

        </tr>
        </thead>
        <tbody>
        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
            <form wire:submit.prevent="create">
                <td class="py-2 px-4">
                    <input wire:model="form.name" type="text" name="name" id="name"
                           class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                </td>
                <td class="py-2 px-4">
                    <label>
                        <select wire:model="form.category_id"
                                class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </label>
                </td>
                <td class="py-2 px-4">

                </td>
                <td class="py-2 px-4 grid grid-cols-2 gap-2">

                </td>
                <td class="py-2 px-4">

                </td>
                <td></td>
                <td class="py-2 px-4">
                    <x-button>Save</x-button>
                </td>
            </form>
        </tr>
        @foreach ($products as $product)
            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 {{ $loop->odd ? 'bg-gray-50 dark:bg-gray-900' : '' }} cursor-pointer {{ request()->is('product/' . $product->id) ? 'bg-indigo-200 hover:bg-indigo-300 dark:bg-indigo-700 dark:hover:bg-indigo-600' : '' }}">
                <td class="py-2 px-4">
                    <a href="{{ route('product', $product) }}"
                       class="hover:text-indigo-700 dark:hover:text-indigo-400"
                       wire:navigate.hover>
                        {{ $product->name }}
                    </a>
                </td>
                <td class="py-2 px-4">
                    {{ $product->category->name ?? 'N/A' }}
                <td class="py-2 px-4">
                    @if ($product->suppliers->count() > 1)
                        <label>
                            <select wire:model.live="supplierId"
                                    class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                                <option value="">All Suppliers</option>
                                @foreach ($product->suppliers->unique('id') as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </label>
                    @else
                        {{ $product->suppliers->first()->name ?? 'N/A' }}
                    @endif
                </td>
                <td class="py-2 px-4 grid grid-cols-2 gap-2">
                    @if ($product->colors->count() > 1)
                        <x-dropdown-input :items="$product->colors" selected="color" allLabel="All Colors"/>
                    @else
                        <span class="text-indigo-700 text-center dark:text-indigo-400">
                            {{ $product->colors->first()->key ?? 'N/A' }}
                        </span>
                    @endif
                    @if ($product->sizes->count() > 1)
                        <x-dropdown-input :items="$product->sizes" selected="size" allLabel="All Sizes"/>
                    @else
                        <span class="text-indigo-700 text-center dark:text-indigo-400">
                        {{ $product->sizes->first()->key ?? 'N/A' }}
                        </span>
                    @endif
                </td>

                <td class="py-2 px-4">
                    @if ($color || $size || $supplierId)
                        {{ $product->totalStockForColorSizeAndSupplier($color, $size, $supplierId) }}
                    @else
                        @if ($product->stock > 0)
                            {{ $product->stock }}
                        @else
                            Out of stock
                        @endif
                    @endif
                </td>

                <td class="py-2 text-end px-4">
                    Created: {{ $product->created_at->format('d/m/Y')}} {{$product->created_at->diffForHumans() }}
                </td>
                <td class="py-2 px-4">
                    <div class="flex justify-end">
                        @if(isset($product->deleted_at))
                            <x-secondary-button class="mr-2" wire:click="restore({{ $product->id }})">Restore</x-secondary-button>
                            <x-danger-button wire:click="forceDelete({{ $product->id }})"
                                             wire:confirm="Are you sure you want to delete {{ ucwords($product->name) }}?">
                                Force Delete
                            </x-danger-button>
                        @else
                        <x-danger-button wire:click="delete({{ $product->id }})">Delete</x-danger-button>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach

        @if ($products->count() == 0)
            <tr>
                <td colspan="4" class="py-2 text-center">No products found.</td>
            </tr>
        @endif
        </tbody>
    </table>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
