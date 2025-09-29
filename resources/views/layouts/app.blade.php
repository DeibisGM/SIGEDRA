<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIGEDRA - @yield('title')</title>

    <link rel="icon" href="{{ asset('images/icon.svg') }}" type="image/svg+xml">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts y Estilos -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- AÑADE ESTA LÍNEA PARA LOS ESTILOS DE LIVEWIRE --}}
    @livewireStyles
</head>
<body class="h-screen">

<div class="h-full lg:flex">

    <aside id="application-sidebar" class="-translate-x-full transition-all duration-300 transform fixed z-[60] w-full lg:w-64 bg-white border-e flex flex-col lg:flex lg:translate-x-0 lg:end-auto h-full">
        <header class="h-[70px] flex-shrink-0 flex items-center justify-between px-6 border-b bg-sigedra-light-colored-bg">
            <a class="flex items-center" href="{{ route('dashboard') }}">
                <img src="{{ asset('images/logo.svg') }}" alt="SIGEDRA Logo" class="h-[1.2rem]">
            </a>
            <button type="button" id="sidebar-close-button" class="lg:hidden text-gray-500 hover:text-gray-600">
                <i class="ph ph-x text-xl"></i>
            </button>
        </header>

        @php
        $navLinks = [
        ['route' => 'dashboard', 'active_pattern' => 'dashboard', 'icon' => 'ph-squares-four', 'label' => 'Inicio'],
        ['route' => 'attendance.index', 'active_pattern' => 'attendance.*', 'icon' => 'ph-calendar-check', 'label' => 'Asistencia'],
        ['route' => 'estudiantes.index', 'active_pattern' => 'estudiantes.*', 'icon' => 'ph-users', 'label' => 'Estudiantes'],
        ['route' => 'maestros.index', 'active_pattern' => 'maestros.*', 'icon' => 'ph-chalkboard-teacher', 'label' => 'Maestros'],
        ['route' => 'reportes.index', 'active_pattern' => 'reportes.*', 'icon' => 'ph-chart-bar', 'label' => 'Reportes'],
        ['route' => 'bitacora.index', 'active_pattern' => 'bitacora.*', 'icon' => 'ph-book', 'label' => 'Bitacora'],
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
            <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar" onsubmit="event.preventDefault(); console.log('Logout form submitted (sidebar)'); this.submit(); setTimeout(() => { console.log('Redirecting to /login (sidebar)'); window.location.replace('/login'); }, 100);">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="w-full flex items-center gap-x-3 py-2 px-3.5 rounded-lg text-base text-sigedra-text-medium hover:bg-red-50 hover:text-sigedra-error">
                    <i class="ph ph-sign-out text-2xl"></i>
                    <span class="font-medium">Cerrar Sesión</span>
                </button>
            </form>
        </footer>
    </aside>

    <div id="sidebar-backdrop" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 hidden"></div>

    <!-- ===== Content Area ===== -->
    <div id="main-content-area" class="flex-1 flex flex-col h-full lg:ms-64 overflow-y-scroll" x-data="{ isViewingSession: false, sessionId: null }" @view-changed.window="isViewingSession = $event.detail.isViewingSession; sessionId = $event.detail.sessionId">
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
                    <div x-show="!isViewingSession" class="w-full text-base text-gray-500 whitespace-nowrap truncate">
                        @yield('breadcrumbs')
                    </div>
                    <div x-show="isViewingSession" x-cloak class="w-full text-base text-gray-500 whitespace-nowrap truncate">
                        <a href="{{ route('attendance.index') }}" class="hover:text-gray-700">Asistencia</a>
                        <span class="mx-2">/</span>
                        <span @click="$dispatch('close-session-view')" class="cursor-pointer hover:text-gray-700">Historial de asistencia</span>
                        <span class="mx-2">/</span>
                        <span x-text="sessionId"></span>
                    </div>
                </div>
                <div class="ms-4 flex items-center gap-x-2 md:gap-x-4">
                    <!-- User Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        @php
                        $userName = Auth::user()->name;
                        $userEmail = Auth::user()->email;
                        $userInitials = collect(explode(' ', $userName))->map(function ($word) {
                        return mb_substr($word, 0, 1);
                        })->take(2)->implode('');
                        @endphp
                        <button @click="open = !open" class="flex items-center gap-x-2 focus:outline-none rounded-md hover:bg-gray-100">
                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-200 text-gray-700">
                                <span class="text-sm font-semibold">{{ $userInitials }}</span>
                            </span>
                            <p class="hidden md:block text-sm font-semibold text-gray-800">{{ $userName }}</p>
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
                                    <p class="text-sm font-semibold text-gray-800">{{ $userName }}</p>
                                    <p class="text-xs text-gray-500">{{ $userEmail }}</p>
                                </div>
                                <div class="h-px bg-gray-200 my-1"></div>
                                <a href="#" class="flex items-center gap-x-3 px-3 py-2 text-sm text-gray-700 rounded-md hover:bg-gray-100">
                                    <i class="ph ph-user-circle text-lg text-gray-500"></i>
                                    <span>Mi Perfil</span>
                                </a>
                                <div class="h-px bg-gray-200 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}" id="logout-form-dropdown" onsubmit="event.preventDefault(); console.log('Logout form submitted (dropdown)'); this.submit(); setTimeout(() => { console.log('Redirecting to /login (dropdown)'); window.location.replace('/login'); }, 100);">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="w-full flex items-center gap-x-3 px-3 py-2 text-sm text-red-600 rounded-md hover:bg-red-50">
                                        <i class="ph ph-sign-out text-lg"></i>
                                        <span>Cerrar Sesión</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Help Button -->
                    <a href="#" class="flex items-center justify-center md:justify-start h-8 w-8 md:h-auto md:w-auto md:px-3 md:py-2 md:gap-2 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 border rounded-lg transition-colors">
                        <i class="ph ph-question text-xl"></i>
                        <span class="hidden sm:inline">Ayuda</span>
                    </a>
                </div>
            </div>
        </header>

        @hasSection('module_title')
        <header class="bg-white shadow-sm" x-show="!isViewingSession" x-cloak>
            <div class="container mx-auto px-4 py-5 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-gray-800 leading-tight">
                        @yield('module_title')
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
        @endif


        <!-- Main Content -->
        <main class="flex-grow bg-sigedra-bg">
            <div class="container mx-auto px-4 pb-24" :class="isViewingSession ? 'py-5' : 'py-0'">
                @yield('content')
                {{ $slot ?? '' }}
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

{{-- ESTA LÍNEA YA LA TENÍAS, PERO ES CRUCIAL PARA LOS SCRIPTS DE LIVEWIRE --}}
@livewireScripts

</body>
</html>
