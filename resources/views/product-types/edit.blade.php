<x-app-layout>
    <div class="flex min-h-screen bg-slate-200">
        <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-slate-200 relative">
            <!-- Botón menú solo en móvil -->
            @include('components.sidebar-hamburger')
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
                    <div class="text-right z-10 hidden md:block">
                        <p
                            class="text-4xl font-black uppercase tracking-tighter {{ Auth::user()->role === 'admin' ? 'text-slate-700' : 'text-slate-700' }}">
                            {{ Auth::user()->role === 'admin' ? 'ADMINISTRADOR' : (Auth::user()->role === 'encargado' ? 'ENCARGADO' : 'PUBLIC') }}
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
                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Cancelar</a>
                            <button type="button" id="confirm-update-btn"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Actualizar</button>
                        </div>
                    </form>

                    <div id="modal-confirm-update"
                        class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-40">
                        <div class="w-full max-w-sm rounded-2xl bg-white p-8 shadow-xl">
                            <h2 class="mb-2 text-lg font-bold text-slate-800">¿Confirmar actualización?</h2>
                            <p class="mb-6 text-sm text-slate-600">¿Deseas guardar los cambios del tipo de producto?</p>
                            <div class="flex justify-center gap-4">
                                <button type="button" id="cancel-modal-btn"
                                    class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-red-600 p-3 text-white transition hover:bg-red-700"
                                    aria-label="Cancelar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                                <button type="button" id="accept-modal-btn"
                                    class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600 p-3 text-white transition hover:bg-blue-700"
                                    aria-label="Confirmar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector(
                'form[action^="{{ route('product-types.update', $productType) }}"]');
            const confirmBtn = document.getElementById('confirm-update-btn');
            const modal = document.getElementById('modal-confirm-update');
            const cancelModalBtn = document.getElementById('cancel-modal-btn');
            const acceptModalBtn = document.getElementById('accept-modal-btn');

            if (!form || !confirmBtn || !modal) {
                return;
            }

            confirmBtn.addEventListener('click', function() {
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });

            cancelModalBtn.addEventListener('click', function() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                window.location.href = '{{ route('product-types.index') }}';
            });

            acceptModalBtn.addEventListener('click', function() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                form.submit();
            });
        });
    </script>

    <script>
        // Oculta la URL cambiando a la raíz
        window.history.replaceState(null, null, '/');
    </script>
</x-app-layout>
