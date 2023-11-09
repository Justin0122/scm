<div class="container mx-auto mt-8">
    <div class="bg-white p-8 rounded shadow-md">
        <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>

        @foreach($product->sizes as $size)
            @foreach($product->colors as $color)
                @foreach($product->suppliers as $supplier)
                    @php
                        $specification = $product->productSpecifications
                            ->where('size_id', $size->id)
                            ->where('color_id', $color->id)
                            ->where('supplier_id', $supplier->id)
                            ->first();
                    @endphp

                    <div class="mb-4 border-b border-gray-300 pb-4">
                        <p class="text-lg font-semibold mb-2">
                            Combination: Size - {{ $size->name }},
                            Color - {{ $color->name }},
                            Supplier - {{ $supplier->name }}
                        </p>
                        <p class="text-gray-600">
                            Stock: {{ $specification ? $specification->stock : 0 }}
                        </p>
                    </div>
                @endforeach
            @endforeach
        @endforeach
    </div>
</div>
