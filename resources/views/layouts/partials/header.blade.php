<header class="sticky top-0 inset-x-0 flex flex-wrap sm:justify-start sm:flex-nowrap z-50 w-full bg-white border-b border-sigedra-border text-sm py-3 sm:py-0">
    <nav class="relative max-w-7xl w-full mx-auto px-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8" aria-label="Global">
        <div class="flex items-center justify-between">
            <a class="flex-none text-xl font-semibold text-sigedra-secondary" href="{{ route('home') }}" aria-label="Brand">SIGEDRA</a>
            <div class="sm:hidden">
                <button type="button" class="hs-overlay-toggle p-2 inline-flex justify-center items-center gap-x-2 rounded-lg border bg-white text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm" data-hs-overlay="#application-sidebar" aria-controls="application-sidebar" aria-label="Toggle navigation">
                    <span class="sr-only">Toggle Navigation</span>
                    <svg class="hs-overlay-open:hidden flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
                    <svg class="hs-overlay-open:block hidden flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>
        </div>
        <div id="navbar-collapse-with-animation" class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow sm:block">
            <div class="flex flex-col gap-y-4 gap-x-0 mt-5 sm:flex-row sm:items-center sm:justify-end sm:gap-y-0 sm:gap-x-7 sm:mt-0 sm:ps-7">
                @auth
                <div class="hs-dropdown relative inline-flex [--placement:bottom-right]">
                    <button id="hs-dropdown-with-header" type="button" class="hs-dropdown-toggle inline-flex items-center gap-x-2">
                        <img class="inline-block h-9 w-9 rounded-full object-cover ring-2 ring-offset-2 ring-sigedra-primary" src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=2960&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Avatar del usuario">
                    </button>

                    <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-[15rem] bg-white border border-sigedra-border rounded-lg p-2 mt-2" aria-labelledby="hs-dropdown-with-header">
                        <div class="py-3 px-5 -m-2 bg-gray-100 rounded-t-lg">
                            <p class="text-sm text-sigedra-text-medium">Autenticado como</p>
                            <p class="text-sm font-medium text-sigedra-text-dark">{{ Auth::user()->name }}</p>
                        </div>
                        <div class="mt-2 py-2 first:pt-0 last:pb-0">
                            <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500" href="#">
                                Mi Perfil
                            </a>
                            <form method="POST" action="#">
                                @csrf
                                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                                    Cerrar Sesión
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <a class="flex items-center gap-x-2 font-medium text-gray-500 hover:text-sigedra-primary sm:border-s sm:border-gray-300 sm:my-6 sm:ps-6" href="#">
                    Iniciar Sesión
                </a>
                @endauth
            </div>
        </div>
    </nav>
</header>
