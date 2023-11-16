@props(['items', 'selected', 'allLabel', 'multiple' => false, 'live' => true])

    <select wire:model.{{ $live ? 'live' : 'defer' }}="{{ $selected }}"
            class="border rounded-md p-2 mb-4 dark:bg-gray-700 dark:text-gray-200"
        {{ $multiple ? 'multiple' : '' }}>
        @php
            $uniqueItems = $items->unique('id');
        @endphp

        @if ($uniqueItems->count() >= 1 && isset($allLabel))
            <option value="">{{ $allLabel }}</option>
        @endif

        @foreach ($uniqueItems as $item)
            <option value="{{ $item->id }}">{{ $item->key ?? $item->name }}</option>
        @endforeach
    </select>

