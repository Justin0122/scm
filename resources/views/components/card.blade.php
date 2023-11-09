<div class="mx-2 mb-8">
    <article class="relative isolate flex flex-col justify-end overflow-hidden rounded-2xl px-8 py-10 pt-40 mt-24 bg-gray-50 dark:shadow-xl dark:bg-gray-700 h-72 w-30 dark:hover:shadow-2xl transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-103 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-gray-100 dark:hover:drop-shadow-2xl sm:mx-auto sm:max-w-xl md:max-w-full">
        @if (isset($image))
            <img src="{{ $image }}" alt="{{ $title }}" class="absolute inset-0 h-full w-full object-cover object-center z-0">
        @endif
        <div class="absolute inset-0 bg-gradient-to-t dark:from-gray-900 dark:via-gray-900/40 from-teal-900 via-teal-900/40"></div>
        <h3 class="z-10
         {{$titleClasses ?? 'mt-3 text-3xl'}}
         font-bold text-white">{{$title}}</h3>
        <div class="z-10 gap-y-1 overflow-hidden text-sm leading-6 text-gray-300 dark:text-gray-200 w-3/4">
            {{ $description }}
        </div>
        @if (isset($button))
            <div class="z-10 mt-6 absolute bottom-4 right-4">
                <div class="flex flex-row">
                    @if (isset($deleteButton))
                        <x-danger-button wire:confirm="Are you sure you want to delete this?" wire:click="delete({{ $deleteButton['id'] }})" class="bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300">
                            Delete
                        </x-danger-button>
                    @endif
                    @if (isset($secondaryButton))
                        <a wire:navigate.hover href="{{ $secondaryButton['url'] }}">
                            <x-secondary-button class="bg-gray-500 hover:bg-gray-700 dark:bg-gray-500">
                                {{ $secondaryButton['label'] }}
                            </x-secondary-button>
                        </a>
                    @endif
                    <a href="{{ $button['url'] }}">
                        <x-button class="bg-teal-500 hover:bg-teal-700 dark:bg-teal-500  dark:text-gray-900">
                            {{ $button['label'] }}
                        </x-button>
                    </a>
                </div>
            </div>
        @endif
    </article>
</div>
