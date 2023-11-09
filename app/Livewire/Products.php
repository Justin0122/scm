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

    public function render()
    {
        $query = Product::with(['category', 'specifications', 'suppliers'])
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });

        if ($this->category) {
            $query->whereHas('category', function ($query) {
                $query->where('id', $this->category);
            });
        }

        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        // Get the results
        $products = $query->paginate(10);

        if (!$products->count()) {
            $this->resetPage();
            $products = $query->paginate(10);
        }

        return view('livewire.products', [
            'products' => $products,
            'categories' => Category::all(),
        ]);
    }

    public function getStock($productId, $supplierId, $productSpecificationId)
    {
        $product = Product::find($productId);
        $supplier = $product->suppliers()->find($supplierId);
        $productSpecification = $product->specifications()->find($productSpecificationId);

        return $supplier->pivot->stock - $productSpecification->pivot->stock;
    }

    public function mount()
    {
        $this->fill(request()->only('category', 'sortBy', 'sortDirection'));
    }

}
