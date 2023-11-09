<!-- dropdown.blade.php -->
@props(['items', 'selected', 'allLabel', 'naLabel'])

<label>
    <select wire:model.live="{{ $selected }}" class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
        @php
            $uniqueItems = $items->unique('id');
        @endphp

        @if ($uniqueItems->count() >= 1)
            <option value="">{{ $allLabel }}</option>
        @else
            <option value="">{{ $naLabel }}</option>
        @endif

        @foreach ($uniqueItems as $item)
            <option value="{{ $item->id }}">{{ $item->key }}</option>
        @endforeach
    </select>
</label>
