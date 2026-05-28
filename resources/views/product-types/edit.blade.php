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
                            EDITAR TIPO DE PRODUCTO
                        </h2>
                        <p class="text-slate-500 font-medium mt-1 uppercase text-sm">Actualiza el nombre del tipo</p>
                    </div>
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-50 rounded-full opacity-50"></div>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white rounded-3xl shadow-lg p-6 border border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Editar tipo</h3>
                    <form action="{{ route('product-types.update', $productType) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700">Nombre del
                                tipo</label>
                            <input id="name" name="name" type="text" required
                                class="mt-1 block w-full rounded-xl border border-slate-300 bg-white py-2 px-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-blue-500"
                                value="{{ old('name', $productType->name) }}" />
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-between items-center">
                            <a href="{{ route('product-types.index') }}"
                                class="px-4 py-2 bg-slate-500 text-white rounded-md hover:bg-slate-600">Cancelar</a>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Oculta la URL cambiando a la raíz
        window.history.replaceState(null, null, '/');
    </script>
</x-app-layout>
