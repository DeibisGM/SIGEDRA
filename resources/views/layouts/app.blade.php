<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIGEDRA - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css" />

    <!-- Scripts y Estilos -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.HSStaticMethods) {
                window.HSStaticMethods.autoInit();
            }
        });
    </script>
</head>
<body class="h-screen overflow-hidden">

<div class="h-full lg:flex">

    <aside id="application-sidebar" class="hs-overlay [--auto-close:lg] hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform hidden fixed z-[60] w-64 bg-white border-e flex flex-col lg:flex lg:translate-x-0 lg:end-auto h-full">
        <header class="h-[70px] flex-shrink-0 flex items-center px-6 border-b bg-sigedra-light-colored-bg">
            <a class="flex items-center text-xl font-bold text-sigedra-secondary" href="{{ route('home') }}">
                SIGEDRA
            </a>
        </header>

        @php
        $navLinks = [
            ['route' => 'home', 'icon' => 'ph-squares-four', 'label' => 'Inicio'],
            ['route' => 'attendance.index', 'icon' => 'ph-calendar-check', 'label' => 'Asistencia'],
            ['route' => 'estudiantes.index', 'icon' => 'ph-users', 'label' => 'Estudiantes'],
            ['route' => 'profesores.index', 'icon' => 'ph-chalkboard-teacher', 'label' => 'Profesores'],
            ['route' => 'reportes.index', 'icon' => 'ph-chart-bar', 'label' => 'Reportes'],
            ['route' => '#', 'icon' => 'ph-exam', 'label' => 'Notas'],
            ['route' => '#', 'icon' => 'ph-backpack', 'label' => 'Grado'],
            ['route' => '#', 'icon' => 'ph-book', 'label' => 'Materias'],
            ['route' => '#', 'icon' => 'ph-file-text', 'label' => 'Bitacora'],
        ];
        @endphp


        <!-- Navigation -->
        <nav class="flex-1 p-4 overflow-y-auto">
            <ul class="space-y-2">
                @foreach ($navLinks as $link)
                <li>
                    <a href="{{ $link['route'] == '#' ? '#' : route($link['route']) }}"
                       @class([
                           'flex items-center gap-x-3.5 py-2 px-3.5 rounded-lg text-base transition-colors duration-200',
                           'bg-sigedra-input text-sigedra-primary font-semibold' => request()->routeIs($link['route']) && $link['route'] != '#',
                           'text-sigedra-text-medium opacity-50 cursor-not-allowed' => $link['route'] == '#',
                           'text-sigedra-text-medium hover:bg-sigedra-input hover:text-sigedra-primary' => $link['route'] != '#' && !request()->routeIs($link['route']),
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
            <form method="POST" action="#">
                @csrf
                <button type="submit" class="w-full flex items-center gap-x-3 py-2 px-3.5 rounded-lg text-base text-sigedra-text-medium hover:bg-red-50 hover:text-sigedra-error">
                    <i class="ph ph-sign-out text-2xl"></i>
                    <span class="font-medium">Cerrar Sesión</span>
                </button>
            </form>
        </footer>
    </aside>


    <!-- ===== Content Area ===== -->
    <div class="flex-1 flex flex-col h-full lg:ms-64 overflow-y-scroll">
        <!-- Module Title Header -->
        <header class="sticky top-0 z-10 h-[70px] flex-shrink-0 bg-sigedra-light-colored-bg border-b flex items-center">
            <div class="container mx-auto px-6 flex items-center justify-between">
                <div class="flex items-center">
                    <!-- Mobile Menu Toggle -->
                    <button type="button" class="lg:hidden text-gray-500 hover:text-gray-600 me-4" data-hs-overlay="#application-sidebar" aria-controls="application-sidebar" aria-label="Toggle navigation">
                        <span class="sr-only">Toggle Navigation</span>
                        <i class="ph ph-list text-xl"></i>
                    </button>
                    <!-- El H1 ahora tomará los estilos base de app.css para consistencia -->
                    <h1>
                        @yield('module_title', 'Módulo')
                    </h1>
                </div>
                <div>
                    @yield('header_actions')
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow">
            <div class="container mx-auto px-6 py-8">
                @yield('content')
            </div>
        </main>
    </div>
    <!-- ===== End Content Area ===== -->
</div>

@livewireScripts
<script>
    document.addEventListener('livewire:navigated', () => {
        setTimeout(() => {
            window.HSStaticMethods.autoInit();
        }, 100);
    });
</script>
</body>
</html>
