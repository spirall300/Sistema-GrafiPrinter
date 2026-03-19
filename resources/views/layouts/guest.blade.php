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

<body class="font-sans text-gray-900 antialiased bg-slate-900">
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900">

        <div class="mb-8 text-center">
            <h1 class="text-4xl font-extrabold text-white tracking-widest uppercase italic">
                GRAFI-PRINTER 360 C.A
            </h1>
            <p class="text-white text-sm mt-2">Sistema de Gestion e Inventario</p>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-2xl overflow-hidden sm:rounded-2xl border-t-4 border-blue-500">
            {{ $slot }}
        </div>

        <footer class="mt-8 text-white text-xs">
            &copy; {{ date('Y') }} - Universidad Politécnica Territorial de Falcón Alonso Gamero
        </footer>
    </div>
</body>

</html>
