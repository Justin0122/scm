<div class="container mx-auto px-4">
    @if($this->id)
        @include('livewire.crud.edit')
    @else
        @if ($results->count())
            {{ $results->links() }}

            <div class="mt-4">
                <x-table :results="$results" :type="'color'" :create="true"/>
            </div>
        @endif
    @endif
</div>
