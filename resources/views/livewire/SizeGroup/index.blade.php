<div class="container mx-auto px-4">
    @if($this->id)
        @include('livewire.SizeGroup.edit')
    @else
        @include('livewire.crud.create')


        @if ($results->count())
            {{ $results->links() }}

            <div class="mt-4">
                <x-table :results="$results" :type="'sizeGroup'"/>
            </div>
        @endif
    @endif
</div>
