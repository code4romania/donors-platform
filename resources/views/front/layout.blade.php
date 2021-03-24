<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEO::generate() !!}

    <link rel="stylesheet" href="{{ mix('assets/app.css') }}">

    <script src="{{ mix('assets/public.js') }}" defer></script>
</head>
<body class="flex flex-col min-h-screen antialiased">
    <x-header />

    <main id="app" class="flex-1">
        @yield('content')
    </main>

    <x-footer />
</body>
</html>
