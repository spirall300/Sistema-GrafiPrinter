<x-app-layout>
    <div class="flex min-h-screen bg-slate-200">
        <x-sidebar />

        <main class="flex-1 p-10 overflow-y-auto">
            <div class="max-w-6xl mx-auto">
                <div
                    class="bg-white rounded-3xl p-8 shadow-xl border-b-8 border-blue-600 mb-10 flex justify-between items-center relative overflow-hidden">
                    <div class="relative z-10">
                        <h2 class="text-3xl font-black text-slate-800">
                            INVENTARIO
                        </h2>
                        <p class="text-slate-500 font-medium mt-1 uppercase text-sm">Gestiona los artículos disponibles
                            en stock</p>
                    </div>
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-50 rounded-full opacity-50"></div>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif
                <!-- Filtro -->
                <div class="bg-white rounded-3xl shadow-lg p-6 border border-slate-100 mb-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Buscar artículos</h3>
                    <form method="GET" action="{{ route('inventory.index') }}" class="flex gap-4">
                        <input name="name" type="text" value="{{ request('name') }}"
                            placeholder="Buscar por nombre..."
                            class="flex-1 rounded-xl border border-slate-300 bg-white py-2 px-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-blue-500" />
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Buscar</button>
                        <a href="{{ route('inventory.index') }}"
                            class="px-4 py-2 bg-slate-500 text-white rounded-md hover:bg-slate-600">Limpiar</a>
                    </form>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    @if (Auth::user()->role === 'admin')
                        <div class="bg-white rounded-3xl shadow-lg p-6 border border-slate-100">
                            <h3 class="text-lg font-bold text-slate-800 mb-4">Agregar nuevo artículo</h3>
                            <form action="{{ route('inventory.store') }}" method="POST" class="space-y-4">
                                @csrf

                                <div>
                                    <label for="name"
                                        class="block text-sm font-medium text-slate-700">Nombre</label>
                                    <input id="name" name="name" type="text" required
                                        class="mt-1 block w-full rounded-xl border border-slate-300 bg-white py-2 px-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-blue-500"
                                        value="{{ old('name') }}" />
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="sku" class="block text-sm font-medium text-slate-700">SKU</label>
                                    <input id="sku" name="sku" type="text"
                                        class="mt-1 block w-full rounded-xl border border-slate-300 bg-white py-2 px-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-blue-500"
                                        value="{{ old('sku') }}" />
                                    @error('sku')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="quantity"
                                            class="block text-sm font-medium text-slate-700">Cantidad</label>
                                        <input id="quantity" name="quantity" type="number" min="0" required
                                            class="mt-1 block w-full rounded-xl border border-slate-300 bg-white py-2 px-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-blue-500"
                                            value="{{ old('quantity', 0) }}" />
                                        @error('quantity')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="unit"
                                            class="block text-sm font-medium text-slate-700">Unidad</label>
                                        <input id="unit" name="unit" type="text"
                                            class="mt-1 block w-full rounded-xl border border-slate-300 bg-white py-2 px-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-blue-500"
                                            value="{{ old('unit') }}" />
                                        @error('unit')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="location"
                                        class="block text-sm font-medium text-slate-700">Ubicación</label>
                                    <input id="location" name="location" type="text"
                                        class="mt-1 block w-full rounded-xl border border-slate-300 bg-white py-2 px-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-blue-500"
                                        value="{{ old('location') }}" />
                                    @error('location')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="notes" class="block text-sm font-medium text-slate-700">Notas</label>
                                    <textarea id="notes" name="notes" rows="3"
                                        class="mt-1 block w-full rounded-xl border border-slate-300 bg-white py-2 px-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-blue-500">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Agregar</button>
                                </div>
                            </form>
                        </div>
                    @endif

                    <div class="bg-white rounded-3xl shadow-lg p-6 border border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800 mb-4">Artículos en inventario</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-slate-50">
                                        <th
                                            class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                            Nombre</th>
                                        <th
                                            class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                            SKU</th>
                                        <th
                                            class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                            Cantidad</th>
                                        <th
                                            class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                            Ubicación</th>
                                        <th
                                            class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                            Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-200">
                                    @forelse($items as $item)
                                        <tr>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                                {{ $item->name }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-500">
                                                {{ $item->sku }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-500">
                                                {{ $item->quantity }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-500">
                                                {{ $item->location }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                                @if (Auth::user()->role === 'admin')
                                                    <a href="{{ route('inventory.edit', $item) }}"
                                                        class="text-blue-600 hover:text-blue-900 mr-3">Editar</a>
                                                    <form method="POST"
                                                        action="{{ route('inventory.destroy', $item) }}"
                                                        class="inline"
                                                        onsubmit="return confirm('¿Eliminar este artículo del inventario?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-600 hover:text-red-900">Eliminar</button>
                                                    </form>
                                                @else
                                                    <span class="text-slate-400">Sin permisos</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-4 py-4 text-sm text-slate-500">No hay
                                                artículos en el inventario.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $items->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
