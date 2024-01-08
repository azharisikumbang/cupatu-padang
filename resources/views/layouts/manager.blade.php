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
    <body class="font-sans antialiased">
        <div class="bg-gray-100 min-h-screen flex flex-row">
            <nav class="w-1/6 min-h-screen bg-white shadow border-r">
                @include('layouts.manager.navigation')
            </nav>

            <main class="w-full">
                <div class="p-12">
                    <!-- Page Heading -->
                    @if (isset($header))
                        <header class="mb-4">
                            {{ $header }}
                        </header>
                    @endif

                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
