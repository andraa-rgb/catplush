<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Lab WICIDA - Jadwal Dosen Real-Time')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50">
        <div class="min-h-screen flex flex-col">
            @include('layouts.navigation')

            <!-- Flash Messages -->
            @if ($message = Session::get('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4">
                    <div class="max-w-7xl mx-auto px-4">
                        <p class="text-emerald-800">{{ $message }}</p>
                    </div>
                </div>
            @endif

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow-sm border-b border-slate-200">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-slate-900 text-white mt-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center text-slate-400">
                    &copy; 2026 Lab WICIDA. Sistem Jadwal Dosen Real-Time.
                </div>
            </footer>
        </div>
    </body>
</html>
