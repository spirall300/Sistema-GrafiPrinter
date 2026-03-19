<x-app-layout>
    <div class="flex min-h-screen bg-slate-200">

        <aside class="w-72 bg-slate-900 shadow-2xl flex-shrink-0 border-r border-blue-900/30">
            <div class="p-6">
                <h1 class="text-xl font-black italic text-white tracking-widest leading-none">
                    SISTEMA TALONARIOS</span>
                </h1>
                <p class="text-[10px] text-blue-400 font-bold uppercase tracking-tighter mt-2">Panel de Administración
                </p>
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
                        <a href="#"
                            class="block p-2 text-sm font-bold text-white !important hover:text-blue-400 pl-4 transition hover:translate-x-1">
                            • Crear Nuevo Pedido
                        </a>
                        <a href="#"
                            class="block p-2 text-sm font-bold text-white !important hover:text-blue-400 pl-4 transition hover:translate-x-1">
                            • Ver Seguimiento
                        </a>
                    </div>
                </div>

                @if (Auth::user()->role == 'admin')
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
                                    :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open" x-cloak
                                class="mt-2 ml-6 space-y-2 border-l-2 border-slate-500 bg-slate-800/30 rounded-r-lg py-2">
                                <a href="#"
                                    class="block p-2 text-sm font-bold text-white !important hover:text-blue-400 pl-4 italic transition hover:translate-x-1">
                                    • Tipos de Productos
                                </a>
                                <a href="{{ route('profile.edit') }}"
                                    class="block p-2 text-sm font-bold text-white !important hover:text-blue-400 pl-4 italic transition hover:translate-x-1">
                                    • Gestionar Usuarios
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </nav>
        </aside>

        <main class="flex-1 p-10 overflow-y-auto">
            <div class="max-w-5xl mx-auto">
                <div
                    class="bg-white rounded-3xl p-8 shadow-xl border-b-8 border-blue-600 mb-10 flex justify-between items-center relative overflow-hidden">
                    <div class="relative z-10">
                        <h2 class="text-3xl font-black text-slate-800">
                            BIENVENIDO, <span class="text-blue-600">{{ strtoupper(Auth::user()->name) }}</span>
                        </h2>
                        <p class="text-slate-500 font-medium mt-1 uppercase text-sm">Nivel de acceso: <span
                                class="font-bold text-blue-500">{{ Auth::user()->role }}</span></p>
                    </div>
                    <div class="text-right z-10 hidden md:block">
                        <p class="text-4xl font-black text-slate-100 uppercase tracking-tighter">DASHBOARD</p>
                        <p class="text-xs font-mono text-slate-400">{{ now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-50 rounded-full opacity-50"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-white rounded-3xl shadow-lg p-6 border border-slate-100 flex flex-col h-[400px]">
                        <div class="flex items-center justify-between border-b pb-4 mb-4">
                            <h3
                                class="font-black text-slate-800 uppercase text-sm tracking-widest flex items-center gap-2">
                                <span class="w-3 h-3 bg-blue-600 rounded-full animate-pulse"></span>
                                Seguimiento de Pedidos
                            </h3>
                            <button class="text-[10px] font-bold text-blue-600 underline">Ver todos</button>
                        </div>
                        <div
                            class="flex-1 flex flex-col items-center justify-center border-4 border-dashed border-slate-50 rounded-2xl bg-slate-50/50">
                            <span class="text-4xl mb-2">📦</span>
                            <p class="text-slate-400 font-bold italic text-sm uppercase">Sin pedidos hoy</p>
                        </div>
                    </div>

                    <div class="bg-slate-900 rounded-3xl shadow-2xl p-6 text-white flex flex-col h-[400px]">
                        <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-4">
                            <h3 class="font-black text-blue-400 uppercase text-sm tracking-widest">
                                Calendario de Entregas
                            </h3>
                        </div>
                        <div
                            class="flex-1 bg-slate-800/50 rounded-2xl border border-slate-700 flex flex-col items-center justify-center p-4">
                            <div class="text-5xl mb-4">📅</div>
                            <p class="text-xs text-slate-300 font-bold text-center leading-relaxed">
                                Sincronización con <br>
                                <span class="text-blue-400 uppercase">FullCalendar API</span> <br>
                                Próximamente.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
