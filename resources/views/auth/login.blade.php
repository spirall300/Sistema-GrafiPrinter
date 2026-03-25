<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Correo Electronico')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4 text-center">
            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 hover:text-blue-800 font-semibold transition-colors"
                    href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña o usuario?') }}
                </a>
            @endif
        </div>

        <div class="mt-4 text-center">
            <a href="{{ route('register') }}"
                class="text-sm text-blue-600 hover:text-blue-800 font-semibold transition-colors underline">
                {{ __('¿No tienes cuenta? Regístrate aquí') }}
            </a>
        </div>

        <div class="mt-6 flex flex-col items-center gap-4">
            <div class="g-recaptcha" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}"></div>

            @if ($errors->has('g-recaptcha-response'))
                <span class="text-red-600 text-sm mt-2 block text-center">
                    Por favor, verifique que no es un robot.
                </span>
            @endif
            <x-primary-button class="w-full justify-center bg-blue-700 hover:bg-blue-800 py-3 rounded-xl shadow-lg">
                {{ __('ACCEDER AL SISTEMA') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        // Oculta la URL cambiando a la raíz
        window.history.replaceState(null, null, '/');
    </script>
</x-guest-layout>
