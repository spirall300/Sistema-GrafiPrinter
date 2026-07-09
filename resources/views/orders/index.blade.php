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
                            {{ Auth::user()->role === 'admin' ? 'ADMINISTRADOR' : (Auth::user()->role === 'encargado' ? 'ENCARGADO' : 'PUBLIC') }}
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
                                class="inline-flex items-center justify-center w-full md:w-auto rounded-xl bg-slate-900 p-2.5 text-white shadow-sm transition hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-400 min-w-[44px] min-h-[44px]"
                                title="Limpiar búsqueda">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 7h16M9 7V4h6v3m-7 0l1 10a2 2 0 002 2h4a2 2 0 002-2l1-10" />
                                </svg>
                            </a>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-center text-[13px]">
                            <thead class="bg-slate-900 text-white">
                                <tr>
                                    <th class="px-3 py-3 text-[11px] font-semibold uppercase tracking-wider">Tipo</th>
                                    <th class="px-3 py-3 text-[11px] font-semibold uppercase tracking-wider">Empresa
                                    </th>
                                    <th class="px-3 py-3 text-[11px] font-semibold uppercase tracking-wider">Cantidad
                                    </th>
                                    <th class="px-3 py-3 text-[11px] font-semibold uppercase tracking-wider">Comprador
                                    </th>
                                    <th class="px-3 py-3 text-[11px] font-semibold uppercase tracking-wider">Ingreso
                                    </th>
                                    <th class="px-3 py-3 text-[11px] font-semibold uppercase tracking-wider">Entrega
                                    </th>
                                    <th class="px-3 py-3 text-[11px] font-semibold uppercase tracking-wider">Estado</th>
                                    <th class="px-3 py-3 text-[11px] font-semibold uppercase tracking-wider">Archivo
                                    </th>
                                    <th class="px-3 py-3 text-[11px] font-semibold uppercase tracking-wider">Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($orders as $order)
                                    <tr class="transition hover:bg-slate-50">
                                        <td class="px-3 py-3 text-slate-600">{{ $order->type }}</td>
                                        <td class="px-3 py-3 text-slate-600">{{ $order->company_name }}</td>
                                        <td class="px-3 py-3 text-slate-600">{{ $order->quantity }}</td>
                                        <td class="px-3 py-3 text-slate-600">{{ $order->buyer }}</td>
                                        <td class="px-3 py-3 text-slate-600">
                                            {{ optional($order->entry_date)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-3 py-3 text-slate-600">
                                            {{ optional($order->delivery_date)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-3 py-3">
                                            <span
                                                class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $order->status == 'Pagado' ? 'bg-emerald-100 text-emerald-700' : ($order->status == 'Revisado' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700') }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-3">
                                            @if ($order->file_path)
                                                <a href="{{ \Illuminate\Support\Facades\Storage::url($order->file_path) }}"
                                                    target="_blank"
                                                    class="inline-flex items-center justify-center rounded-full bg-blue-50 p-2 text-blue-700 transition hover:bg-blue-100"
                                                    title="Descargar archivo">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 4v12m0 0l-4-4m4 4l4-4M4 20h16" />
                                                    </svg>
                                                </a>
                                            @else
                                                <span class="text-xs text-slate-400">Sin archivo</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-3">
                                            @if (Auth::user()->role === 'admin')
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <a href="{{ route('orders.edit', $order) }}"
                                                        class="inline-flex items-center justify-center rounded-full bg-slate-900 p-2 text-white transition hover:bg-slate-800"
                                                        title="Editar pedido">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                            stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M16 3a2 2 0 012.828 2.828L8.5 14.5 4 16l1.5-4.5L16 3z" />
                                                        </svg>
                                                    </a>
                                                    <button type="button"
                                                        class="inline-flex items-center justify-center rounded-full bg-red-600 p-2 text-white transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400"
                                                        title="Eliminar"
                                                        @click="openDeleteModal = {{ $order->id }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                            stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14z" />
                                                        </svg>
                                                    </button>
                                                    <form action="{{ route('orders.update-status', $order) }}"
                                                        method="POST" class="flex items-center"
                                                        onsubmit="return false;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="relative">
                                                            <select name="status" required
                                                                class="appearance-none rounded-lg border border-slate-300 bg-white py-1 pl-4 pr-6 text-[10px] text-slate-700 focus:border-blue-500 focus:ring-blue-500"
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
                                                        </div>
                                                    </form>
                                                    <div x-data="{ show: false }"
                                                        x-show="openDeleteModal === {{ $order->id }}"
                                                        style="display: none;"
                                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                                                        <div
                                                            class="w-full max-w-sm rounded-2xl bg-white p-8 shadow-xl">
                                                            <h2 class="mb-2 text-lg font-bold text-slate-800">¿Eliminar
                                                                pedido?</h2>
                                                            <p class="mb-6 text-sm text-slate-600">Esta acción no se
                                                                puede deshacer. ¿Seguro que deseas eliminar este pedido?
                                                            </p>
                                                            <div class="flex justify-center gap-4">
                                                                <form method="POST"
                                                                    action="{{ route('orders.destroy', $order) }}"
                                                                    class="inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="inline-flex items-center justify-center rounded-xl bg-red-600 p-3 text-white transition hover:bg-red-700"
                                                                        title="Eliminar pedido">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            class="h-5 w-5" fill="none"
                                                                            viewBox="0 0 24 24" stroke="currentColor"
                                                                            stroke-width="2.2">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M5 13l4 4L19 7" />
                                                                        </svg>
                                                                    </button>
                                                                </form>
                                                                <button type="button" @click="openDeleteModal = null"
                                                                    class="inline-flex items-center justify-center rounded-xl bg-blue-600 p-3 text-white transition hover:bg-blue-700"
                                                                    title="Cancelar">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="h-5 w-5" fill="none"
                                                                        viewBox="0 0 24 24" stroke="currentColor"
                                                                        stroke-width="2.2">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M6 18L18 6M6 6l12 12" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span
                                                    class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                                    Solo lectura
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-4 py-8 text-center text-slate-500">
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
