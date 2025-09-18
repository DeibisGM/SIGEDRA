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
</head>
<body class="h-screen">

<div class="h-full lg:flex">

    {{-- CAMBIO: Sidebar "quemado" - Se eliminan las clases de transición y se muestra permanentemente --}}
    <aside class="fixed z-[60] w-64 bg-white border-e flex flex-col h-full">
        <header class="h-[70px] flex-shrink-0 flex items-center justify-between px-6 border-b bg-sigedra-light-colored-bg">
            <a class="flex items-center text-xl font-bold text-sigedra-secondary" href="#">
                SIGEDRA
            </a>
        </header>

        @php
        $navLinks = [
        ['route' => '#', 'active_pattern' => '', 'icon' => 'ph-squares-four', 'label' => 'Inicio'],
        ['route' => '#', 'active_pattern' => '', 'icon' => 'ph-calendar-check', 'label' => 'Asistencia'],
        ['route' => '#', 'active_pattern' => 'pdf.preview', 'icon' => 'ph-users', 'label' => 'Estudiantes'],
        ['route' => '#', 'active_pattern' => '', 'icon' => 'ph-chalkboard-teacher', 'label' => 'Profesores'],
        ['route' => '#', 'active_pattern' => '', 'icon' => 'ph-chart-bar', 'label' => 'Reportes'],
        ['route' => '#', 'active_pattern' => '', 'icon' => 'ph-file-text', 'label' => 'Bitácora'],
        ['route' => '#', 'active_pattern' => 'login.test', 'icon' => 'ph-sign-in', 'label' => 'Módulo Prueba Login'],
        ['route' => '#', 'active_pattern' => '', 'icon' => 'ph-printer', 'label' => 'Vista para PDF'],
        ['route' => '#', 'active_pattern' => '', 'icon' => 'ph-exam', 'label' => 'Notas'],
        ['route' => '#', 'active_pattern' => '', 'icon' => 'ph-backpack', 'label' => 'Grado'],
        ['route' => '#', 'active_pattern' => '', 'icon' => 'ph-book', 'label' => 'Materias'],
        ];
        @endphp

        <!-- Navigation -->
        <nav class="flex-1 p-4 overflow-y-auto">
            <ul class="space-y-2">
                @foreach ($navLinks as $link)
                <li>
                    {{-- Para el ejemplo, marcaremos "Estudiantes" como activo --}}
                    <a href="#"
                       @class([
                    'flex items-center gap-x-3.5 py-2 px-3.5 rounded-lg text-base transition-colors duration-200',
                    'bg-sigedra-input text-sigedra-primary font-semibold' => $link['active_pattern'] === 'pdf.preview',
                    'text-sigedra-text-medium opacity-50 cursor-not-allowed' => $link['route'] == '#',
                    'text-sigedra-text-medium' => $link['route'] != '#' && $link['active_pattern'] !== 'pdf.preview',
                    ])>
                    <i class="ph {{ $link['icon'] }} text-2xl"></i>
                    <span>{{ $link['label'] }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </nav>

        <!-- Sidebar Footer -->
        <footer class="p-4 flex-shrink-0 border-t mt-auto">
            <button type="submit" class="w-full flex items-center gap-x-3 py-2 px-3.5 rounded-lg text-base text-sigedra-text-medium hover:bg-red-50 hover:text-sigedra-error">
                <i class="ph ph-sign-out text-2xl"></i>
                <span class="font-medium">Cerrar Sesión</span>
            </button>
        </footer>
    </aside>

    {{-- CAMBIO: El área de contenido ahora tiene un margen izquierdo permanente para el sidebar --}}
    <div class="flex-1 flex flex-col h-full lg:ms-64 overflow-y-scroll">
        <!-- Header "quemado" -->
        <header class="sticky top-0 z-10 h-[70px] flex-shrink-0 bg-sigedra-light-colored-bg border-b flex items-center">
            <div class="container mx-auto px-4 flex items-center justify-between h-full">
                <!-- Breadcrumbs -->
                <div>
                    @yield('breadcrumbs')
                </div>
                <div class="ms-4 flex items-center gap-x-4">
                    <!-- User Info -->
                    <div class="flex items-center gap-x-2 p-1">
                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-200 text-gray-700">
                            <span class="text-sm font-semibold">DG</span>
                        </span>
                        <p class="hidden md:block text-sm font-semibold text-gray-800">Deibis Gutierrez</p>
                    </div>
                    <!-- Help Button -->
                    <a href="#" class="flex items-center gap-2 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 border rounded-lg px-3 py-2 transition-colors">
                        <i class="ph ph-question text-xl"></i>
                        <span class="hidden sm:inline">Ayuda</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Secondary Header -->
        <header class="bg-white shadow-sm">
            <div class="container mx-auto px-4 py-5">
                <h1 class="text-xl font-bold text-gray-800 leading-tight">
                    @yield('module_title', 'Módulo')
                </h1>
                <p class="text-base text-gray-500 mt-1">
                    @yield('module_subtitle', '')
                </p>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow bg-sigedra-bg">
            <div class="container mx-auto px-4 py-8">
                @yield('content')
            </div>
        </main>
    </div>
</div>

</body>
</html>
