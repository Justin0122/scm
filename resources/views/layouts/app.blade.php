<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SCM') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles

    </head>
    <body class="font-sans antialiased">
    <x-banner />

    <!-- Sidebar -->
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="w-64 bg-white dark:bg-gray-800 flex flex-col space-y-4 border-r border-gray-200 dark:border-gray-700 overflow-y-auto">
            @include('navigation-menu')
        </div>

        <!-- Content Area -->
        <div class="flex-1 bg-gray-100 dark:bg-gray-900 overflow-y-auto">
            <div class="min-h-screen">
                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white dark:bg-gray-800 shadow relative">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                            <div>
                                {{ $header }}
                            </div>
                            <div>
                                @livewire('low-stock-notification')
                            </div>
                        </div>
                    </header>
                @endif


                <!-- Page Content -->
                <main class="p-4">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>


    @stack('modals')
    @livewireScripts
    </body>

</html>
