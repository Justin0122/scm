<div class="max-w-md mt-8 p-6 bg-white rounded-md shadow-md dark:bg-gray-800 dark:text-gray-200">
    <h1 class="text-2xl font-bold mb-4">{{ $productSpecifications->first()->product->name }}</h1>

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
            </p>
            <p class="text- {{ $specification->stock > 5 ? 'text-green-500' : 'text-red-500'}}">
                Stock: <span class="font-bold">{{ $specification->stock }}</span>
            </p>
        </div>
    @endforeach
</div>
