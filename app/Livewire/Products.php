<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SizeGroup;

class Products extends Component
{

    use WithPagination;

    #[Url (as: 'q')]
    public $search = "";

    public $category;
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $color;
    public $size;
    public $selectedSizeGroup;
    public $supplierId;

    public function render()
    {
        $query = Product::withTrashed()
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->category, fn ($query) => $query->whereHas('category', fn ($q) => $q->where('id', $this->category)))
            ->when($this->color, fn ($query) => $query->whereHas('colors', fn ($q) => $q->where('colors.id', $this->color)))
            ->when($this->size, fn ($query) => $query->whereHas('sizes', fn ($q) => $q->where('sizes.id', $this->size)))
            ->when($this->supplierId, fn ($query) => $query->whereHas('suppliers', fn ($q) => $q->where('suppliers.id', $this->supplierId)));

        $query->orderBy($this->sortBy, $this->sortDirection);

        $products = $query->paginate(10);

        if (!$products->count()) {
            $this->resetPage();
            $products = $query->paginate(10);
        }

        $stock = $this->calculateStock($products, $this->color, $this->size, $this->supplierId);

        return view('livewire.products', [
            'products' => $products,
            'sizeGroups' => SizeGroup::all(),
            'categories' => Category::all(),
            'stock' => $stock,
        ]);

    }

    public function mount()
    {
        $this->fill(request()->only('category', 'sortBy', 'sortDirection'));
        $this->currentProduct = null;
    }

    protected function calculateStock($products, $color, $size, $supplier)
    {
        $totalStock = 0;

        foreach ($products as $product) {
            $specifications = $product->productSpecifications;

            $filteredSpecifications = $specifications
                ->where('color_id', $color)
                ->where('size_id', $size)
                ->where('supplier_id', $supplier);

            $totalStock += $filteredSpecifications->sum('stock');
        }

        return $totalStock;
    }
}
