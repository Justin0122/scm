<x-app-layout>
    @php
        $pages = ['supplier', 'color', 'size', 'sizeGroup', 'category'];
    @endphp
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crud') }}
        </h2>
    </x-slot>

    <div class="mx-auto py-10 sm:px-6 lg:px-8">

        @if (in_array(request()->type, $pages))
            @livewire(request()->type)
        @endif
    </div>

</x-app-layout>
