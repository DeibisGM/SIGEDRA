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

    <aside id="application-sidebar" class="-translate-x-full transition-all duration-300 transform fixed z-[60] w-full lg:w-64 bg-white border-e flex flex-col lg:flex lg:translate-x-0 lg:end-auto h-full">
        <header class="h-[70px] flex-shrink-0 flex items-center justify-between px-6 border-b bg-sigedra-light-colored-bg">
            <a class="flex items-center text-xl font-bold text-sigedra-secondary" href="{{ route('home') }}">
                SIGEDRA
            </a>
            <button type="button" id="sidebar-close-button" class="lg:hidden text-gray-500 hover:text-gray-600">
                <i class="ph ph-x text-xl"></i>
            </button>
        </header>

        @php
        $navLinks = [
            ['route' => 'home', 'active_pattern' => 'home', 'icon' => 'ph-squares-four', 'label' => 'Inicio'],
            ['route' => 'attendance.index', 'active_pattern' => 'attendance.*', 'icon' => 'ph-calendar-check', 'label' => 'Asistencia'],
            ['route' => 'estudiantes.index', 'active_pattern' => 'estudiantes.*', 'icon' => 'ph-users', 'label' => 'Estudiantes'],
            ['route' => 'profesores.index', 'active_pattern' => 'profesores.*', 'icon' => 'ph-chalkboard-teacher', 'label' => 'Profesores'],
            ['route' => 'reportes.index', 'active_pattern' => 'reportes.*', 'icon' => 'ph-chart-bar', 'label' => 'Reportes'],
            ['route' => '#', 'active_pattern' => '', 'icon' => 'ph-exam', 'label' => 'Notas'],
            ['route' => '#', 'active_pattern' => '', 'icon' => 'ph-backpack', 'label' => 'Grado'],
            ['route' => '#', 'active_pattern' => '', 'icon' => 'ph-book', 'label' => 'Materias'],
            ['route' => '#', 'active_pattern' => '', 'icon' => 'ph-file-text', 'label' => 'Bitacora'],
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
                           'bg-sigedra-input text-sigedra-primary font-semibold' => $link['route'] != '#' && request()->routeIs($link['active_pattern']),
                           'text-sigedra-text-medium opacity-50 cursor-not-allowed' => $link['route'] == '#',
                           'text-sigedra-text-medium hover:bg-sigedra-input hover:text-sigedra-primary' => $link['route'] != '#' && !request()->routeIs($link['active_pattern']),
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

    <div id="sidebar-backdrop" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 hidden"></div>

    <!-- ===== Content Area ===== -->
    <div class="flex-1 flex flex-col h-full lg:ms-64 overflow-y-scroll">
        <!-- Primary Header -->
        <header class="sticky top-0 z-10 h-[70px] flex-shrink-0 bg-sigedra-light-colored-bg border-b flex items-center">
            <div class="container mx-auto px-4 flex items-center justify-between h-full">
                <div class="flex items-center min-w-0">
                    <!-- Mobile Menu Toggle -->
                    <button type="button" id="mobile-menu-toggle" class="lg:hidden text-gray-500 hover:text-gray-600 me-4 flex-shrink-0">
                        <span class="sr-only">Toggle Navigation</span>
                        <i class="ph ph-list text-xl"></i>
                    </button>
                    <!-- Breadcrumbs -->
                    @yield('breadcrumbs')
                </div>
                <div class="ms-4 flex items-center gap-x-4">
                    <!-- User Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-x-2 focus:outline-none p-1 rounded-md hover:bg-gray-100">
                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-200 text-gray-700">
                                <span class="text-sm font-semibold">DG</span>
                            </span>
                            <p class="hidden md:block text-sm font-semibold text-gray-800">Deibis Gutierrez</p>
                            <i class="ph ph-caret-down text-sm text-gray-500 hidden md:block"></i>
                        </button>

                        <div x-show="open"
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg border border-sigedra-border z-20"
                             style="display: none;">
                            <div class="p-2">
                                <div class="px-3 py-2">
                                    <p class="text-sm font-semibold text-gray-800">Deibis Gutierrez</p>
                                    <p class="text-xs text-gray-500">maestro@sigedra.com</p>
                                </div>
                                <div class="h-px bg-gray-200 my-1"></div>
                                <a href="#" class="flex items-center gap-x-3 px-3 py-2 text-sm text-gray-700 rounded-md hover:bg-gray-100">
                                    <i class="ph ph-user-circle text-lg text-gray-500"></i>
                                    <span>Mi Perfil</span>
                                </a>
                                <div class="h-px bg-gray-200 my-1"></div>
                                <form method="POST" action="#">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-x-3 px-3 py-2 text-sm text-red-600 rounded-md hover:bg-red-50">
                                        <i class="ph ph-sign-out text-lg"></i>
                                        <span>Cerrar Sesión</span>
                                    </button>
                                </form>
                            </div>
                        </div>
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
            <div class="container mx-auto px-4 py-5 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-gray-800 leading-tight">
                        @yield('module_title', 'Módulo')
                    </h1>
                    <p class="text-base text-gray-500 mt-1">
                        @yield('module_subtitle', '')
                    </p>
                </div>
                <div class="hidden sm:block">
                    @yield('header_actions')
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow">
            <div class="container mx-auto px-4 py-4 pb-24">
                @yield('content')
            </div>
        </main>
    </div>
    <!-- ===== End Content Area ===== -->
</div>

<!-- Mobile Footer Actions -->
@hasSection('footer_actions')
<div class="block md:hidden fixed bottom-0 left-0 w-full bg-white border-t p-4 z-20">
    <div class="container mx-auto">
        @yield('footer_actions')
    </div>
</div>
@endif

@livewireScripts

</body>
</html>
