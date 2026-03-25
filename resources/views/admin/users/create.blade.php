<x-app-layout>
    <div class="flex min-h-screen bg-slate-200">
        <x-sidebar />

        <main class="flex-1 p-10 overflow-y-auto">
            <div class="max-w-4xl mx-auto">
                <div
                    class="bg-white rounded-3xl p-8 shadow-xl border-b-8 border-blue-600 mb-10 flex justify-between items-center relative overflow-hidden">
                    <div class="relative z-10">
                        <h2 class="text-3xl font-black text-slate-800">
                            CREAR USUARIO
                        </h2>
                        <p class="text-slate-500 font-medium mt-1 uppercase text-sm">Registrar un nuevo usuario en el
                            sistema</p>
                    </div>
                    <div class="text-right z-10 hidden md:block">
                        <p class="text-4xl font-black text-slate-100 uppercase tracking-tighter">ADMIN</p>
                        <p class="text-xs font-mono text-slate-400">{{ now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-50 rounded-full opacity-50"></div>
                </div>

                <form method="POST" action="{{ route('admin.users.store') }}"
                    class="bg-white rounded-3xl shadow-lg p-8 border border-slate-100">
                    @csrf

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Nombre</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="role" class="block text-sm font-medium text-slate-700 mb-2">Tipo de
                            Usuario</label>
                        <select name="role" id="role"
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="encargado" {{ old('role') == 'encargado' ? 'selected' : '' }}>Encargado
                            </option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Contraseña</label>
                        <input type="password" name="password" id="password"
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-slate-700 mb-2">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        @error('password_confirmation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="security_question" class="block text-sm font-medium text-slate-700 mb-2">Pregunta de
                            Seguridad (opcional)</label>
                        <select name="security_question" id="security_question"
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Seleccionar pregunta</option>
                            <option value="¿Cuál es el nombre de tu primera mascota?"
                                {{ old('security_question') == '¿Cuál es el nombre de tu primera mascota?' ? 'selected' : '' }}>
                                ¿Cuál es el nombre de tu primera mascota?</option>
                            <option value="¿Cuál es tu color favorito?"
                                {{ old('security_question') == '¿Cuál es tu color favorito?' ? 'selected' : '' }}>¿Cuál
                                es tu color favorito?</option>
                            <option value="¿Cuál es el nombre de tu madre?"
                                {{ old('security_question') == '¿Cuál es el nombre de tu madre?' ? 'selected' : '' }}>
                                ¿Cuál es el nombre de tu madre?</option>
                            <option value="¿En qué ciudad naciste?"
                                {{ old('security_question') == '¿En qué ciudad naciste?' ? 'selected' : '' }}>¿En qué
                                ciudad naciste?</option>
                            <option value="¿Cuál es tu comida favorita?"
                                {{ old('security_question') == '¿Cuál es tu comida favorita?' ? 'selected' : '' }}>
                                ¿Cuál es tu comida favorita?</option>
                        </select>
                        @error('security_question')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="security_answer" class="block text-sm font-medium text-slate-700 mb-2">Respuesta de
                            Seguridad (opcional)</label>
                        <input type="text" name="security_answer" id="security_answer"
                            value="{{ old('security_answer') }}"
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('security_answer')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('admin.users.index') }}"
                            class="mr-4 px-4 py-2 bg-slate-300 text-slate-700 rounded-md hover:bg-slate-400">Cancelar</a>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Crear Usuario</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        // Oculta la URL cambiando a la raíz
        window.history.replaceState(null, null, '/');
    </script>
</x-app-layout>
