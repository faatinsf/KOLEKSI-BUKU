<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Koleksi Buku') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-800">
    <div class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-rose-50 via-red-100 to-red-200 px-4">

        <!-- Logo -->
        <div class="mb-6">
            <a href="/" class="flex justify-center">
                <x-application-logo class="w-20 h-20 fill-current text-red-900" />
            </a>
        </div>

        <!-- Card -->
        <div class="w-full max-w-md bg-white/95 backdrop-blur rounded-2xl shadow-xl px-8 py-6">
            {{ $slot }}
        </div>

        <!-- Footer text (optional tapi aman) -->
        <p class="mt-6 text-sm text-red-900/70">
            © {{ date('Y') }} {{ config('app.name') }}
        </p>

    </div>
</body>
</html>
