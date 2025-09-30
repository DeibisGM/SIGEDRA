<header class="sticky top-0 z-40 h-[70px] flex-shrink-0 bg-sigedra-light-colored-bg border-b border-sigedra-border flex items-center">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-full">
        <div class="flex items-center min-w-0">
            <!-- Mobile Menu Toggle -->
            <button type="button" id="mobile-menu-toggle" class="lg:hidden text-sigedra-text-medium hover:text-gray-600 me-4 flex-shrink-0">
                <span class="sr-only">Toggle Navigation</span>
                <i class="ph ph-list text-xl"></i>
            </button>
            <!-- Breadcrumbs -->
            <div x-show="!isViewingSession" class="hidden sm:block w-full text-base text-sigedra-text-medium whitespace-nowrap truncate">
                @yield('breadcrumbs')
            </div>
            <div x-show="isViewingSession" x-cloak class="w-full text-base text-sigedra-text-medium whitespace-nowrap truncate">
                <a href="{{ route('attendance.index') }}" class="hover:text-gray-700">Asistencia</a>
                <span class="mx-2">/</span>
                <span @click="$dispatch('close-session-view')" class="cursor-pointer hover:text-gray-700">Historial</span>
                <span class="mx-2">/</span>
                <span class="font-semibold text-sigedra-primary" x-text="sessionId"></span>
            </div>
        </div>
        <div class="ms-4 flex items-center gap-x-2 md:gap-x-4">
            <!-- User Dropdown -->
            <div x-data="{ open: false }" class="relative">
                @php
                $userName = Auth::user()->name;
                $userInitials = collect(explode(' ', $userName))->map(fn($word) => mb_substr($word, 0, 1))->take(2)->implode('');
                @endphp


                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-56 bg-sigedra-card rounded-md shadow-lg border border-sigedra-border z-20" style="display: none;">
                    <div class="p-2">
                        <div class="px-3 py-2">
                            <p class="text-sm font-semibold text-sigedra-text-dark">{{ $userName }}</p>
                            <p class="text-xs text-sigedra-text-medium">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="h-px bg-sigedra-border my-1"></div>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-x-3 px-3 py-2 text-sm text-sigedra-text-dark rounded-md hover:bg-sigedra-input">
                            <i class="ph ph-user-circle text-lg text-sigedra-text-medium"></i>
                            <span>Mi Perfil</span>
                        </a>
                        <div class="h-px bg-sigedra-border my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-x-3 px-3 py-2 text-sm text-sigedra-error rounded-md hover:bg-red-50">
                                <i class="ph ph-sign-out text-lg"></i>
                                <span>Cerrar Sesión</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</header>
