<div wire:poll.keep-alive.5s>
    <x-dropdown>
        <x-slot name="trigger">
            <button class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-gray-500 dark:hover:text-gray-400 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-500 dark:focus:text-gray-400 focus:border-gray-300 dark:focus:border-gray-600 transition duration-150 ease-in-out">
                <div class="ml-1">
                    @if ($lowStockProducts->isNotEmpty())
                        <div class="relative inline-block">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M15.133 10.632v-1.8a5.407 5.407 0 0 0-4.154-5.262.955.955 0 0 0 .021-.106V1.1a1 1 0 0 0-2 0v2.364a.944.944 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C4.867 13.018 3 13.614 3 14.807 3 15.4 3 16 3.538 16h12.924C17 16 17 15.4 17 14.807c0-1.193-1.867-1.789-1.867-4.175Zm-13.267-.8a1 1 0 0 1-1-1 9.424 9.424 0 0 1 2.517-6.39A1.001 1.001 0 1 1 4.854 3.8a7.431 7.431 0 0 0-1.988 5.037 1 1 0 0 1-1 .995Zm16.268 0a1 1 0 0 1-1-1A7.431 7.431 0 0 0 15.146 3.8a1 1 0 0 1 1.471-1.354 9.425 9.425 0 0 1 2.517 6.391 1 1 0 0 1-1 .995ZM6.823 17a3.453 3.453 0 0 0 6.354 0H6.823Z"/>
                            </svg>
                            <span class="absolute top-0 left-6 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">{{ $lowStockProducts->count() }}</span>
                        </div>
                    @else

                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 21">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 3.464V1.1m0 2.365a5.338 5.338 0 0 1 5.133 5.368v1.8c0 2.386 1.867 2.982 1.867 4.175C15 15.4 15 16 14.462 16H1.538C1 16 1 15.4 1 14.807c0-1.193 1.867-1.789 1.867-4.175v-1.8A5.338 5.338 0 0 1 8 3.464ZM4.54 16a3.48 3.48 0 0 0 6.92 0H4.54Z"/>
                    </svg>
                    @endif
                        <div>Low Stock</div>
                        <p class="text-red-400 dark:text-red-300"
                           wire:offline>
                            Offline
                        </p>

                </div>
            </button>
        </x-slot>

        <x-slot name="content">
            <div class="">
                <div class="block py-2 text-s text-gray-400 dark:text-gray-400">
                    {{ __('Manage Low Stock') }}
                </div>
                <div class="block py-2 text-xs text-red-400 dark:text-red-400" wire:offline>
                    Your device lost connection.
                    Connect to the internet to keep it updated
                </div>

                @if($lowStockProducts->isNotEmpty())
                    <div class="alert alert-warning">
                        <ul>
                            @foreach($lowStockProducts as $specification)
                                <li class="text-gray-700 dark:text-gray-200">
                                    <a href="{{ route('product', $specification->product) }}" class="hover:text-teal-500 transition duration-300 ease-in-out" wire:navigate.hover>
                                        {{ $specification->product->name }} - Stock: {{ $specification->stock }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
        </x-slot>
    </x-dropdown>

</div>
