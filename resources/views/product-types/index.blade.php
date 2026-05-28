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
                            TIPOS DE PRODUCTO
                        </h2>
                        <p class="text-slate-500 font-medium mt-1 uppercase text-sm">Agrega y administra las opciones
                            para el pedido</p>
                    </div>
                    <div class="text-right z-10 hidden md:block">
                        <p
                            class="text-4xl font-black uppercase tracking-tighter {{ Auth::user()->role === 'admin' ? 'text-slate-700' : 'text-slate-700' }}">
                            {{ Auth::user()->role === 'admin' ? 'ADMIN' : 'PUBLIC' }}
                        </p>
                        <p class="text-xs font-mono text-slate-600">{{ now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-50 rounded-full opacity-50"></div>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="bg-white rounded-3xl shadow-lg p-6 border border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800 mb-4">Agregar nuevo tipo</h3>
                        <form action="{{ route('product-types.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="name" class="block text-sm font-medium text-slate-700">Nombre del
                                    tipo</label>
                                <input id="name" name="name" type="text" required
                                    class="mt-1 block w-full rounded-xl border border-slate-300 bg-white py-2 px-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-blue-500"
                                    value="{{ old('name') }}" />
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-end">
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Guardar</button>
                            </div>
                        </form>
                    </div>

                    <div class="bg-white rounded-3xl shadow-lg p-6 border border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800 mb-4">Tipos existentes</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-slate-50">
                                        <th
                                            class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                            Tipo</th>
                                        <th
                                            class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                            Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-200">
                                    @forelse($types as $type)
                                        <tr>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                                {{ $type->name }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('product-types.edit', $type) }}"
                                                    class="text-blue-600 hover:text-blue-900 mr-3">Editar</a>
                                                <form method="POST"
                                                    action="{{ route('product-types.destroy', $type) }}" class="inline"
                                                    onsubmit="return confirm('¿Eliminar este tipo de producto?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="px-4 py-4 text-sm text-slate-500">No hay tipos de
                                                producto registrados.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Oculta la URL cambiando a la raíz
        window.history.replaceState(null, null, '/');
    </script>
</x-app-layout>
