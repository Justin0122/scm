<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Size as SizeModel;

class Size extends Component
{
    use WithPagination;

    #[Url (as: 'id')]
    public $id;
    public $form = [];

    public $url = '';


    public function render()
    {
        if ($this->id && !SizeModel::find($this->id)) {
            $this->id = '';
        }
    return view('livewire.Size.index',
        [
            'results' => $this->id ? SizeModel::find($this->id) : SizeModel::paginate(10),
            'fillables' => (new SizeModel())->getFillable(),
            'url' => current(explode('?', url()->current())),
        ]);
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
        $Size = SizeModel::find($this->id);
        foreach ($this->form as $key => $value) {
            $Size->$key = $value;
        }
        $Size->save();
    }

    public function delete($id)
    {
        $Size = SizeModel::find($id);
        $Size->delete();

        return redirect()->route(strtolower('Size'));
    }
}
