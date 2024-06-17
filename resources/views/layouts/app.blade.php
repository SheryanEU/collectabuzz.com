<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss'])
</head>
<body class="font-sans antialiased {{ session('theme', 'dark') }}">
    <div class="min-h-screen">
        @include('layouts.includes.navigation')

        <!-- Page Content -->
        <main class="container-fluid mt-5 px-0 py-4">
            {{ $slot }}
        </main>
    </div>

    <!-- Scripts -->
    @vite('resources/js/app.js')
    @yield('scripts')
</body>
</html>
