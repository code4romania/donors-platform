<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ mix('assets/app.css') }}">

    <script src="{{ mix('assets/manifest.js') }}" defer></script>
    <script src="{{ mix('assets/vendor.js') }}" defer></script>
    <script src="{{ mix('assets/app.js') }}" defer></script>
    @routes
</head>
<body class="antialiased bg-gray-50">
    @inertia
</body>
</html>
