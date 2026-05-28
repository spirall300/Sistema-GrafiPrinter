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
                        <button @click="sidebarOpen = false"
                            class="absolute top-4 right-4 text-white text-2xl p-2 rounded-full hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
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
                            GESTIONAR USUARIOS
                        </h2>
                        <p class="text-slate-500 font-medium mt-1 uppercase text-sm">Lista de usuarios registrados</p>
                    </div>
                    <div class="text-right z-10 hidden md:block">
                        <p class="text-4xl font-black text-slate-700 uppercase tracking-tighter">ADMIN</p>
                        <p class="text-xs font-mono text-slate-600">{{ now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-50 rounded-full opacity-50"></div>
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
                    <a href="{{ route('admin.users.create') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Registrar Nuevo
                        Usuario</a>
                </div>

                <div class="bg-white rounded-3xl shadow-lg p-6 border border-slate-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-slate-50">
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                        Nombre</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                        Email</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                        Rol</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                        Fecha de Registro</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                        Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                            {{ $user->name }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-500">
                                            {{ $user->email }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-500">
                                            {{ ucfirst($user->role) }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-500">
                                            {{ $user->created_at->format('d/m/Y') }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                                class="text-blue-600 hover:text-blue-900 mr-4">Editar</a>
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="confirm_password" value="">
                                                <button type="button"
                                                    onclick="openDeleteModal(this.closest('form'), {{ json_encode($user->name) }})"
                                                    class="text-red-600 hover:text-red-900">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>

            {{-- Modal visual para confirmar eliminación de usuario --}}
            <div id="deleteModal" class="hidden fixed inset-0 z-50 items-center justify-center px-4 py-8">
                <div class="absolute inset-0 bg-slate-900/80" onclick="closeDeleteModal()"></div>
                <div
                    class="relative w-full max-w-[28rem] bg-white rounded-3xl border border-slate-200 shadow-2xl p-6 z-10 text-slate-900 max-h-[calc(100vh-8rem)] overflow-hidden">
                    <div class="flex items-start justify-between gap-4 mb-4 border-b border-slate-200 pb-4">
                        <div>
                            <h3 class="text-xl font-black text-slate-900">Confirmar eliminación</h3>
                            <p class="mt-1 text-sm text-slate-500">Ingresa tu contraseña para confirmar la eliminación
                                del usuario.</p>
                        </div>
                        <button type="button" onclick="closeDeleteModal()"
                            class="text-slate-400 hover:text-slate-700 text-2xl leading-none">×</button>
                    </div>
                    <div class="mb-4 rounded-3xl bg-white border border-slate-200 p-4 text-sm text-slate-700">
                        <p>Usuario a eliminar:</p>
                        <p class="mt-1 font-semibold text-slate-900" id="deleteModalUser"></p>
                    </div>
                    <div class="mb-6">
                        <label for="deletePassword"
                            class="block text-sm font-medium text-slate-700 mb-2">Contraseña</label>
                        <input id="deletePassword" type="password"
                            class="w-full px-3 py-3 border border-slate-300 rounded-2xl bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Tu contraseña">
                    </div>
                    <div class="flex justify-end">
                        <button type="button" onclick="submitDeleteModal()"
                            class="w-full sm:w-auto px-4 py-3 bg-red-600 text-white rounded-2xl hover:bg-red-700">Eliminar
                            usuario</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Oculta la URL cambiando a la raíz
        window.history.replaceState(null, null, '/');

        let deleteForm = null;

        function openDeleteModal(form, userName) {
            deleteForm = form;
            document.getElementById('deleteModalUser').textContent = userName;
            document.getElementById('deletePassword').value = '';
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeDeleteModal() {
            deleteForm = null;
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function submitDeleteModal() {
            const password = document.getElementById('deletePassword').value.trim();
            if (!password) {
                alert('Debes ingresar tu contraseña para confirmar la eliminación.');
                return;
            }

            if (!deleteForm) {
                closeDeleteModal();
                return;
            }

            deleteForm.querySelector('input[name="confirm_password"]').value = password;
            deleteForm.submit();
        }
    </script>
</x-app-layout>
