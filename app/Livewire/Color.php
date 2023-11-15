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
    public $form = [];

    public $url = '';


    public function render()
    {
        if ($this->id && !ColorModel::withTrashed()->find($this->id)) {
            $this->id = '';
        }
    return view('livewire.Color.index',
        [
            'results' => $this->id ? ColorModel::withTrashed()->find($this->id) : ColorModel::withTrashed()->paginate(10),
            'fillables' => (new ColorModel())->getFillable(),
            'url' => current(explode('?', url()->current())),
        ]);
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
