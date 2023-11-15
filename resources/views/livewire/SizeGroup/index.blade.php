<div class="container mx-auto px-4">
    @if($this->id)
        @include('livewire.SizeGroup.edit')
    @else
        @if ($results->count())
            {{ $results->links() }}
            <div class="mt-4">
                <x-table :results="$results" :type="'sizeGroup'" :create="true" />
            </div>
        @endif
    @endif
</div>
