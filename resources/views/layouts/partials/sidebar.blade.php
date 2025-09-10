<div id="application-sidebar" class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform hidden fixed top-0 start-0 bottom-0 z-[60] w-64 bg-white border-e border-sigedra-border flex flex-col lg:block lg:translate-x-0 lg:end-auto lg:bottom-0">
    <!-- Logo y Título -->
    <div class="px-6 pt-7">
        <a class="flex-none flex items-center gap-x-3 text-2xl font-bold text-sigedra-secondary" href="{{ route('home') }}" aria-label="Brand">
            <i class="ph-fill ph-student text-3xl text-sigedra-primary"></i>
            SIGEDRA
        </a>
    </div>

    <!-- Navegación Principal -->
    <nav class="p-6 w-full flex-grow">
        <ul class="space-y-1.5">
            <li>
                <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                    <i class="ph ph-squares-four text-xl"></i>
                    Dashboard
                </x-nav-link>
            </li>
            <li>
                <x-nav-link href="{{ route('attendance.index') }}" :active="request()->routeIs('attendance.index')">
                    <i class="ph ph-calendar-check text-xl"></i>
                    Asistencia
                </x-nav-link>
            </li>
            <li>
                <x-nav-link href="#" :active="request()->routeIs('reports.*')">
                    <i class="ph ph-chart-bar text-xl"></i>
                    Reportes
                </x-nav-link>
            </li>
            <li>
                <x-nav-link href="#" :active="request()->routeIs('students.*')">
                    <i class="ph ph-users text-xl"></i>
                    Estudiantes
                </x-nav-link>
            </li>
            <li>
                <x-nav-link href="#">
                    <i class="ph ph-gear text-xl"></i>
                    Ajustes
                </x-nav-link>
            </li>
        </ul>
    </nav>

    <!-- Perfil de Usuario (al final) -->
    <div class="p-6 mt-auto">
        <div class="hs-dropdown relative inline-flex w-full [--placement:top-left]">
            <button id="hs-dropdown-with-header" type="button" class="hs-dropdown-toggle w-full flex items-center gap-x-3 py-2 px-3 rounded-lg text-base text-sigedra-text-medium hover:bg-sigedra-input/70">
                <img class="inline-block h-9 w-9 rounded-full object-cover" src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=2960&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Avatar del usuario">
                <span class="flex-grow text-start font-medium">@auth {{ Auth::user()->name }} @else Usuario @endauth</span>
                <i class="ph ph-caret-up-down text-lg"></i>
            </button>

            <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-[15rem] bg-white border border-sigedra-border rounded-lg p-2 mb-2" aria-labelledby="hs-dropdown-with-header">
                <div class="py-3 px-5 -m-2 bg-gray-100 rounded-t-lg">
                    <p class="text-sm text-sigedra-text-medium">Autenticado como</p>
                    <p class="text-sm font-medium text-sigedra-text-dark">@auth {{ Auth::user()->name }} @else Usuario @endauth</p>
                </div>
                <div class="mt-2 py-2 first:pt-0 last:pb-0">
                    <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100" href="#">
                        Mi Perfil
                    </a>
                    <form method="POST" action="#">
                        @csrf
                        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-red-600 hover:bg-red-50" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                            Cerrar Sesión
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
