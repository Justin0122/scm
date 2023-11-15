<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SizeGroup as SizeGroupModel;
use App\Models\Size;

class SizeGroup extends Component
{
    use WithPagination;

    #[Url (as: 'id')]
    public $id;
    public $form = [];

    public $url = '';
    public $searchUnassignedSizes = '';
    public $sortUnassignedSizes = 'all'; // Default to show all sizes

    public function render()
    {
        if ($this->id && !SizeGroupModel::find($this->id)) {
            $this->id = '';
        }

        $sizesQuery = Size::where('key', 'like', "%{$this->searchUnassignedSizes}%");

        if ($this->sortUnassignedSizes == 'integer') {
            $sizesQuery->where('key', 'REGEXP', '^[0-9]+$');
        } elseif ($this->sortUnassignedSizes == 'string') {
            $sizesQuery->where('key', 'REGEXP', '^[^0-9]+$');
        }

        $sizes = $sizesQuery
            ->whereNotIn('id', function ($query) {
                $query->select('size_id')
                    ->from('size_group_sizes')
                    ->where('size_group_id', $this->id);
            })
            ->get();

        return view('livewire.SizeGroup.index', [
            'results' => $this->id ? SizeGroupModel::with('sizes')->find($this->id) : SizeGroupModel::with('sizes')->paginate(10),
            'fillables' => (new SizeGroupModel())->getFillable(),
            'url' => current(explode('?', url()->current())),
            'sizes' => $sizes,
        ]);
    }


    public function create()
    {
        $SizeGroup = new SizeGroupModel();
        foreach ($this->form as $key => $value) {
            $SizeGroup->$key = $value;
        }
        $SizeGroup->save();
    }

    public function update()
    {
        $SizeGroup = SizeGroupModel::find($this->id);
        foreach ($this->form as $key => $value) {
            $SizeGroup->$key = $value;
        }
        $SizeGroup->save();
    }

    public function delete($id)
    {
        $SizeGroup = SizeGroupModel::find($id);
        $SizeGroup->delete();

        return redirect()->back();
    }

    public function restore($id)
    {
        $SizeGroup = SizeGroupModel::withTrashed()->find($id);
        $SizeGroup->restore();

        return redirect()->back();
    }

    public function assignSize($sizeId)
    {
        $sizeGroup = SizeGroupModel::find($this->id);
        $size = Size::find($sizeId);

        $sizeGroup->sizes()->attach($size);
    }

    public function removeSize($sizeId)
    {
        $sizeGroup = SizeGroupModel::find($this->id);
        $sizeGroup->sizes()->detach($sizeId);
    }

    public function createAndAssignSize()
    {
        $size = new Size();
        $size->key = $this->form['size']['key'];
        $size->save();

        $sizeGroup = SizeGroupModel::find($this->id);
        $sizeGroup->sizes()->attach($size);
    }

    public function forceDelete($id)
    {
        $SizeGroup = SizeGroupModel::withTrashed()->find($id);
        $SizeGroup->forceDelete();

        return redirect()->back();
    }
}
