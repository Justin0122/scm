<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crud') }}
        </h2>
    </x-slot>
    @php
        $pages = ['supplier', 'color', 'size'];
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
        <div class="col-span-1 filter flex flex-col mt-20">
    <ul class="border-2 border-gray-300 p-2 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-gray-300 mb-4">
        @foreach($pages as $page)
            <li wire:navigate.hover href="{{ route('crud', ['type' => $page]) }}"
                class="cursor-pointer hover:text-teal-500 transition duration-300 ease-in-out {{ request()->type == $page ? 'text-teal-500' : '' }}">
            {{ ucfirst($page) }}
        @endforeach
    </ul>
</div>

    <div class="py-12 col-span-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                @if (in_array(request()->type, $pages))
                    @livewire(request()->type)
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
