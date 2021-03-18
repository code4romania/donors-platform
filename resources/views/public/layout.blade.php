<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ mix('assets/app.css') }}">
</head>
<body class="flex flex-col min-h-screen antialiased">
    <x-header />

    <main class="flex-1">
        @yield('content')
    </main>

    <x-footer />
</body>
</html>
