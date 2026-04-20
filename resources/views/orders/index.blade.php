<x-app-layout>
    <div class="flex min-h-screen bg-slate-200">

        <x-sidebar />

        <main class="flex-1 p-10 overflow-y-auto">
            <div class="max-w-6xl mx-auto">
                <div
                    class="bg-white rounded-3xl p-8 shadow-xl border-b-8 border-blue-600 mb-8 flex justify-between items-center relative overflow-hidden">
                    <div class="relative z-10">
                        <h2 class="text-3xl font-black text-slate-800">SEGUIMIENTO DE PEDIDOS</h2>
                        <p class="text-slate-500 font-medium mt-1 uppercase text-sm">Visualiza y actualiza el estado de
                            tus pedidos</p>
                    </div>
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-50 rounded-full opacity-50"></div>
                </div>

                @if (session('status'))
                    <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Filtros -->
                <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6 mb-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Filtros</h3>
                    <form method="GET" action="{{ route('orders.index') }}"
                        class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="type" class="block text-sm font-medium text-slate-700">Tipo</label>
                            <select id="type" name="type"
                                class="mt-1 block w-full rounded-xl border border-slate-300 bg-white py-2 px-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Todos</option>
                                @foreach ($productTypes as $type)
                                    <option value="{{ $type }}"
                                        {{ request('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-slate-700">Estado</label>
                            <select id="status" name="status"
                                class="mt-1 block w-full rounded-xl border border-slate-300 bg-white py-2 px-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Todos</option>
                                <option value="Pendiente" {{ request('status') == 'Pendiente' ? 'selected' : '' }}>
                                    Pendiente</option>
                                <option value="Revisado" {{ request('status') == 'Revisado' ? 'selected' : '' }}>
                                    Revisado</option>
                                <option value="Pagado" {{ request('status') == 'Pagado' ? 'selected' : '' }}>Pagado
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="company_name" class="block text-sm font-medium text-slate-700">Empresa</label>
                            <input id="company_name" name="company_name" type="text"
                                value="{{ request('company_name') }}"
                                class="mt-1 block w-full rounded-xl border border-slate-300 bg-white py-2 px-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Buscar por empresa..." />
                        </div>
                        <div class="flex items-end">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Filtrar</button>
                            <a href="{{ route('orders.index') }}"
                                class="ml-2 px-4 py-2 bg-slate-500 text-white rounded-md hover:bg-slate-600">Limpiar</a>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm">
                            <thead class="bg-slate-900 text-white">
                                <tr>
                                    <th class="px-4 py-3">#</th>
                                    <th class="px-4 py-3">Tipo</th>
                                    <th class="px-4 py-3">Empresa</th>
                                    <th class="px-4 py-3">Cantidad</th>
                                    <th class="px-4 py-3">Comprador</th>
                                    <th class="px-4 py-3">Ingreso</th>
                                    <th class="px-4 py-3">Entrega</th>
                                    <th class="px-4 py-3">Estado</th>
                                    <th class="px-4 py-3">Archivo</th>
                                    <th class="px-4 py-3">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($orders as $order)
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-4 py-3 font-semibold text-slate-800">{{ $order->id }}</td>
                                        <td class="px-4 py-3 text-slate-600">{{ $order->type }}</td>
                                        <td class="px-4 py-3 text-slate-600">{{ $order->company_name }}</td>
                                        <td class="px-4 py-3 text-slate-600">{{ $order->quantity }}</td>
                                        <td class="px-4 py-3 text-slate-600">{{ $order->buyer }}</td>
                                        <td class="px-4 py-3 text-slate-600">
                                            {{ optional($order->entry_date)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-4 py-3 text-slate-600">
                                            {{ optional($order->delivery_date)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $order->status == 'Pagado' ? 'bg-emerald-100 text-emerald-700' : ($order->status == 'Revisado' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700') }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            @if ($order->file_path)
                                                <a href="{{ \Illuminate\Support\Facades\Storage::url($order->file_path) }}"
                                                    target="_blank"
                                                    class="text-blue-600 hover:text-blue-800 text-xs">Descargar</a>
                                            @else
                                                <span class="text-slate-400 text-xs">Sin archivo</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            @if (Auth::user()->role === 'admin')
                                                <div class="flex flex-col gap-2">
                                                    <a href="{{ route('orders.edit', $order) }}"
                                                        class="text-xs font-semibold text-white bg-slate-900 hover:bg-slate-800 rounded-xl px-3 py-1 text-center">
                                                        Editar
                                                    </a>
                                                    <form action="{{ route('orders.update-status', $order) }}"
                                                        method="POST" class="flex items-center gap-2">
                                                        @csrf
                                                        @method('PATCH')
                                                        <select name="status" required
                                                            class="rounded-xl border border-slate-300 bg-white py-1 px-2 text-xs focus:border-blue-500 focus:ring-blue-500">
                                                            <option value="Pendiente"
                                                                {{ $order->status == 'Pendiente' ? 'selected' : '' }}>
                                                                Pendiente
                                                            </option>
                                                            <option value="Revisado"
                                                                {{ $order->status == 'Revisado' ? 'selected' : '' }}>
                                                                Revisado
                                                            </option>
                                                            <option value="Pagado"
                                                                {{ $order->status == 'Pagado' ? 'selected' : '' }}>
                                                                Pagado
                                                            </option>
                                                        </select>
                                                        <button type="submit"
                                                            class="text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl px-3 py-1">
                                                            Guardar
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $order->status == 'Pagado' ? 'bg-emerald-100 text-emerald-700' : ($order->status == 'Revisado' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700') }}">
                                                    {{ $order->status }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-4 py-6 text-center text-slate-500">
                                            No hay pedidos registrados aún.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
