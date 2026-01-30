<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Iris') }}</title>

        <!-- fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- font awesome -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />



        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            /* Animaciones sutiles para elementos de fondo */
            @keyframes float-slow {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
            }
            .animate-float-slow {
                animation: float-slow 8s ease-in-out infinite;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gradient-to-br from-gray-50 via-slate-50 to-gray-100 dark:from-gray-900 dark:via-slate-900 dark:to-gray-800">
            
            {{-- Elementos decorativos de fondo sutiles --}}
            <div class="fixed inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-0 right-0 w-96 h-96 bg-slate-500/5 dark:bg-slate-500/10 rounded-full blur-3xl animate-float-slow"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-500/5 dark:bg-blue-500/10 rounded-full blur-3xl animate-float-slow" style="animation-delay: 2s;"></div>
            </div>

            {{-- Navegación --}}
                @include('layouts.navigation')
            

            {{-- Page Heading --}}
            @isset($header)
                <header class="relative z-10 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md shadow-md border-b border-gray-200 dark:border-gray-700">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- Page Content --}}
            <main class="relative z-10">
                {{ $slot }}
            </main>

            
        {{-- Footer --}}
        </div>
        
        {{-- Scripts adicionales de las páginas --}}
        @stack('scripts')
    </body>
</html>
