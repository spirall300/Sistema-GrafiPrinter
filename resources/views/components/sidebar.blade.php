<aside class="hidden md:block w-72 bg-slate-900 shadow-2xl flex-shrink-0 border-r border-blue-900/30">
    <div class="p-6">
        <img src="{{ asset('logo.png') }}" alt="GrafiPrinter Logo" class="w-16 h-16 mx-auto mb-2 rounded-full shadow-lg">
        <h1 class="text-xl font-black italic text-white tracking-widest leading-none text-center">
            SISTEMA GRAFIPRINTER
        </h1>
        <p class="text-sm text-blue-400 font-black uppercase tracking-tighter mt-1 text-center">Menú Principal</p>
    </div>

    <nav class="mt-4 px-4 space-y-3">
        <div>
            <button
                class="flex items-center justify-between w-full p-4 text-sm font-black text-white bg-blue-600 rounded-xl transition-all duration-300 group shadow-lg">
                <div class="flex items-center gap-3">
                    <span class="text-lg group-hover:scale-110 transition">📦</span>
                    <span class="tracking-tight">GESTIÓN PEDIDOS</span>
                </div>
            </button>

            <div class="mt-2 ml-6 space-y-2 border-l-2 border-blue-500 bg-slate-800/30 rounded-r-lg py-2">
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
                <div>
                    <button
                        class="flex items-center justify-between w-full p-4 text-sm font-black text-white bg-blue-600 rounded-xl transition-all duration-300 group shadow-lg">
                        <div class="flex items-center gap-3">
                            <span class="text-lg group-hover:scale-110 transition">⚙️</span>
                            <span class="tracking-tight">ADMINISTRACIÓN</span>
                        </div>
                    </button>

                    <div class="mt-2 ml-6 space-y-2 border-l-2 border-blue-500 bg-slate-800/30 rounded-r-lg py-2">
                        {{-- <a href="{{ route('inventory.index') }}"
                            class="block p-2 text-sm font-bold text-white !important hover:text-blue-400 pl-4 italic transition hover:translate-x-1">
                            • Inventario
                        </a> --}}
                        @if (Auth::user()->role == 'admin')
                            <a href="{{ route('bitacoras.index') }}"
                                class="block p-2 text-sm font-bold text-white !important hover:text-blue-400 pl-4 transition hover:translate-x-1">
                                • Bitácora
                            </a>
                            <a href="{{ route('admin.users.index') }}"
                                class="block p-2 text-sm font-bold text-white !important hover:text-blue-400 pl-4 transition hover:translate-x-1">
                                • Gestionar Usuarios
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </nav>

    <div class="mt-6 border-t border-white/10 px-4 pt-4 pb-6">
        <a href="https://creativecommons.org/licenses/by-nc-nd/4.0/" target="_blank" rel="noopener noreferrer"
            class="flex flex-wrap items-center justify-center gap-1 text-[10px] leading-4 text-slate-300 transition hover:text-white">
            <span>Este trabajo está licenciado bajo</span>
            <span class="font-semibold text-slate-100">CC BY-NC-ND 4.0</span>
            <span class="flex items-center gap-1" aria-hidden="true">
                <img src="https://mirrors.creativecommons.org/presskit/icons/cc.svg" alt=""
                    class="h-3.5 w-3.5" />
                <img src="https://mirrors.creativecommons.org/presskit/icons/by.svg" alt=""
                    class="h-3.5 w-3.5" />
                <img src="https://mirrors.creativecommons.org/presskit/icons/nc.svg" alt=""
                    class="h-3.5 w-3.5" />
                <img src="https://mirrors.creativecommons.org/presskit/icons/nd.svg" alt=""
                    class="h-3.5 w-3.5" />
            </span>
        </a>
    </div>
</aside>
