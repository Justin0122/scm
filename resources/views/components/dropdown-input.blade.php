@props(['items', 'selected', 'allLabel', 'naLabel', 'multiple' => false])

<label>
    <select wire:model.live="{{ $selected }}" class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200" {{ $multiple ? 'multiple' : '' }}>
        @php
            $uniqueItems = $items->unique('id');
        @endphp

        @if ($uniqueItems->count() >= 1 && isset($allLabel))
            <option value="">{{ $allLabel }}</option>
        @elseif (isset($naLabel))
            <option value="">{{ $naLabel }}</option>
        @endif

        @foreach ($uniqueItems as $item)
            <option value="{{ $item->id }}">{{ $item->key ?? $item->name }}</option>
        @endforeach
    </select>
</label>
