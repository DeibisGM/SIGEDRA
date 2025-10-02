<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Cédula -->
        <div>
            <x-input-label for="cedula" :value="__('Cédula')" />
            <x-text-input id="cedula" class="block mt-1 w-full placeholder-gray-400" type="text" name="cedula" :value="old('cedula')" required autofocus autocomplete="username" placeholder="Tu cédula" />
            <x-input-error :messages="$errors->get('cedula')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full pr-10 placeholder-gray-400"
                              type="password"
                              name="password"
                              required autocomplete="current-password" placeholder="Tu contraseña" />
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                    <i id="togglePassword" class="ph ph-eye-slash text-sigedra-text-medium cursor-pointer" style="font-size: 1.2rem"></i>
                </div>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-sigedra-text-medium hover:text-sigedra-primary rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sigedra-primary dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif
        </div>

        <script>
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');

            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle icon class
                if (type === 'password') {
                    togglePassword.classList.remove('ph-eye');
                    togglePassword.classList.add('ph-eye-slash');
                } else {
                    togglePassword.classList.remove('ph-eye-slash');
                    togglePassword.classList.add('ph-eye');
                }
            });
        </script>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center">{{ __('Iniciar Sesión') }}</x-primary-button>
        </div>
    </form>
</x-guest-layout>
