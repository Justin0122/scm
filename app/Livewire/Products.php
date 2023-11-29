<?php

namespace App\Livewire;

use App\Interfaces\CrudComponent;
use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component implements CrudComponent
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
    public $form = [];
    public $perPage = 10;
    public $showDeleted = false;

    public function render()
    {
        if ($this->showDeleted) {
            $query = Product::onlyTrashed();
        } else {
            $query = Product::withoutTrashed();
        }

        $query->where(function ($query) {
        $query->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%');
    })
        ->when($this->category, fn ($query) => $query->whereHas('category', fn ($q) => $q->where('id', $this->category)))
        ->when($this->color, fn ($query) => $query->whereHas('colors', fn ($q) => $q->where('colors.id', $this->color)))
        ->when($this->size, fn ($query) => $query->whereHas('sizes', fn ($q) => $q->where('sizes.id', $this->size)))
        ->when($this->supplierId, fn ($query) => $query->whereHas('suppliers', fn ($q) => $q->where('suppliers.id', $this->supplierId)));

        $query->orderBy($this->sortBy, $this->sortDirection);

        if ($this->perPage) {
            session()->remove('perPage');
            session()->put('perPage', $this->perPage);
        }

        $products = $query->paginate($this->perPage);

        if (!$products->count()) {
            $this->resetPage();
            $products = $query->paginate($this->perPage);
        }

        if($this->perPage){
            session()->remove('perPage');
            session()->put('perPage', $this->perPage);
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
        $this->perPage = session()->get('perPage', 10);
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

    public function create()
    {
        if (!isset($this->form['category_id'])) {
            $this->form['category_id'] = null;
        }
        Product::create([
            'name' => ucwords($this->form['name']),
            'category_id' => $this->form['category_id'],
        ]);
    }

    public function delete($id)
    {
        $product = Product::find($id);
        $product->delete();
    }

    public function restore($id)
    {
        $product = Product::withTrashed()->find($id);
        $product->restore();
    }

    public function forceDelete($id)
    {
        $product = Product::withTrashed()->find($id);
        $product->forceDelete();
    }

    public function clearFilters()
    {
        $this->reset(['category', 'color', 'size', 'supplierId', 'sortBy', 'sortDirection', 'search', 'showDeleted']);
    }
}
