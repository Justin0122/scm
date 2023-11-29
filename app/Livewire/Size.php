<?php

namespace App\Livewire;

use App\Interfaces\CrudComponent;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Size as SizeModel;

class Size extends Component implements CrudComponent
{
    use WithPagination;

    #[Url (as: 'id')]
    public $id;
    #[Url (as: 'q')]
    public $search = "";
    public $form = [];

    public $url = '';
    public $perPage = 10;
    public $sort = 'all';
    public $showDeleted = false;

    public function render()
    {
        if ($this->id && !SizeModel::withTrashed()->find($this->id)) {
            $this->id = '';
        }

        if ($this->perPage) {
            session()->remove('perPage');
            session()->put('perPage', $this->perPage);
        }

        if ($this->showDeleted) {
            $sizesQuery = SizeModel::onlyTrashed();
        } else {
            $sizesQuery = SizeModel::withoutTrashed()
                ->where(function ($query) {
                    $query->where('key', 'like', '%' . $this->search . '%');
                })
                ->orderBy('id', 'desc');
        }

        if ($this->sort == 'integer') {
            $sizesQuery->where('key', 'REGEXP', '^[0-9]+$');
        } elseif ($this->sort == 'string') {
            $sizesQuery->where('key', 'REGEXP', '^[^0-9]+$');
        }


        $sizes = $sizesQuery
            ->whereNotIn('id', function ($query) {
                $query->select('size_id')
                    ->from('size_group_sizes')
                    ->where('size_group_id', $this->id);
            })
            ->paginate($this->perPage);


    return view('livewire.Size.index',
        [
            'results' => $this->id ? SizeModel::withTrashed()->find($this->id) : $sizes,
            'fillables' => (new SizeModel())->getFillable(),
            'url' => current(explode('?', url()->current())),
        ]);
    }

    public function mount()
    {
        $this->perPage = session()->get('perPage') ?? 10;
    }

    public function create()
    {
        $Size = new SizeModel();
        foreach ($this->form as $key => $value) {
            $Size->$key = $value;
        }
        $Size->save();
    }

    public function update()
    {
        $Size = SizeModel::withTrashed()->find($this->id);
        foreach ($this->form as $key => $value) {
            $Size->$key = $value;
        }
        $Size->save();
    }

    public function delete($id)
    {
        $Size = SizeModel::find($id);
        $Size->delete();

        return redirect()->back();
    }

    public function restore($id)
    {
        $Size = SizeModel::withTrashed()->find($id);
        $Size->restore();

        return redirect()->back();
    }

    public function forceDelete($id)
    {
        $Size = SizeModel::withTrashed()->find($id);
        $Size->forceDelete();

        return redirect()->back();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'sort', 'showDeleted']);
    }
}
