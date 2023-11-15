<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Supplier as SupplierModel;

class Supplier extends Component
{
    use WithPagination;

    #[Url (as: 'id')]
    public $id;
    public $form = [];

    public $url = '';


    public function render()
    {
        if ($this->id && !SupplierModel::withTrashed()->find($this->id)) {
            $this->id = '';
        }
    return view('livewire.Supplier.index',
        [
            'results' => $this->id ? SupplierModel::withTrashed()->find($this->id) : SupplierModel::withTrashed()->paginate(10),
            'fillables' => (new SupplierModel())->getFillable(),
            'url' => current(explode('?', url()->current())),
        ]);
    }

    public function create()
    {
        $Supplier = new SupplierModel();
        foreach ($this->form as $key => $value) {
            $Supplier->$key = $value;
        }
        $Supplier->save();
    }

    public function update()
    {
        $Supplier = SupplierModel::withTrashed()->find($this->id);
        foreach ($this->form as $key => $value) {
            $Supplier->$key = $value;
        }
        $Supplier->save();
    }

    public function delete($id)
    {
        $Supplier = SupplierModel::find($id);
        $Supplier->delete();

        return redirect()->back();
    }

    public function restore($id)
    {
        $Supplier = SupplierModel::withTrashed()->find($id);
        $Supplier->restore();

        return redirect()->back();
    }

    public function forceDelete($id)
    {
        $Supplier = SupplierModel::withTrashed()->find($id);
        $Supplier->forceDelete();

        return redirect()->back();
    }
}
