<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased bg-slate-900">
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900">

        <div class="mb-6 text-center">
            <img src="/logo.png" alt="GrafiPrinter Logo" class="w-16 h-16 mx-auto mb-4 rounded-full shadow-lg">
            <h1 class="text-3xl font-extrabold text-white tracking-widest uppercase italic">
                GRAFIPRINTER 360
            </h1>
            <p class="text-white text-sm mt-2">Sistema de Gestion de Pedidos</p>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-2xl overflow-hidden sm:rounded-2xl border-t-4 border-blue-500">
            {{ $slot }}
        </div>

        <footer class="mt-8 flex flex-col items-center text-center text-white/80 text-xs sm:text-sm">
            <span>&copy; {{ date('Y') }} - Universidad Politécnica Territorial Alonso Gamero</span>
            <a href="https://creativecommons.org/licenses/by-nc-nd/4.0/" target="_blank" rel="noopener noreferrer"
                class="mt-2 inline-flex flex-wrap items-center justify-center gap-1 text-[11px] font-medium text-white/90 transition hover:text-white">
                <span>Este trabajo está licenciado bajo</span>
                <span class="font-semibold">CC BY-NC-ND 4.0</span>
                <span class="ml-1 flex items-center gap-1" aria-hidden="true">
                    <img src="https://mirrors.creativecommons.org/presskit/icons/cc.svg" alt=""
                        class="h-4 w-4" />
                    <img src="https://mirrors.creativecommons.org/presskit/icons/by.svg" alt=""
                        class="h-4 w-4" />
                    <img src="https://mirrors.creativecommons.org/presskit/icons/nc.svg" alt=""
                        class="h-4 w-4" />
                    <img src="https://mirrors.creativecommons.org/presskit/icons/nd.svg" alt=""
                        class="h-4 w-4" />
                </span>
            </a>
        </footer>
    </div>
</body>

</html>
