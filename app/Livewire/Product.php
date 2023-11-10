<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product as ProductModel;

class Product extends Component
{
    public $productId;
    public $form = [];

    public function mount()
    {
        $this->productId = request()->segment(count(request()->segments()));
    }

    public function render()
    {

        return view('livewire.product', [
            'productSpecifications' => ProductModel::withTrashed()->find($this->productId)->productSpecifications()->get(),
            'product' => ProductModel::withTrashed()->find($this->productId),
            'sizes' => \App\Models\Size::all(),
            'colors' => \App\Models\Color::all(),
            'suppliers' => \App\Models\Supplier::all(),
        ]);
    }

    public function create()
    {
        $product = ProductModel::withTrashed()->find($this->productId);


        $product->productSpecifications()->create([
            'size_id' => $this->form['size'],
            'color_id' => $this->form['color'],
            'supplier_id' => $this->form['supplier'],
            'stock' => $this->form['stock'],
        ]);
    }

    public function delete($id)
    {
        $product = ProductModel::withTrashed()->find($this->productId);

        $product->productSpecifications()->find($id)->delete();
    }
}
