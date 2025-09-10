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
    @livewireStyles
</head>
<body class="bg-sigedra-bg font-sans text-sigedra-text-dark antialiased text-base h-screen overflow-hidden">

<div class="pt-2 h-full lg:flex">
    <!-- ===== Sidebar ===== -->
    <aside id="application-sidebar" class="hs-overlay [--auto-close:lg] hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform hidden fixed top-2 start-0 bottom-2 z-[60] w-64 bg-white border-e border-sigedra-border flex-col lg:flex lg:translate-x-0 lg:end-auto">
        <!-- Logo Header -->
        <header class="h-[60px] flex-shrink-0 flex items-center px-6 border-b border-sigedra-border">
            <a class="flex items-center text-xl font-bold text-sigedra-secondary" href="{{ route('home') }}">
                SIGEDRA
            </a>
        </header>

        <!-- Navigation -->
        <nav class="flex-grow p-4 overflow-y-auto">
            <ul class="space-y-1">
                @php
                $navLinks = [
                ['route' => 'home', 'icon' => 'ph-squares-four', 'label' => 'Dashboard'],
                ['route' => 'attendance.index', 'icon' => 'ph-calendar-check', 'label' => 'Asistencia'],
                ['route' => '#', 'icon' => 'ph-chart-bar', 'label' => 'Reportes'],
                ['route' => '#', 'icon' => 'ph-users', 'label' => 'Estudiantes'],
                ['route' => '#', 'icon' => 'ph-gear', 'label' => 'Ajustes'],
                ];
                @endphp

                @foreach ($navLinks as $link)
                <li>
                    <a href="{{ $link['route'] == '#' ? '#' : route($link['route']) }}"
                       class="flex items-center gap-x-3.5 py-2 px-3.5 rounded-lg text-base transition-colors duration-200
                                      {{ request()->routeIs($link['route']) ? 'bg-sigedra-input text-sigedra-secondary font-semibold' : 'text-sigedra-text-medium hover:bg-sigedra-input hover:text-sigedra-secondary' }}">
                        <i class="ph {{ $link['icon'] }} text-2xl"></i>
                        <span>{{ $link['label'] }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </nav>

        <!-- Sidebar Footer -->
        <footer class="p-4 flex-shrink-0 border-t border-sigedra-border">
            <form method="POST" action="#">
                @csrf
                <button type="submit" class="w-full flex items-center gap-x-3 py-2 px-3.5 rounded-lg text-base text-sigedra-text-medium hover:bg-red-50 hover:text-sigedra-error">
                    <i class="ph ph-sign-out text-2xl"></i>
                    <span class="font-medium">Cerrar Sesión</span>
                </button>
            </form>
        </footer>
    </aside>
    <!-- ===== End Sidebar ===== -->

    <!-- ===== Content Area ===== -->
    <div class="flex-1 flex flex-col h-full lg:ms-64">
        <!-- Module Title Header -->
        <header class="h-[60px] flex-shrink-0 bg-white border-b border-sigedra-border flex items-center px-6">
            <!-- Mobile Menu Toggle -->
            <button type="button" class="lg:hidden text-gray-500 hover:text-gray-600 me-4" data-hs-overlay="#application-sidebar" aria-controls="application-sidebar" aria-label="Toggle navigation">
                <span class="sr-only">Toggle Navigation</span>
                <i class="ph ph-list text-2xl"></i>
            </button>
            <h1 class="text-xl font-bold text-sigedra-text-dark">
                @yield('module_title', 'Módulo')
            </h1>
        </header>

        <!-- Main Content -->
        <main class="flex-grow overflow-y-auto">
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
