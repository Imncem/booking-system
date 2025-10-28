<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased relative min-h-screen bg-gray-100">
        <div id="app" class="min-h-screen bg-gray-100 relative z-0">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- Watermark -->
        <div class="watermark">IMAN</div>

        <style>
            .watermark {
                position: fixed;
                bottom: 18px;
                right: 28px;
                font-family: 'Figtree', sans-serif;
                font-size: 1.2rem;
                font-weight: 800;
                color: rgba(0, 0, 0, 0.55); /* more visible */
                user-select: none;
                pointer-events: none;
                z-index: 99999; /* guaranteed on top */
                letter-spacing: 0.7px;
                opacity: 0;
                text-transform: uppercase;
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
                animation: fadeIn 1.2s ease-out forwards;
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(5px); }
                to { opacity: 0.7; transform: translateY(0); }
            }

            .watermark:hover {
                opacity: 0.9;
            }
        </style>
    </body>
</html>
