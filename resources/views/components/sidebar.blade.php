<aside class="w-72 bg-slate-900 shadow-2xl flex-shrink-0 border-r border-blue-900/30">
    <div class="p-6">
        <h1 class="text-xl font-black italic text-white tracking-widest leading-none">
            SISTEMA GRAFIPRINTER
        </h1>
        <p class="text-sm text-blue-400 font-black uppercase tracking-tighter mt-1">Menú Principal</p>
    </div>

    <nav class="mt-4 px-4 space-y-3">
        <div x-data="{ open: false }">
            <button @click="open = !open"
                class="flex items-center justify-between w-full p-4 text-sm font-black text-white bg-slate-800/50 hover:bg-blue-600 rounded-xl transition-all duration-300 group">
                <div class="flex items-center gap-3">
                    <span class="text-lg group-hover:scale-110 transition">📦</span>
                    <span class="tracking-tight">GESTIÓN PEDIDOS</span>
                </div>
                <svg class="w-5 h-5 transition-transform duration-300 text-blue-400 group-hover:text-white"
                    :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7">
                    </path>
                </svg>
            </button>

            <div x-show="open" x-cloak
                class="mt-2 ml-6 space-y-2 border-l-2 border-blue-500 bg-slate-800/30 rounded-r-lg py-2">
                <a href="{{ route('orders.create') }}"
                    class="block p-2 text-sm font-bold text-white !important hover:text-blue-400 pl-4 transition hover:translate-x-1">
                    • Crear Nuevo Pedido
                </a>
                <a href="{{ route('orders.index') }}"
                    class="block p-2 text-sm font-bold text-white !important hover:text-blue-400 pl-4 transition hover:translate-x-1">
                    • Ver Seguimiento
                </a>
                @if (Auth::user()->role == 'admin')
                    <a href="{{ route('product-types.index') }}"
                        class="block p-2 text-sm font-bold text-white !important hover:text-blue-400 pl-4 transition hover:translate-x-1">
                        • Añadir Tipo de Producto
                    </a>
                @endif
            </div>
        </div>

        @if (in_array(Auth::user()->role, ['admin', 'encargado']))
            <div class="pt-6">
                <p class="px-4 text-[10px] font-black text-blue-500 uppercase mb-2 tracking-widest">
                    Configuración Avanzada</p>

                <div x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full p-4 text-sm font-black text-white bg-slate-800/50 hover:bg-slate-700 rounded-xl transition-all group">
                        <div class="flex items-center gap-3">
                            <span class="text-lg group-hover:scale-110 transition">⚙️</span>
                            <span class="tracking-tight">ADMINISTRACIÓN</span>
                        </div>
                        <svg class="w-5 h-5 transition-transform duration-300 text-blue-400 group-hover:text-white"
                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <div x-show="open" x-cloak
                        class="mt-2 ml-6 space-y-2 border-l-2 border-blue-500 bg-slate-800/30 rounded-r-lg py-2">
                        <a href="{{ route('inventory.index') }}"
                            class="block p-2 text-sm font-bold text-white !important hover:text-blue-400 pl-4 italic transition hover:translate-x-1">
                            • Inventario
                        </a>
                        @if (Auth::user()->role == 'admin')
                            <a href="{{ route('bitacoras.index') }}"
                                class="block p-2 text-sm font-bold text-white !important hover:text-blue-400 pl-4 italic transition hover:translate-x-1">
                                • Bitácora
                            </a>
                            <a href="{{ route('admin.users.index') }}"
                                class="block p-2 text-sm font-bold text-white !important hover:text-blue-400 pl-4 italic transition hover:translate-x-1">
                                • Gestionar Usuarios
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </nav>
</aside>
