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
    @routes
</head>
<body class="antialiased bg-gray-50">
    @inertia
</body>
</html>
