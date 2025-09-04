<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIGEDRA - @yield('title')</title>

    <!-- Scripts y Estilos -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 dark:bg-slate-900">
    <header class="bg-white shadow-md dark:bg-gray-800">
        <nav class="container mx-auto px-4 py-4">
            <a href="{{ route('home') }}" class="text-xl font-bold text-gray-800 dark:text-white">SIGEDRA</a>
        </nav>
    </header>

    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    @livewireScripts

    <!-- Preline JS desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/preline@2.0.3/dist/preline.min.js"></script>

    <script>
        // Verificar que Preline se cargó
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Preline disponible:', typeof window.HSStaticMethods !== 'undefined');

            if (window.HSStaticMethods) {
                window.HSStaticMethods.autoInit();
                console.log('Preline inicializado correctamente');
            } else {
                console.error('Preline no se pudo cargar');
            }
        });
    </script>
</body>
</html>
