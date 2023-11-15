<div class="container mx-auto px-4">
    @if($this->id)
        @include('livewire.crud.edit')
    @else
        {{ $results->links() }}
        <div class="mt-4">
            <x-table :results="$results" :type="'color'" :create="true" :fillables="$fillables"/>
        </div>
    @endif
</div>
