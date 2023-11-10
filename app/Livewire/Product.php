<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product as ProductModel;

class Product extends Component
{
    public $productId;

    public function mount()
    {
        $this->productId = request()->segment(count(request()->segments()));
    }

    public function render()
    {
        //find all product specifications from the product where product_id is equal to the product id
        $productSpecifications = ProductModel::withTrashed()->find($this->productId)->productSpecifications()->get();

        return view('livewire.product', [
            'productSpecifications' => $productSpecifications,
        ]);
    }
}
