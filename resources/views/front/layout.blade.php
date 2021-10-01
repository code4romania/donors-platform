<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEO::generate() !!}

    <link rel="stylesheet" href="{{ mix('assets/app.css') }}">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/favicons/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/favicons/manifest.json') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <meta name="msapplication-config" content="{{ asset('assets/favicons/browserconfig.xml') }}">
    <meta name="theme-color" content="#0d9488">

    <script src="{{ mix('assets/public.js') }}" defer></script>
</head>
<body class="antialiased">
    <div id="app" class="flex flex-col min-h-screen">
        <x-header />

        <main class="flex-1">
            @yield('content')
        </main>

        <x-footer />
    </div>

    @include('front.analytics')
</body>
</html>
