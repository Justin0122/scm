<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use OwenIt\Auditing\Models\Audit;

class AuditTrail extends Component
{
    use WithPagination;

    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $eventFilter = '';
    public $userFilter = '';
    public $ipAddressFilter = '';
    public $auditableTypeFilter = '';

    public $selectedEvent = '';
    public $selectedUser = '';

    public $search = '';
    public $perPage = 10;
    public $selectedAuditableType = '';

    public function render()
    {
        if($this->perPage){
            session()->remove('perPage');
            session()->put('perPage', $this->perPage);
        }

        $searchTerms = explode(' ', $this->search);

        $query = Audit::with('user')

            ->where(function ($query) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $query->where(function ($query) use ($term) {
                        $query->where('event', 'like', '%' . $term . '%')
                            ->orWhere('ip_address', 'like', '%' . $term . '%')
                            ->orWhere('auditable_type', 'like', '%' . $term . '%')
                            ->orWhere('old_values', 'like', '%' . $term . '%')
                            ->orWhere('new_values', 'like', '%' . $term . '%')
                            ->orWhereHas('user', function ($query) use ($term) {
                                $query->where('name', 'like', '%' . $term . '%');
                            });
                    });
                }
            })
            ->when($this->selectedAuditableType, function ($query) {
                $query->where('auditable_type', 'like', '%' . $this->selectedAuditableType . '%');
            })
            ->when($this->selectedUser, function ($query) {
                $query->where('user_id', $this->selectedUser);
            })
            ->when($this->selectedEvent, function ($query) {
                $query->where('event', $this->selectedEvent);
            })
            ->when($this->eventFilter, function ($query) {
                $query->where('event', $this->eventFilter);
            })
            ->when($this->userFilter, function ($query) {
                $query->where('user_id', $this->userFilter);
            })
            ->when($this->ipAddressFilter, function ($query) {
                $query->where('ip_address', 'like', '%' . $this->ipAddressFilter . '%');
            })
            ->when($this->auditableTypeFilter, function ($query) {
                $query->where('auditable_type', 'like', '%' . $this->auditableTypeFilter . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $auditTypes = Audit::select('auditable_type')->distinct()->get()->map(function ($audit) {
            return substr($audit->auditable_type, strrpos($audit->auditable_type, '\\') + 1);
        });

        return view('livewire.audit-trail', [
            'results' => $query->paginate($this->perPage),
            'users' => \App\Models\User::all(),
            'auditableTypes' => $auditTypes,
        ]);
    }

    public function mount(): void
    {
        $this->perPage = session()->get('perPage', 10);
    }

    public function sort($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function clearFilters()
    {
        $this->reset(['eventFilter', 'userFilter', 'ipAddressFilter', 'auditableTypeFilter', 'selectedEvent', 'selectedUser', 'selectedAuditableType']);
    }
}
