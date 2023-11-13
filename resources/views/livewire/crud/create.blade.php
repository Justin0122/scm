<div class="create flex flex-col p-4 bg-white shadow-md rounded-lg dark:bg-gray-800">
    <form wire:submit.prevent="create" class="space-y-4">
        @foreach($fillables as $fillable)
            <div class="flex flex-col">
                <label for="{{ $results[0]->$fillable ?? $fillable }}" class="text-lg font-semibold text-gray-700 dark:text-white">
                    {{ $fillable }}
                </label>
                <x-input
                    type="text"
                    class="py-2 px-3 border rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                    wire:model="form.{{ $fillable }}"
                />
            </div>
        @endforeach
        <x-button>
            Save
        </x-button>
    </form>
</div>
