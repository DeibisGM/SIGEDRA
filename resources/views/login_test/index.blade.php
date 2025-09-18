<x-login-test-layout>
    <div>
        <a href="{{ route('home') }}" class="flex justify-center items-center mb-6">
            <h1 class="text-4xl font-bold text-sigedra-secondary">SIGEDRA</h1>
        </a>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg border border-sigedra-border">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-sigedra-primary">Bienvenido de Vuelta</h2>
            <p class="text-sm text-sigedra-text-medium mt-1">Ingresa tus credenciales para acceder al sistema.</p>
        </div>

        <form action="#" method="POST" class="space-y-6">
            @csrf

            <!-- Cédula -->
            <div>
                <x-input-label for="cedula" value="Cédula" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3.5">
                        <i class="ph ph-user text-lg text-sigedra-text-light"></i>
                    </div>
                    <x-text-input id="cedula" name="cedula" type="text" class="ps-10 w-full" placeholder="0-0000-0000" required autofocus />
                </div>
            </div>

            <!-- Contraseña -->
            <div>
                <div class="flex items-center justify-between">
                    <x-input-label for="password" value="Contraseña" />
                    <a href="#" class="text-sm text-sigedra-primary hover:underline font-medium">¿Olvidó su contraseña?</a>
                </div>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3.5">
                        <i class="ph ph-lock-key text-lg text-sigedra-text-light"></i>
                    </div>
                    <x-text-input id="password" name="password" type="password" class="ps-10 w-full" placeholder="••••••••" required />
                </div>
            </div>

            <!-- Botón de Inicio de Sesión -->
            <div>
                <x-buttons.primary class="w-full justify-center text-base py-2.5">
                    <span>Iniciar Sesión</span>
                </x-buttons.primary>
            </div>
        </form>
    </div>
</x-login-test-layout>
