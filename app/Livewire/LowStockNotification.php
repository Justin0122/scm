<?php

namespace App\Livewire;

use App\Models\ProductSpecification;
use Livewire\Component;

class LowStockNotification extends Component
{
    public function render()
    {
        $lowStockProducts = ProductSpecification::where('stock', '<', 5)
            ->with('product')
            ->whereHas('product', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->get();

        return view('livewire.low-stock-notification', [
            'lowStockProducts' => $lowStockProducts,
        ]);
    }
}
