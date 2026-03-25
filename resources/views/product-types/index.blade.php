<x-app-layout>
    <div class="flex min-h-screen bg-slate-200">
        <x-sidebar />

        <main class="flex-1 p-10 overflow-y-auto">
            <div class="max-w-6xl mx-auto">
                <div
                    class="bg-white rounded-3xl p-8 shadow-xl border-b-8 border-blue-600 mb-10 flex justify-between items-center relative overflow-hidden">
                    <div class="relative z-10">
                        <h2 class="text-3xl font-black text-slate-800">
                            TIPOS DE PRODUCTO
                        </h2>
                        <p class="text-slate-500 font-medium mt-1 uppercase text-sm">Agrega y administra las opciones
                            para el pedido</p>
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
