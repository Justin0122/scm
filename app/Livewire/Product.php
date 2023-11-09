<?php

namespace App\Livewire;

use Livewire\Component;

class Product extends Component
{
    public $productId;

    public function mount()
    {
        $this->productId = request()->segment(count(request()->segments()));
    }

    public function render()
    {
        //find all combinations from product_specifications table where product_id = $this->productId and return the result.
        $productSpecifications = \App\Models\ProductSpecification::where('product_id', $this->productId)->get();
        $product = \App\Models\Product::find($this->productId);
        $product->load('category', 'colors', 'sizes', 'suppliers');
        $product->load('productSpecifications');
        dd($product);
        return view('livewire.product', [
            'product' => $product,
            'productSpecifications' => $productSpecifications,
        ]);
    }

}
