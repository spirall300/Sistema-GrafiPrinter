<x-guest-layout>
    <div class="mb-4 text-sm text-blue-200">
        {{ __('¿Olvidaste tu contraseña? Ingresa tu correo y elige cómo deseas recuperarla.') }}
    </div>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div>
            <x-input-label for="email" :value="__('Correo Electrónico')" class="text-white font-bold" />
            <x-text-input id="email" class="block mt-1 w-full bg-white text-slate-900" type="email" name="email"
                :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex flex-col gap-3 mt-6">
            <x-primary-button class="w-full justify-center bg-blue-700">
                {{ __('ENVIAR ENLACE AL CORREO') }}
            </x-primary-button>

            <button type="button" onclick="goToQuestions()"
                class="w-full py-2 bg-slate-800 text-blue-300 border border-blue-500 rounded-md font-bold hover:bg-slate-700 transition">
                USAR PREGUNTA DE SEGURIDAD
            </button>
        </div>
    </form>

    <script>
        function goToQuestions() {
            const email = document.getElementById('email').value;
            if (email) {
                // Redirigimos a una nueva ruta pasando el correo
                window.location.href = "{{ route('password.questions') }}?email=" + email;
            } else {
                alert('Por favor, escribe tu correo primero.');
            }
        }
    </script>
</x-guest-layout>
