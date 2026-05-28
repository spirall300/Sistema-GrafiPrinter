<x-app-layout>
    <div class="flex min-h-screen bg-slate-200">
        <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-slate-200 relative">
            <!-- Botón menú solo en móvil -->
            <button @click="sidebarOpen = true"
                class="md:hidden block fixed top-6 left-4 z-50 bg-blue-700 hover:bg-blue-800 text-white p-4 rounded-full shadow-2xl border-4 border-white focus:outline-none focus:ring-2 focus:ring-blue-400 flex items-center justify-center transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    class="w-7 h-7">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 7h16M4 12h16M4 17h16"
                        stroke="#fff" />
                </svg>
            </button>
            <!-- Sidebar modal en móvil -->
            <template x-if="sidebarOpen">
                <div class="fixed inset-0 z-50 flex items-center justify-center">
                    <div @click="sidebarOpen = false" class="absolute inset-0 bg-slate-900/40"></div>
                    <div
                        class="relative w-11/12 max-w-sm bg-slate-900 shadow-2xl rounded-2xl border-2 border-blue-900/30 flex flex-col animate-fade-in mx-auto">
                        <!-- Botón de cerrar (X) eliminado por requerimiento -->
                        @include('components.sidebar-modal')
                    </div>
                </div>
            </template>
            <x-sidebar />
            <!-- ...existing code... -->
        </div>

        <main class="flex-1 p-10 overflow-y-auto">
            <div class="max-w-4xl mx-auto">
                <div
                    class="bg-white rounded-3xl p-8 shadow-xl border-b-8 border-blue-600 mb-10 flex justify-between items-center relative overflow-hidden">
                    <div class="relative z-10">
                        <h2 class="text-3xl font-black text-slate-800">
                            EDITAR USUARIO
                        </h2>
                        <p class="text-slate-500 font-medium mt-1 uppercase text-sm">Modificar datos de
                            {{ $user->name }}</p>
                    </div>
                    <div class="text-right z-10 hidden md:block">
                        <p class="text-4xl font-black text-slate-700 uppercase tracking-tighter">ADMIN</p>
                        <p class="text-xs font-mono text-slate-600">{{ now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-50 rounded-full opacity-50"></div>
                </div>

                {{-- Formulario de edición de usuario con confirmación antes de actualizar --}}
                <form method="POST" action="{{ route('admin.users.update', $user) }}"
                    class="bg-white rounded-3xl shadow-lg p-8 border border-slate-100"
                    onsubmit="return confirm('¿Estás seguro de los cambios realizados en este usuario?');">
                    @csrf
                    @method('PATCH')

                    <div class="mb-6 p-4 rounded-2xl bg-blue-50 border border-blue-100 text-slate-700">
                        <p class="text-sm font-bold">Antes de actualizar, revisa bien los cambios.</p>
                        <p class="text-xs text-slate-500">Una vez guardados, los datos del usuario se actualizarán
                            inmediatamente.</p>
                    </div>

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
                        <label for="role" class="block text-sm font-medium text-slate-700 mb-2">Tipo de
                            Usuario</label>
                        <select name="role" id="role"
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="encargado" {{ $user->role == 'encargado' ? 'selected' : '' }}>Encargado
                            </option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrador
                            </option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Nueva Contraseña
                        </label>
                        <input type="password" name="password" id="password"
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-slate-700 mb-2">Confirmar Nueva Contraseña</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="mb-6">
                        <label for="security_question" class="block text-sm font-medium text-slate-700 mb-2">Pregunta de
                            Seguridad (opcional)</label>
                        <select name="security_question" id="security_question"
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Seleccionar pregunta</option>
                            <option value="1" {{ $user->security_question == '1' ? 'selected' : '' }}>¿Cuál es su
                                color favorito?</option>
                            <option value="2" {{ $user->security_question == '2' ? 'selected' : '' }}>¿Cuál es su
                                comida favorita?</option>
                            <option value="3" {{ $user->security_question == '3' ? 'selected' : '' }}>¿Cuál es su
                                pasatiempo favorito?</option>
                            <option value="4" {{ $user->security_question == '4' ? 'selected' : '' }}>¿Cuál es su
                                deporte favorito?</option>
                            <option value="5" {{ $user->security_question == '5' ? 'selected' : '' }}>¿Cuál es su
                                fruta favorita?</option>
                            <option value="6" {{ $user->security_question == '6' ? 'selected' : '' }}>¿Cuál es su
                                música favorita?</option>
                        </select>
                        @error('security_question')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="security_answer" class="block text-sm font-medium text-slate-700 mb-2">Respuesta de
                            Seguridad (opcional)</label>
                        <input type="text" name="security_answer" id="security_answer"
                            value="{{ old('security_answer', $user->security_answer) }}"
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('security_answer')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="unlock_user" id="unlock_user" value="1"
                                class="mr-2 h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded">
                            <span class="text-sm font-medium text-slate-700">Desbloquear usuario (resetea intentos de
                                login y quita bloqueo)</span>
                        </label>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('admin.users.index') }}"
                            class="mr-4 px-4 py-2 bg-slate-300 text-slate-700 rounded-md hover:bg-slate-400">Cancelar</a>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Actualizar
                            Usuario</button>
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
