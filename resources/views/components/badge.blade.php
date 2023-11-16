@props(['type', 'text'])
@php
    $typeColors = [
        'success' => 'green',
        'danger' => 'red',
        'warning' => 'yellow',
        'info' => 'blue',
        'light' => 'gray',
        'dark' => 'gray',
    ];

    $type = $typeColors[$type] ?? $type;
@endphp

<span class="px-2 py-1 bg-{{ $type }}-200 text-{{ $type }}-800 rounded-md hover:bg-{{ $type }}-300 hover:text-{{ $type }}-900">
    {{ $text }}
</span>
