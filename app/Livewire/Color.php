<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Color as ColorModel;

class Color extends Component
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
        if ($this->id && !ColorModel::withTrashed()->find($this->id)) {
            $this->id = '';
        }

        if ($this->perPage) {
            session()->remove('perPage');
            session()->put('perPage', $this->perPage);
        }

        $query = ColorModel::withTrashed()
            ->where(function ($query) {
                $query->where('key', 'like', '%' . $this->search . '%');
            });

        if ($this->showDeleted) {
            $query->onlyTrashed();
        }

        $results = $query->paginate($this->perPage);

        return view('livewire.Color.index',
            [
                'results' => $this->id ? ColorModel::withTrashed()->find($this->id) : $results,
                'fillables' => (new ColorModel())->getFillable(),
                'url' => current(explode('?', url()->current())),
            ]);
    }

    public function mount()
    {
        $this->perPage = session()->get('perPage') ?? 10;
    }

    public function create()
    {
        $Color = new ColorModel();
        foreach ($this->form as $key => $value) {
            $Color->$key = $value;
        }
        $Color->save();
    }

    public function update()
    {
        $Color = ColorModel::withTrashed()->find($this->id);
        foreach ($this->form as $key => $value) {
            $Color->$key = $value;
        }
        $Color->save();
    }

    public function delete($id)
    {
        $Color = ColorModel::find($id);
        $Color->delete();

        return redirect()->back();
    }

    public function restore($id)
    {
        $Color = ColorModel::withTrashed()->find($id);
        $Color->restore();

        return redirect()->back();
    }

    public function forceDelete($id)
    {
        $Color = ColorModel::withTrashed()->find($id);
        $Color->forceDelete();

        return redirect()->back();
    }
}
