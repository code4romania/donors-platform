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
    <main id="app" class="flex flex-col justify-center min-h-screen px-4 py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <a href="{{ url('/') }}" class="block">
                <x-icon-symbol class="w-auto h-12 mx-auto text-gray-900" />
            </a>
            <h1 class="mt-6 text-3xl font-bold leading-tight text-center text-gray-900">
                @yield('title')
            </h1>
        </div>

        <div class="w-full mx-auto mt-8 sm:max-w-md">
            @yield('message')
            <div class="px-4 py-8 bg-white rounded-sm shadow sm:rounded-lg sm:px-10">
                @yield('content')
            </div>
        </div>
    </main>
</body>
</html>
