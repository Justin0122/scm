<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

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
    public $supplierId;

    public function render()
    {
        $query = Product::withTrashed()
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });

        if ($this->category) {
            $query->whereHas('category', function ($query) {
                $query->where('id', $this->category);
            });
        }

        if ($this->color) {
            $query->whereHas('colors', function ($query) {
                $query->where('colors.id', $this->color);
            });
        }

        if ($this->size) {
            $query->whereHas('sizes', function ($query) {
                $query->where('sizes.id', $this->size);
            });
        }

        if ($this->supplierId) {
            $query->whereHas('suppliers', function ($query) {
                $query->where('suppliers.id', $this->supplierId);
            });
        }

        $query->orderBy($this->sortBy, $this->sortDirection);

        $products = $query->paginate(10);

        if (!$products->count()) {
            $this->resetPage();
            $products = $query->paginate(10);
        }

        $stock = $this->calculateStock($products, $this->color, $this->size, $this->supplierId);

        return view('livewire.products', [
            'products' => $products,
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
    public function viewProduct($productId)
    {
        // Redirect to the product-specific page using Livewire route
        return redirect()->to("/product/{$productId}");
    }

}
