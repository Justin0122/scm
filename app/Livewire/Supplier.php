<?php

namespace App\Livewire;

use App\Interfaces\CrudComponent;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Supplier as SupplierModel;

class Supplier extends Component implements CrudComponent
{
    use WithPagination;

    #[Url (as: 'id')]
    public $id;
    #[Url (as: 'q')]
    public $search = "";
    public $form = [];

    public $url = '';
    public $perPage = 10;
    public $showDeleted = false;


    public function render()
    {
        if ($this->id && !SupplierModel::withTrashed()->find($this->id)) {
            $this->id = '';
        }

        if ($this->perPage) {
            session()->remove('perPage');
            session()->put('perPage', $this->perPage);
        }

        if ($this->showDeleted) {
            $results = SupplierModel::onlyTrashed();
        }else{
        $results = SupplierModel::withoutTrashed()
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->where(function ($query) {
                $query->where('address', 'like', '%' . $this->search . '%');
            })
            ->where(function ($query) {
                $query->where('phone', 'like', '%' . $this->search . '%');
            })
            ->where(function ($query) {
                $query->where('email', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc');

        }

        $results = $results->paginate($this->perPage);

    return view('livewire.Supplier.index',
        [
            'results' => $this->id ? SupplierModel::withTrashed()->find($this->id) : $results,
            'fillables' => (new SupplierModel())->getFillable(),
            'url' => current(explode('?', url()->current())),
        ]);
    }

    public function mount()
    {
        $this->perPage = session()->get('perPage') ?? 10;
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

    public function clearFilters()
    {
        $this->reset(['search', 'showDeleted']);
    }
}
