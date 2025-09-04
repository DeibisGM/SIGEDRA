<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIGEDRA - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts y Estilos -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
{{-- CAMBIO DE ACCESIBILIDAD: Se añade la clase text-base para aumentar el tamaño de fuente por defecto. --}}
<body class="bg-sigedra-bg font-sans text-sigedra-text-dark antialiased text-base">
    <header class="bg-sigedra-card border-b border-sigedra-border sticky top-0 z-40">
        <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo y Navegación Principal -->
                <div class="flex items-center gap-10">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-sigedra-text-dark tracking-wider">SIGEDRA</a>
                    <div class="hidden md:flex items-center gap-8">
                        {{-- CAMBIO DE ACCESIBILIDAD: Se aumenta el tamaño de fuente de los enlaces de text-sm a text-base. --}}
                        <a href="{{ route('home') }}" class="text-base font-medium text-sigedra-text-medium hover:text-sigedra-primary transition-colors">Inicio</a>
                        <a href="{{ route('attendance.index') }}" class="text-base font-semibold text-sigedra-primary relative">
                            Asistencia
                            <span class="absolute -bottom-2 left-0 w-full h-0.5 bg-sigedra-primary rounded-full"></span>
                        </a>
                        <a href="#" class="text-base font-medium text-sigedra-text-medium hover:text-sigedra-primary transition-colors">Reportes</a>
                        <a href="#" class="text-base font-medium text-sigedra-text-medium hover:text-sigedra-primary transition-colors">Estudiantes</a>
                    </div>
                </div>
                <!-- Perfil de Usuario -->
                <div class="flex items-center">
                    <img class="h-9 w-9 rounded-full object-cover" src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=2960&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Avatar del usuario">
                </div>
            </div>
        </nav>
    </header>

    {{-- Se añade padding-bottom para el footer fijo --}}
    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 pb-24">
        @yield('content')
    </main>

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/preline@2.0.3/dist/preline.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => window.HSStaticMethods?.autoInit());
    </script>
</body>
</html>
