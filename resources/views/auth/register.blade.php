<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-blue-400 font-extrabold">
            REGISTRO DE PERSONAL</span>
        </h2>
        <p class="text-blue-200 text-xs mt-1 font-bold">Complete todos los campos para dar de alta al usuario</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="name" :value="__('Nombre Completo')" class="text-blue-950 font-extrabold" />
                <x-text-input id="name" class="block mt-1 w-full bg-white text-slate-900 border-blue-500"
                    type="text" name="name" :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Correo Electrónico')" class="text-blue-950 font-extrabold" />
                <x-text-input id="email" class="block mt-1 w-full bg-white text-slate-900 border-blue-500"
                    type="email" name="email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="password" :value="__('Contraseña')" class="text-blue-950 font-extrabold" />
                <x-text-input id="password" class="block mt-1 w-full bg-white text-slate-900 border-blue-500"
                    type="password" name="password" required />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="text-blue-950 font-extrabold" />
                <x-text-input id="password_confirmation"
                    class="block mt-1 w-full bg-white text-slate-900 border-blue-500" type="password"
                    name="password_confirmation" required />
            </div>
        </div>

        <hr class="border-blue-800 my-4">

        <div>
            <x-input-label for="role" :value="__('Tipo de Usuario (Rol)')" class="text-blue-950 font-extrabold" />
            <select id="role" name="role"
                class="block mt-1 w-full border-blue-500 rounded-md shadow-sm bg-white text-slate-900 focus:ring-blue-500 py-2">
                <option value="encargado">Encargado (Operaciones básicas)</option>
                <option value="admin">Administrador (Acceso total)</option>
            </select>
        </div>

        <div class="p-4 bg-slate-800 rounded-lg border border-blue-600">
            <h3 class="text-blue-400 text-xs font-bold uppercase mb-3 underline">Configuración de Seguridad</h3>

            <div class="space-y-4">
                <div>
                    <x-input-label for="security_question" :value="__('Seleccione una Pregunta')" class="text-white text-sm" />
                    <select id="security_question" name="security_question"
                        class="block mt-1 w-full border-blue-500 rounded-md bg-white text-slate-900 py-2">
                        <option value="1">¿Cuál es su color favorito?</option>
                        <option value="2">¿Cuál es su comida favorita?</option>
                        <option value="3">¿Cuál es su pasatiempo favorito?</option>
                        <option value="4">¿Cuál es su deporte favorito?</option>
                        <option value="5">¿Cuál es su fruta favorita?</option>
                        <option value="6">¿Cuál es su música favorita?</option>
                    </select>
                </div>

                <div>
                    <x-input-label for="security_answer" :value="__('Su Respuesta Secreta')" class="text-white text-sm" />
                    <x-text-input id="security_answer" class="block mt-1 w-full bg-white text-slate-900 border-blue-500"
                        type="text" name="security_answer" required placeholder="Ej: Azul / Pizza" />
                    <x-input-error :messages="$errors->get('security_answer')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="flex flex-col items-center gap-4 mt-6">
            <x-primary-button class="w-full justify-center bg-blue-700 hover:bg-blue-800 py-3 text-lg font-bold">
                {{ __('REGISTRAR NUEVO USUARIO') }}
            </x-primary-button>

            <a class="text-sm text-blue-300 hover:text-white underline transition-colors" href="{{ route('login') }}">
                {{ __('¿Ya está registrado? Volver al inicio') }}
            </a>
        </div>
    </form>
</x-guest-layout>
