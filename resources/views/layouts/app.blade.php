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

    @livewireStyles
</head>
<body class="h-screen">

<div class="h-full lg:flex">

    @include('layouts.sidebar')

    <div id="sidebar-backdrop" class="fixed inset-0 bg-sigedra-medium-bg bg-opacity-50 z-50 hidden"></div>

    <!-- ===== Content Area ===== -->
    <div id="main-content-area" class="flex-1 flex flex-col h-full lg:ms-64 overflow-y-scroll" x-data="{ isViewingSession: false, sessionId: null }" @view-changed.window="isViewingSession = $event.detail.isViewingSession; sessionId = $event.detail.sessionId">
        <!-- Primary Header -->
        <header class="sticky top-0 z-10 h-[70px] flex-shrink-0 bg-sigedra-light-colored-bg border-b flex items-center">
            <div class="container mx-auto px-4 flex items-center justify-between h-full">
                <div class="flex items-center min-w-0">
                    <!-- Mobile Menu Toggle -->
                    <button type="button" id="mobile-menu-toggle" class="lg:hidden text-sigedra-text-medium hover:text-sigedra-text-dark me-4 flex-shrink-0">
                        <span class="sr-only">Toggle Navigation</span>
                        <i class="ph ph-list text-xl"></i>
                    </button>
                    <!-- Breadcrumbs -->
                    <div id="breadcrumbs-container" class="w-full text-base text-sigedra-text-medium whitespace-nowrap truncate">
                        @yield('breadcrumbs')
                    </div>
                </div>
                <div class="ms-4 flex items-center gap-x-2 md:gap-x-4">


                    <!-- Help Button -->
                    <x-secondary-button href="#" class="h-8 w-8 md:h-auto md:w-auto md:px-3 md:py-2">
                        <i class="ph ph-question text-xl"></i>
                        <span class="hidden sm:inline">Ayuda</span>
                    </x-secondary-button>

                    <!-- User Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        @php
                        $userName = Auth::user()->name;
                        $userEmail = Auth::user()->email;
                        $userInitials = collect(explode(' ', $userName))->map(function ($word) {
                            return mb_substr($word, 0, 1);
                        })->take(2)->implode('');

                        $user = auth()->user();
                        $user->loadMissing('maestro');
                        $isMaestro = $user?->roles->contains('id', 2) ?? false;
                        $maestroModelId = $user->maestro->id ?? null;

                        $profileLink = '#'; // Default link
                        if ($isMaestro && $maestroModelId) {
                            $profileLink = route('maestros.show', $maestroModelId);
                        }
                        @endphp
                        <button @click="open = !open" class="flex items-center gap-x-2 focus:outline-none rounded-md">
                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-200 text-sigedra-text-dark">
                                <span class="text-sm font-semibold">{{ $userInitials }}</span>
                            </span>
                            <p class="hidden md:block text-sm font-semibold text-sigedra-text-dark">{{ $userName }}</p>
                            <i class="ph ph-caret-down text-sm text-sigedra-text-dark hidden md:block"></i>
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
                                    <p class="text-sm font-semibold text-sigedra-text-dark">{{ $userName }}</p>
                                    <p class="text-xs text-sigedra-text-medium">{{ $userEmail }}</p>
                                </div>
                                <div class="h-px bg-gray-200 my-1"></div>
                                <a href="{{ $profileLink }}" class="flex items-center gap-x-3 px-3 py-2 text-sm text-sigedra-text-dark rounded-md hover:bg-gray-100">
                                    <i class="ph ph-user-circle text-lg text-sigedra-text-medium"></i>
                                    <span>Mi Perfil</span>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Offline Indicator  id="offline-indicator" -->
        <div class="bg-red-600 text-white py-3">
            <p class="flex items-center justify-center gap-2">
                <i class="ph ph-wifi-x text-lg"></i>
                <span class="text-base md:text-lg text-left">
            Estás sin conexión...<span class="hidden md:inline">. Los cambios podrían no guardarse.</span>
        </span>
            </p>
        </div>

        <!-- Secondary Header -->
        @hasSection('module_title')
        <header class="bg-sigedra-light-bg shadow-sm" x-show="!isViewingSession" x-cloak>
            <div class="container mx-auto px-4 py-5 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-sigedra-text-medium leading-tight">
                        @yield('module_title')
                    </h1>
                    @if(Request::route()->getName() !== 'dashboard')
                    <p class="text-base text-sigedra-text-medium mt-1">
                        @yield('module_subtitle')
                    </p>
                    @endif
                </div>
                <div class="hidden sm:block">
                    @yield('header_actions')
                </div>
            </div>
        </header>
        @endif

        <!-- Main Content -->
        <main class="flex-grow bg-sigedra-bg">
            <div class="container mx-auto px-4 pb-24">
                @if (session('success'))
                    <x-alert type="success">{{ session('success') }}</x-alert>
                @endif

                @if (session('error'))
                    <x-alert type="error">{{ session('error') }}</x-alert>
                @endif

                @if (session('info'))
                    <x-alert type="info">{{ session('info') }}</x-alert>
                @endif

                @if (session('warning'))
                <x-alert type="warning">{{ session('warning') }}</x-alert>
                @endif

                @yield('content')
                {{ $slot ?? '' }}
            </div>
        </main>
    </div>
    <!-- ===== End Content Area ===== -->
</div>

<!-- Mobile Footer Actions -->
@hasSection('footer_actions')
<div class="block md:hidden fixed bottom-0 left-0 w-full bg-sigedra-light-bg border-t p-4 z-20">
    <div class="container mx-auto">
        @yield('footer_actions')
    </div>
</div>
@endif

@livewireScripts
@stack('scripts')
<script>
    document.addEventListener('livewire:navigated', () => {
        window.Livewire.dispatch('remount');
    })
</script>

</body>
</html>
