<aside id="application-sidebar" class="-translate-x-full transition-all duration-300 transform fixed z-[60] w-full lg:w-64 bg-sigedra-bg border-e flex flex-col lg:translate-x-0 lg:end-auto h-full">
    <header class="h-[70px] flex-shrink-0 flex items-center justify-between px-6 border-b bg-sigedra-light-colored-bg">
        <a class="flex items-center" href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo.svg') }}" alt="Logo de SIGEDRA" class="h-[1.2rem]" />
        </a>
        <button type="button" id="sidebar-close-button" class="lg:hidden text-sigedra-text-medium hover:text-sigedra-text-dark">
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
    ['route' => 'bitacora.index', 'active_pattern' => 'bitacora.*', 'icon' => 'ph-book', 'label' => 'Bitácora'],
    ];
    @endphp

    <!-- Navigation -->
    <nav class="flex-1 p-4 overflow-y-auto">
        <ul class="space-y-2">
            @foreach ($navLinks as $link)
            <li>
                <a href="{{ route($link['route']) }}"
                   @class([
                'flex items-center gap-x-3.5 py-2 px-3.5 rounded-lg text-base transition-colors duration-200',
                'bg-sigedra-medium-bg text-sigedra-primary font-semibold' => request()->routeIs($link['active_pattern']),
                'text-sigedra-text-light hover:bg-sigedra-medium-bg hover:text-sigedra-primary' => !request()->routeIs($link['active_pattern']),
                ])>
                                <i @class([
                    'ph',
                    $link['icon'],
                    'text-2xl',
                    'ph-fill' => request()->routeIs($link['active_pattern']),
                ])></i>
                <span>{{ $link['label'] }}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </nav>

    <!-- Sidebar Footer -->
    <footer class="p-4 flex-shrink-0 border-t mt-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-x-3 py-2 px-3.5 rounded-lg text-base text-sigedra-text-medium hover:bg-red-50 hover:text-sigedra-error">
                <i class="ph ph-sign-out text-2xl"></i>
                <span class="font-medium">Cerrar Sesión</span>
            </button>
        </form>
    </footer>
</aside>
