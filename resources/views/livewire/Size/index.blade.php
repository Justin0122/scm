<div class="container mx-auto px-4">
    @if($this->id)
        @include('livewire.crud.edit')
    @else
        @include('livewire.crud.create')

        @if ($results->count())
            {{ $results->links() }}

            <div class="mt-4">
                <x-table :results="$results" :type="'size'"/>

            </div>
        @endif
    @endif
</div>
