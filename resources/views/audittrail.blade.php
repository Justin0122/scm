<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Audit Trail') }}
        </h2>
    </x-slot>

    <div class="mx-auto py-10 sm:px-6 lg:px-8">
            @livewire('audit-trail')
    </div>
</x-app-layout>
