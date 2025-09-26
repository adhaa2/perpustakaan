<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
<body class="bg-gray-100 text-gray-900">
    @if(Auth::check() && Auth::user()->role === 'admin')
        @include('layouts.navigation-admin')
    @else
        @include('layouts.navigation-user')
    @endif

    <!-- Main content: jika admin, tambahkan margin-left untuk menghindari sidebar -->
    <main class="{{ (Auth::check() && Auth::user()->role === 'admin') ? 'md:ml-64' : '' }} container mx-auto mt-6 px-4">
        {{ $slot }}
    </main>
</body>

</html>
