<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset(mix('app.css', 'assets')) }}">

    <script src="{{ asset(mix('manifest.js', 'assets')) }}" defer></script>
    <script src="{{ asset(mix('vendor.js', 'assets')) }}" defer></script>
    <script src="{{ asset(mix('app.js', 'assets')) }}" defer></script>
</head>
<body class="antialiased bg-gray-100">
    <div id="app" class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
        @include('app.navigation.menu')

        <div class="flex flex-col flex-1 w-0 overflow-hidden">
            <div class="relative z-10 flex flex-shrink-0 h-16 bg-white shadow">
                <button @click.stop="sidebarOpen = true" class="px-4 text-gray-500 border-r border-gray-200 focus:outline-none focus:bg-gray-100 focus:text-gray-600 lg:hidden" aria-label="Open sidebar">
                    <x-heroicon-o-menu-alt-2 class="w-6 h-6" />
                </button>
                <div class="flex justify-between flex-1 px-4">
                    <div class="flex flex-1">
                        <form class="flex w-full lg:ml-0" action="#" method="GET">
                            <label for="search_field" class="sr-only">Search</label>
                            <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                                <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                                    <x-heroicon-o-search class="w-5 h-5" />
                                </div>
                                <input id="search_field" class="block w-full h-full py-2 pl-8 pr-3 text-gray-900 placeholder-gray-500 rounded-md focus:outline-none focus:placeholder-gray-400" placeholder="Search" type="search">
                            </div>
                        </form>
                    </div>
                    <div class="flex items-center ml-4 lg:ml-6">
                        <button class="p-1 text-gray-400 rounded-full hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:shadow-outline focus:text-gray-500" aria-label="Notifications">
                            <x-heroicon-o-bell class="w-6 h-6" />
                        </button>

                        @include('app.navigation.profile')
                    </div>
                </div>
            </div>

            <main class="relative z-0 flex-1 overflow-y-auto focus:outline-none" tabindex="0">
                <div class="px-4 pt-2 pb-6 lg:p-6 lg:px-8 max-w-7xl">
                    <h1 class="text-2xl font-semibold text-gray-900">@yield('title')</h1>
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
