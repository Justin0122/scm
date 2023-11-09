<div class="edit flex flex-col p-4 bg-white shadow-md rounded-lg dark:bg-gray-800">
    <form wire:submit.prevent="update" class="space-y-4">
        @foreach($fillables as $fillable)
            <div class="flex flex-col">
                <label for="{{ $results->$fillable }}" class="text-sm font-semibold text-gray-600">
                    {{ ucfirst($fillable) }}
                </label>
                <x-input
                    type="text"
                    class="py-2 px-3 border rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                    placeholder="{{ $results->$fillable }}"
                    wire:model="form.{{ $fillable }}"
                />
            </div>
        @endforeach
        <button type="submit" class="py-2 px-4 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300">
            Submit
        </button>
    </form>
    <x-danger-button wire:click="delete({{ $results->id }})" class="mt-4 py-2 px-4 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300">
        Delete
    </x-danger-button>
</div>
