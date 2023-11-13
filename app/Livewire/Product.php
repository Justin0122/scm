<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product as ProductModel;

class Product extends Component
{
    public $productId;
    public $form = [];
    public $filter = [
        'supplier' => 'all',
        'color' => 'all',
        'size' => 'all',
    ];

    public function mount()
    {
        $this->productId = request()->segment(count(request()->segments()));
    }

    public function render()
    {
        $product = ProductModel::withTrashed()->find($this->productId);
        $productSpecificationsQuery = $product->productSpecifications();
        $productSpecifications = $productSpecificationsQuery->get();


        if ($this->filter['supplier'] !== 'all') {
            $productSpecificationsQuery->where('supplier_id', $this->filter['supplier']);
        }

        if ($this->filter['color'] !== 'all') {
            $productSpecificationsQuery->where('color_id', $this->filter['color']);
        }

        if ($this->filter['size'] !== 'all') {
            $productSpecificationsQuery->where('size_id', $this->filter['size']);
        }
        $productSpecifications2 = $productSpecificationsQuery->get();


        // Get unique color, size, and supplier IDs from the product specifications
        $colorIds = $productSpecifications->pluck('color_id')->unique()->toArray();
        $sizeIds = $productSpecifications->pluck('size_id')->unique()->toArray();
        $supplierIds = $productSpecifications->pluck('supplier_id')->unique()->toArray();

        // Get only the relevant options based on the product specifications
        $colors = \App\Models\Color::whereIn('id', $colorIds)->get(['id', 'key']);
        $sizes = \App\Models\Size::whereIn('id', $sizeIds)->get(['id', 'key']);
        $suppliers = \App\Models\Supplier::whereIn('id', $supplierIds)->get(['id', 'name']);

        if(isset($this->form['size_group']) && $this->form['size_group'] != null){
            $sizeFromSelectedGroup = \App\Models\SizeGroup::find($this->form['size_group'])->sizes()->get();
        }else{
            $sizeFromSelectedGroup = [];
        }

        return view('livewire.product', [
            'productSpecifications' => $productSpecifications2,
            'product' => $product,
            'filter_sizes' => $sizes,
            'filter_colors' => $colors,
            'filter_suppliers' => $suppliers,
            'sizeGroups' => \App\Models\SizeGroup::all(),
            'sizes' => \App\Models\Size::all(),
            'colors' => \App\Models\Color::all(),
            'suppliers' => \App\Models\Supplier::all(),
            'sizeFromSelectedGroup' => $sizeFromSelectedGroup,
        ]);
    }
    public function create()
    {
        $product = ProductModel::withTrashed()->find($this->productId);
        $sizeIds = \App\Models\SizeGroup::find($this->form['size_group'])->sizes()->pluck('sizes.id')->toArray();
        $colorIds = \App\Models\Color::find($this->form['color'])->pluck('id')->toArray();
        $supplierIds = \App\Models\Supplier::find($this->form['supplier'])->pluck('id')->toArray();

        foreach($supplierIds as $supplierId){
            foreach ($sizeIds as $sizeId) {
                foreach ($colorIds as $colorId) {
                    $product->productSpecifications()->create([
                        'color_id' => $colorId,
                        'size_id' => $sizeId,
                        'stock' => 0,
                        'supplier_id' => $supplierId,
                    ]);
                }
            }
        }
    }

    public function delete($id)
    {
        $product = ProductModel::withTrashed()->find($this->productId);

        $product->productSpecifications()->find($id)->delete();
    }
}
