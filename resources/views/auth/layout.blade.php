<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') - {{ config('app.name') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset(mix('assets/app.css')) }}">
</head>
<body class="flex flex-col min-h-screen antialiased">
    <main class="flex-1">
        @yield('content')
    </main>
</body>
</html>
