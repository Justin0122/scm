<x-app-layout>
    <div class="mx-auto py-10 sm:px-6 lg:px-8">
        <div class="grid grid-cols-6">
            <div class="col-span-4">
                @livewire('products')
            </div>
            <div class="col-span-2">
                @livewire('product')
            </div>
        </div>
    </div>
</x-app-layout>
