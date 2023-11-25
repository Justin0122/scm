<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="flex h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Sidebar -->
        <div
            class="w-64 bg-white dark:bg-gray-800 flex flex-col space-y-4 border-r border-gray-200 dark:border-gray-700">
            <!-- Logo -->
            <div class="p-4 flex items-center">
                <a href="{{ route('dashboard') }}">
                    <x-application-mark class="block h-9 w-auto"/>
                </a>
            </div>
            <div class="mt-auto border-t border-gray-200 dark:border-gray-700">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <button
                                class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="h-8 w-8 rounded-full object-cover"
                                     src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"/>
                            </button>
                        @else
                            <span class="inline-flex rounded-md">
                                    <button type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}

                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                        </svg>
                                    </button>
                                </span>
                        @endif
                    </x-slot>

                    <x-slot name="content">
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Manage Account') }}
                        </div>

                        <x-dropdown-link href="{{ route('profile.show') }}">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                            <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                {{ __('API Tokens') }}
                            </x-dropdown-link>
                        @endif

                        <div class="border-t border-gray-200 dark:border-gray-600"></div>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf

                            <x-dropdown-link href="{{ route('logout') }}"
                                             @click.prevent="$root.submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Navigation Links -->
            <div class="flex flex-col space-y-1">
                <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>
                <x-nav-link href="{{ route('products') }}" :active="request()->routeIs('products')">
                    {{ __('Products') }}
                </x-nav-link>

                <x-link-border/>

                <x-section-title :title="__('Crud')" :description="__('Manage your data.')" :class="'mx-4'"/>
                @php $pages = ['supplier', 'color', 'size', 'sizeGroup', 'category']; @endphp
                @foreach ($pages as $page)
                    @php
                        $url = URL::route('crud', ['type' => $page]);
                        $currentPage = request('type');
                    @endphp
                    <x-nav-link href="{{ route('crud', ['type' => $page]) }}"
                                :active="request()->routeIs('crud') && $currentPage == $page">
                        {{ ucwords(join(' ', preg_split('/(?=[A-Z])/', $page))) }}
                    </x-nav-link>
                @endforeach
                <x-link-border/>
                <x-section-title :title="__('Audit Trail')" :description="__('View all database changes.')" :class="'mx-4'"/>
                <x-nav-link href="{{ route('audit-trail') }}" :active="request()->routeIs('audit-trail')">
                    {{ __('Audit Trail') }}
                </x-nav-link>

                @can('seeTelescope')
                    <x-link-border/>
                    <x-section-title :title="__('Telescope')" :description="__('View all database changes.')" :class="'mx-4'"/>
                    <x-nav-link href="{{ route('telescope') }}" :active="request()->routeIs('telescope')">
                        {{ __('Telescope') }}
                    </x-nav-link>
                @endcan
            </div>

        </div>
    </div>
</nav>
