<div>
    <select wire:model.live="perPage"
            class="rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
        @foreach ([10, 20, 50, 100] as $value)
            <option value="{{ $value }}">{{ $value }} per page</option>
        @endforeach
    </select>
</div>
