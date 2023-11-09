<div>
    <div class="mb-4">
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400" for="search">
            <input wire:model.live="search" type="text" class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200" placeholder="Search products...">
        </label>
    </div>
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
            <th class="px-4 py-2 grid grid-cols-2">
                <label class="block">
                    <select wire:model.live="sortBy"
                            class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                        <option value="name">Name</option>
                        <option value="created_at">Created At</option>
                        <option value="updated_at">Updated At</option>
                        <option value="supplier_id">Supplier</option>
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
        </tr>
        </thead>
        <tbody>
        @foreach ($products as $product)
            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 {{ $loop->odd ? 'bg-gray-50 dark:bg-gray-900' : '' }} cursor-pointer">
                <td class="py-2 px-4">{{ $product->name }}</td>
                <td class="py-2 px-4">{{ $product->category->name }}</td>
                <td class="py-2 px-4">
                    @if ($product->suppliers->count() > 1)
                        <select wire:model="supplier" class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                            <option value="">All Suppliers</option>
                            @foreach ($product->suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    @else
                        {{ $product->suppliers->first()->name ?? 'N/A' }}
                    @endif
                </td>
                <td class="py-2 px-4">
                    @php
                        $groupedSpecifications = $product->specifications->groupBy('key');
                    @endphp

                    @foreach ($groupedSpecifications as $key => $specs)
                        <div class="mb-2">
                            <label for="spec-{{ $key }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">{{ ucfirst($key) }}</label>
                            <select id="spec-{{ $key }}" name="specifications[{{ $key }}]" class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                                @foreach ($specs as $specification)
                                    <option value="{{ $specification->pivot->value }}">{{ $specification->pivot->value }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </td>
                <td class="py-2 text-end px-4">
                    Created: {{ $product->created_at->format('d/m/Y')}} {{$product->created_at->diffForHumans() }}
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
