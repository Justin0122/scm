<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category as CategoryModel;

class Category extends Component
{
    use WithPagination;

    #[Url (as: 'id')]
    public $id;
    public $form = [];

    public $url = '';


    public function render()
    {
        if ($this->id && !CategoryModel::withTrashed()->find($this->id)) {
            $this->id = '';
        }
    return view('livewire.Category.index',
        [
            'results' => $this->id ? CategoryModel::withTrashed()->find($this->id) : CategoryModel::withTrashed()->paginate(10),
            'fillables' => (new CategoryModel())->getFillable(),
            'url' => current(explode('?', url()->current())),
        ]);
    }

    public function create()
    {
        $Category = new CategoryModel();
        foreach ($this->form as $key => $value) {
            $Category->$key = $value;
        }
        $Category->save();
    }

    public function update()
    {
        $Category = CategoryModel::withTrashed()->find($this->id);
        foreach ($this->form as $key => $value) {
            $Category->$key = $value;
        }
        $Category->save();
    }

    public function delete($id)
    {
        $Category = CategoryModel::find($id);
        $Category->delete();

        return redirect()->back();
    }

    public function restore($id)
    {
        $Category = CategoryModel::withTrashed()->find($id);
        $Category->restore();

        return redirect()->back();
    }

    public function forceDelete($id)
    {
        $Category = CategoryModel::withTrashed()->find($id);
        $Category->forceDelete();

        return redirect()->back();
    }
}
