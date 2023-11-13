<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3 pr-3">
                <x-card
                    title="Add a product"
                    description=""
                    image=""
                    :button="['url' => '/products', 'label' => 'Add a product']"
                />
                <div class="mx-2 mb-8">
                    <article
                        class="relative isolate flex flex-col justify-end overflow-hidden rounded-2xl px-8 py-10 pt-40 mt-24 bg-gray-50 dark:shadow-xl dark:bg-gray-700 h-72 w-30 dark:hover:shadow-2xl transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-103 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-gray-100 dark:hover:drop-shadow-2xl sm:mx-auto sm:max-w-xl md:max-w-full">
                        <div
                            class="absolute inset-0 bg-gradient-to-t dark:from-gray-900 dark:via-gray-900/40 from-teal-900 via-teal-900/40">
                            <h3 class="z-10 mt-3 text-3xl font-bold text-white pl-4">
                                CRUD
                            </h3>
                            <ul class="border-2 border-gray-300 dark:border-gray-600 p-2 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-gray-300 mb-4 h-56 overflow-y-scroll">
                                @php $types = ['supplier', 'color', 'size', 'sizeGroup']; @endphp

                                @foreach($types as $field)
                                    <li wire:navigate.hover href="{{ route('crud', ['type' => $field]) }}"
                                        class="cursor-pointer hover:text-teal-500 transition duration-300 ease-in-out {{ request()->type == $field ? 'text-teal-500' : '' }}">
                                    {{ ucwords(join(' ', preg_split('/(?=[A-Z])/', $field))) }}
                                @endforeach
                            </ul>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
