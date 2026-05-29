<x-app-layout>
    <div class="flex min-h-screen bg-slate-200" x-data="{ openDeleteModal: null }">

        <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-slate-200 relative">
            <!-- Botón menú solo en móvil -->
            @include('components.sidebar-hamburger')
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
                    class="bg-white rounded-3xl p-8 shadow-xl border-b-8 border-blue-600 mb-8 flex justify-between items-center relative overflow-hidden">
                    <div class="relative z-10">
                        <h2 class="text-3xl font-black text-slate-800">SEGUIMIENTO DE PEDIDOS</h2>
                        <p class="text-slate-500 font-medium mt-1 uppercase text-sm">Visualiza y actualiza el estado de
                            tus pedidos</p>
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

                @if (session('status'))
                    <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Filtros -->
                <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6 mb-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Filtros</h3>
                    <form method="GET" action="{{ route('orders.index') }}"
                        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
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
                        <div class="flex items-end w-full gap-2 flex-col md:flex-row">
                            <button type="submit"
                                class="flex items-center justify-center w-full md:w-auto px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-base md:text-base lg:text-lg min-w-[44px] min-h-[44px]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                                </svg>
                            </button>
                            <a href="{{ route('orders.index') }}"
                                class="flex items-center justify-center w-full md:w-auto px-3 py-2 bg-slate-500 text-white rounded-md hover:bg-slate-600 transition text-base md:text-base lg:text-lg min-w-[44px] min-h-[44px]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 21h18M4 17l1-9a2 2 0 012-2h10a2 2 0 012 2l1 9M9 10V7a3 3 0 116 0v3" />
                                </svg>
                            </a>
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
                                                    <div class="flex flex-row gap-1 items-center">
                                                        <a href="{{ route('orders.edit', $order) }}"
                                                            class="text-xs font-semibold text-white bg-slate-900 hover:bg-slate-800 rounded-xl px-3 py-1 text-center">
                                                            Editar
                                                        </a>
                                                        <button type="button"
                                                            class="ml-1 bg-red-600 hover:bg-red-700 p-1 rounded-full focus:outline-none focus:ring-2 focus:ring-red-400"
                                                            title="Eliminar"
                                                            @click="openDeleteModal = {{ $order->id }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24" stroke="white">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('orders.update-status', $order) }}"
                                                        method="POST" class="flex items-center gap-2"
                                                        onsubmit="return false;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <select name="status" required
                                                            class="rounded-xl border border-slate-300 bg-white py-1 pl-3 pr-7 text-xs focus:border-blue-500 focus:ring-blue-500 appearance-none relative"
                                                            onchange="this.form.submit()">
                                                            <option value="Pendiente"
                                                                {{ $order->status == 'Pendiente' ? 'selected' : '' }}>
                                                                Pendiente</option>
                                                            <option value="Revisado"
                                                                {{ $order->status == 'Revisado' ? 'selected' : '' }}>
                                                                Revisado</option>
                                                            <option value="Pagado"
                                                                {{ $order->status == 'Pagado' ? 'selected' : '' }}>
                                                                Pagado</option>
                                                        </select>
                                                        <span
                                                            class="pointer-events-none absolute right-4 text-slate-400">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M19 9l-7 7-7-7" />
                                                            </svg>
                                                        </span>
                                                    </form>
                                                    <!-- Modal de confirmación -->
                                                    <div x-data="{ show: false }"
                                                        x-show="openDeleteModal === {{ $order->id }}"
                                                        style="display: none;"
                                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                                                        <div
                                                            class="bg-white rounded-2xl shadow-xl p-8 max-w-sm w-full flex flex-col items-center">
                                                            <h2 class="text-lg font-bold text-slate-800 mb-2">¿Eliminar
                                                                pedido?</h2>
                                                            <p class="text-slate-600 text-sm mb-6">Esta acción no se
                                                                puede deshacer.<br>¿Seguro que deseas eliminar el pedido
                                                                <span class='font-bold'>#{{ $order->id }}</span>?
                                                            </p>
                                                            <div class="flex gap-4 w-full justify-center">
                                                                <form method="POST"
                                                                    action="{{ route('orders.destroy', $order) }}"
                                                                    class="inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl font-semibold">Sí,
                                                                        eliminar</button>
                                                                </form>
                                                                <button type="button" @click="openDeleteModal = null"
                                                                    class="bg-slate-200 hover:bg-slate-300 text-slate-800 px-4 py-2 rounded-xl font-semibold">Cancelar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                            </tbody>

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
