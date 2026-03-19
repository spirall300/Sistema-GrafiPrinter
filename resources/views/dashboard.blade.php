<x-app-layout>
    <div class="flex min-h-screen bg-slate-200">

        <x-sidebar />

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
                            <a href="{{ route('orders.index') }}"
                                class="text-[10px] font-bold text-blue-600 underline">Ver todos</a>
                        </div>
                        <div
                            class="flex-1 overflow-hidden rounded-2xl bg-slate-50/50 border-4 border-dashed border-slate-50">
                            @if (isset($orders) && $orders->count())
                                <ul class="divide-y divide-slate-200">
                                    @foreach ($orders as $order)
                                        <li class="flex items-center justify-between px-4 py-3">
                                            <div>
                                                <p class="text-sm font-semibold text-slate-800">{{ $order->type }} ·
                                                    {{ $order->company_name }}</p>
                                                <p class="text-xs text-slate-500">Entrega:
                                                    {{ optional($order->delivery_date)->format('d/m/Y') }}</p>
                                            </div>
                                            <span
                                                class="text-xs font-semibold px-3 py-1 rounded-full {{ $order->status == 'Pagado' ? 'bg-emerald-100 text-emerald-700' : ($order->status == 'Revisado' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700') }}">
                                                {{ $order->status }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="flex flex-col items-center justify-center h-full">
                                    <span class="text-4xl mb-2">📦</span>
                                    <p class="text-slate-400 font-bold italic text-sm uppercase">Sin pedidos hoy</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-slate-900 rounded-3xl shadow-2xl p-6 text-white flex flex-col h-[400px]">
                        <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-4">
                            <h3 class="font-black text-blue-400 uppercase text-sm tracking-widest">
                                Calendario de Entregas
                            </h3>
                        </div>
                        <div class="flex-1 bg-slate-800/50 rounded-2xl border border-slate-700 flex flex-col p-4">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <p class="text-sm font-bold text-white uppercase tracking-widest">Próximas Entregas
                                    </p>
                                    <p class="text-xs text-slate-400">(Basado en la fecha de entrega)</p>
                                </div>
                                <span class="text-xl">📅</span>
                            </div>

                            @if (isset($upcomingDeliveries) && $upcomingDeliveries->count())
                                <ul class="space-y-3 overflow-y-auto max-h-[260px]">
                                    @foreach ($upcomingDeliveries as $delivery)
                                        <li class="flex items-center justify-between rounded-xl bg-slate-900/40 p-3">
                                            <div>
                                                <p class="text-sm font-semibold text-slate-100">{{ $delivery->type }}
                                                </p>
                                                <p class="text-xs text-slate-400">{{ $delivery->company_name }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xs text-slate-200 font-semibold">
                                                    {{ optional($delivery->delivery_date)->format('d/m/Y') }}</p>
                                                <p
                                                    class="text-[10px] mt-1 uppercase font-bold {{ $delivery->status == 'Pagado' ? 'text-emerald-300' : ($delivery->status == 'Revisado' ? 'text-blue-300' : 'text-yellow-300') }}">
                                                    {{ $delivery->status }}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="flex flex-col items-center justify-center h-full">
                                    <span class="text-6xl mb-3">🗓️</span>
                                    <p class="text-xs text-slate-300 font-bold text-center">No hay entregas programadas.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
