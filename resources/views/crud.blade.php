<x-app-layout>
    @php
        $pages = ['supplier', 'color', 'size', 'sizeGroup', 'category'];
    @endphp
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex gap-2">
            {{ __('Crud') }}
            @foreach($pages as $page)
                @php
                    $url = URL::route('crud', ['type' => $page]);
                    $currentPage = request('type');
                @endphp

                <a href="{{ $url }}" wire:navigate.hover
                   class="text-indigo-700 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600 {{ $currentPage === $page ? 'underline text-indigo-900 dark:text-indigo-600' : '' }}">
                    {{ ucwords(join(' ', preg_split('/(?=[A-Z])/', $page))) }}
                </a>
            @endforeach

        </h2>
    </x-slot>

    <div class="mx-auto py-10 sm:px-6 lg:px-8">

        @if (in_array(request()->type, $pages))
            @livewire(request()->type)
        @endif
    </div>

</x-app-layout>
