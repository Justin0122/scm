<?php

namespace App\Livewire;

use App\Interfaces\CrudComponent;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SizeGroup as SizeGroupModel;
use App\Models\Size;

class SizeGroup extends Component implements CrudComponent
{
    use WithPagination;

    #[Url (as: 'id')]
    public $id;
    #[Url (as: 'q')]
    public $search = "";
    public $form = [];

    public $url = '';
    public $searchUnassignedSizes = '';
    public $sortUnassignedSizes = 'all'; // Default to show all sizes
    public $perPage = 10;

    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        if ($this->id && !SizeGroupModel::find($this->id)) {
            $this->id = '';
        }

        if ($this->perPage) {
            session()->remove('perPage');
            session()->put('perPage', $this->perPage);
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
            'results' => $this->id ? SizeGroupModel::with('sizes')->find($this->id) : SizeGroupModel::with('sizes')->where('name', 'like', '%' . $this->search . '%')->orderBy('id', 'desc')->paginate($this->perPage),
            'fillables' => (new SizeGroupModel())->getFillable(),
            'url' => current(explode('?', url()->current())),
            'sizes' => $sizes,
        ]);
    }

    public function mount()
    {
        $this->perPage = session()->get('perPage') ?? 10;
    }


    public function create(): void
    {
        $SizeGroup = new SizeGroupModel();
        foreach ($this->form as $key => $value) {
            $SizeGroup->$key = $value;
        }
        $SizeGroup->save();
    }

    public function update(): void
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

    public function assignSize($sizeId): void
    {
        $sizeGroup = SizeGroupModel::find($this->id);
        $size = Size::find($sizeId);

        $sizeGroup->sizes()->attach($size);
    }

    public function removeSize($sizeId): void
    {
        $sizeGroup = SizeGroupModel::find($this->id);
        $sizeGroup->sizes()->detach($sizeId);
    }

    public function createAndAssignSize(): void
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

    public function clearFilters()
    {
        $this->reset(['search', 'showDeleted']);
    }
}
