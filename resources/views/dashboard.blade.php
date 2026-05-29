<x-app-layout>
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-slate-200 relative">
        <!-- Botón menú solo en móvil -->
        @include('components.sidebar-hamburger')
        <!-- Sidebar modal en móvil -->
        <template x-if="sidebarOpen">
            <div class="fixed inset-0 z-50 flex items-center justify-center">
                <!-- Overlay: cierra modal al hacer click fuera -->
                <div @click="sidebarOpen = false" class="absolute inset-0 bg-slate-900/40"></div>
                <!-- Modal centrado, tamaño ajustado -->
                <div
                    class="relative w-11/12 max-w-sm bg-slate-900 shadow-2xl rounded-2xl border-2 border-blue-900/30 flex flex-col animate-fade-in mx-auto">
                    <!-- Botón de cerrar (X) eliminado por requerimiento -->
                    @include('components.sidebar-modal')
                </div>
            </div>
        </template>
        <x-sidebar />
        <main class="flex-1 p-10 overflow-y-auto">
            <div class="max-w-4xl mx-auto">

                {{-- Notificación de pedidos próximos a entregar --}}
                @if (isset($soonDeliveries) && $soonDeliveries->count() && !session('soonDeliveriesDismissed'))
                    <div x-data="{ showSoon: true }" x-show="showSoon" class="mb-6">
                        <div
                            class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-blue-50 border-l-4 border-blue-600 rounded-xl p-4 shadow-lg">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-blue-600 text-2xl">📦</span>
                                    <span class="font-semibold text-blue-900 text-base">Tienes
                                        {{ $soonDeliveries->count() }}
                                        pedido{{ $soonDeliveries->count() > 1 ? 's' : '' }}
                                        próximo{{ $soonDeliveries->count() > 1 ? 's' : '' }} a entregar</span>
                                </div>
                                <ul class="ml-8 mt-1 text-blue-900 text-sm list-disc">
                                    @foreach ($soonDeliveries as $soon)
                                        <li>
                                            <span class="font-semibold">{{ $soon->type }}</span> —
                                            {{ $soon->company_name }} <span
                                                class="italic">({{ \Carbon\Carbon::parse($soon->delivery_date)->format('d/m/Y') }})</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="flex flex-col gap-2 items-end">
                                <a href="{{ route('orders.index') }}"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold text-xs hover:bg-blue-700 transition">Ver
                                    detalles</a>
                                <button
                                    @click="
                                    showSoon = false;
                                    fetch('/dashboard/soon-deliveries-dismiss', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                            'Accept': 'application/json',
                                            'Content-Type': 'application/json'
                                        },
                                        credentials: 'same-origin'
                                    });
                                "
                                    class="text-blue-700 text-xs underline hover:text-blue-900 mt-1">Cerrar</button>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Header del Dashboard --}}
                <div
                    class="bg-white rounded-3xl p-8 shadow-xl border-b-8 border-blue-600 mb-10 flex justify-between items-center relative overflow-hidden">
                    <div class="relative z-10">
                        <h2 class="text-3xl font-black text-slate-800">
                            BIENVENIDO, <span class="text-blue-600">{{ strtoupper(Auth::user()->name) }}</span>
                        </h2>
                        <p class="text-slate-500 font-medium mt-1 uppercase text-sm">
                            Nivel de acceso: <span class="font-bold text-blue-500">{{ Auth::user()->role }}</span>
                        </p>
                    </div>
                    <div class="text-right z-10 hidden md:block">
                        <p class="text-4xl font-black text-slate-700 uppercase tracking-tighter">DASHBOARD</p>
                        <p class="text-xs font-mono text-slate-600">{{ now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-50 rounded-full opacity-50"></div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

                    {{-- Lista de Pedidos --}}
                    <div class="bg-white rounded-3xl shadow-lg p-6 border border-slate-100 flex flex-col h-[480px]">
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
                            class="flex-1 overflow-y-auto rounded-2xl bg-slate-50/50 border-4 border-dashed border-slate-50">
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

                    {{-- Calendario de Entregas --}}
                    <div class="bg-slate-900 rounded-3xl shadow-2xl p-6 text-white flex flex-col h-[480px]">
                        <div class="flex flex-col border-b border-slate-800 pb-4 mb-3 gap-2">
                            <div class="flex-1">
                                <h3 class="font-black text-blue-400 uppercase text-sm tracking-widest text-center">
                                    Calendario de Entregas</h3>
                                <p class="text-xs text-slate-200 text-center font-medium">Pedidos organizados por fecha
                                </p>
                            </div>
                        </div>

                        @php
                            $today = \Illuminate\Support\Carbon::today();
                            $startOfMonth = $calendarDate->copy()->startOfMonth();
                            $endOfMonth = $calendarDate->copy()->endOfMonth();
                            $startWeekDay = $startOfMonth->dayOfWeek;
                            $totalDays = $endOfMonth->day;
                            $cells = [];

                            for ($i = 0; $i < $startWeekDay; $i++) {
                                $cells[] = null;
                            }
                            for ($day = 1; $day <= $totalDays; $day++) {
                                $date = $startOfMonth->copy()->day($day);
                                $cells[] = [
                                    'date' => $date->format('Y-m-d'),
                                    'day' => $day,
                                    'isToday' => $date->isSameDay($today),
                                ];
                            }
                            while (count($cells) % 7 !== 0) {
                                $cells[] = null;
                            }
                            $weeks = array_chunk($cells, 7);

                            $currentWeekIndex = 0;
                            foreach ($weeks as $index => $week) {
                                foreach ($week as $dayCell) {
                                    if ($dayCell && $dayCell['isToday']) {
                                        $currentWeekIndex = $index;
                                        break 2;
                                    }
                                }
                            }

                            $yearOptions = collect(range($calendarDate->year - 1, $calendarDate->year + 1))
                                ->map(
                                    fn($year) => [
                                        'value' => (string) $year,
                                        'label' => (string) $year,
                                        'current' => $year === $calendarDate->year,
                                    ],
                                )
                                ->all();

                            $monthOptions = collect(range(1, 12))
                                ->map(
                                    fn($month) => [
                                        'value' => str_pad($month, 2, '0', STR_PAD_LEFT),
                                        'label' => \Illuminate\Support\Carbon::createFromDate(
                                            $calendarDate->year,
                                            $month,
                                            1,
                                        )->translatedFormat('F'),
                                    ],
                                )
                                ->all();

                            $deliveryDays = collect($upcomingDeliveries ?? [])
                                ->groupBy(fn($d) => optional($d->delivery_date)->format('Y-m-d'))
                                ->map(
                                    fn($group) => $group->map(
                                        fn($d) => [
                                            'id' => $d->id,
                                            'type' => $d->type,
                                            'company' => $d->company_name,
                                            'status' => $d->status,
                                        ],
                                    ),
                                )
                                ->toArray();
                        @endphp

                        {{-- Datos del calendario y entregas para Alpine --}}
                        <div x-data='{ weeks: @json($weeks), deliveries: @json($deliveryDays), activeWeek: {{ $currentWeekIndex }}, showModal: false, showMonthPicker: false, monthOptions: @json($monthOptions), yearOptions: @json($yearOptions), selectedYear: "{{ $calendarDate->year }}", currentYear: "{{ $calendarDate->year }}", currentMonthValue: "{{ $calendarDate->format('m') }}", minYear: "{{ $calendarDate->year - 1 }}", maxYear: "{{ $calendarDate->year + 1 }}", dashboardRoute: "{{ route('dashboard') }}", prevMonthUrl: @json(route('dashboard', ['month' => $calendarDate->copy()->subMonth()->format('Y-m')])), nextMonthUrl: @json(route('dashboard', ['month' => $calendarDate->copy()->addMonth()->format('Y-m')])), selectDate(date){ if(!date) return; this.selectedDate = date; this.showModal = true; }, changeYear(delta){ const year = parseInt(this.selectedYear) + delta; if(year < parseInt(this.minYear) || year > parseInt(this.maxYear)) return; this.selectedYear = year.toString(); }, goPrevWeek(){ if(this.activeWeek === 0) { window.location.href = this.prevMonthUrl; } else { this.activeWeek -= 1; } }, goNextWeek(){ if(this.activeWeek === this.weeks.length - 1) { window.location.href = this.nextMonthUrl; } else { this.activeWeek += 1; } } }'
                            class="flex flex-col flex-1 justify-between overflow-hidden">

                            {{-- Navegación de semanas --}}
                            <div class="w-full flex flex-col items-center py-2 mb-1 relative overflow-visible gap-2">
                                <!-- Fecha actual encima del selector de mes -->
                                <a href="{{ route('dashboard') }}"
                                    class="mb-2 flex items-center justify-center gap-2 rounded-full bg-blue-600 border border-blue-600 px-4 py-2 text-xs tracking-widest text-white hover:bg-blue-700 transition font-black shadow"
                                    title="Volver al mes actual">
                                    <span class="font-bold">Fecha actual</span>
                                    <span class="text-blue-100">|</span>
                                    <span class="uppercase">{{ now()->translatedFormat('d M, Y') }}</span>
                                </a>
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="goPrevWeek()"
                                        class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-100 text-blue-700 hover:bg-blue-600 hover:text-white transition-colors border border-blue-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                    <div class="relative">
                                        <button type="button" @click.prevent="showMonthPicker = !showMonthPicker"
                                            class="min-w-[160px] rounded-full bg-blue-600 px-4 py-2 text-center text-white hover:bg-blue-700 transition font-black shadow">
                                            <div class="text-[11px] font-black uppercase tracking-widest text-center">
                                                {{ $calendarDate->translatedFormat('F Y') }}
                                            </div>
                                            <div class="text-[9px] uppercase tracking-widest text-blue-100 text-center">
                                                Semana <span x-text="activeWeek + 1"></span></div>
                                        </button>
                                        <div x-show="showMonthPicker" x-cloak
                                            class="fixed inset-0 z-50 flex items-center justify-center p-4">
                                            <div @click.away="showMonthPicker = false"
                                                class="w-[min(90vw,44rem)] max-w-[44rem] bg-slate-900 rounded-3xl p-4 border border-slate-800 shadow-2xl">
                                                <div class="mb-3">
                                                    <h4 class="text-sm font-black text-blue-200">Seleccionar mes</h4>
                                                </div>
                                                <div class="mb-4 text-center">
                                                    <div class="mb-2 text-xs uppercase tracking-[0.2em] text-blue-200">
                                                        Año</div>
                                                    <div class="flex justify-center">
                                                        <div
                                                            class="inline-flex items-center gap-2 rounded-full bg-slate-800 px-3 py-2">
                                                            <button type="button" @click="changeYear(-1)"
                                                                class="h-9 w-9 rounded-full bg-blue-800 text-blue-100 transition hover:bg-blue-700"
                                                                :class="selectedYear == minYear ?
                                                                    'opacity-40 cursor-not-allowed' : ''"
                                                                :disabled="selectedYear == minYear"
                                                                aria-label="Año anterior">
                                                                <svg class="w-4 h-4 mx-auto" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="3"
                                                                        d="M15 19l-7-7 7-7" />
                                                                </svg>
                                                            </button>
                                                            <span
                                                                class="min-w-[3rem] text-center text-sm font-bold text-blue-100"
                                                                x-text="selectedYear"></span>
                                                            <button type="button" @click="changeYear(1)"
                                                                class="h-9 w-9 rounded-full bg-blue-800 text-blue-100 transition hover:bg-blue-700"
                                                                :class="selectedYear == maxYear ?
                                                                    'opacity-40 cursor-not-allowed' : ''"
                                                                :disabled="selectedYear == maxYear"
                                                                aria-label="Año siguiente">
                                                                <svg class="w-4 h-4 mx-auto" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="3"
                                                                        d="M9 5l7 7-7 7" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-3 gap-2 justify-center">
                                                    {{-- Lista de meses para seleccionar, ahora en cuadrícula 3x4 --}}
                                                    <template x-for="(month, idx) in monthOptions"
                                                        :key="month.value">
                                                        <a :href="dashboardRoute + '?month=' + selectedYear + ' - ' + month.value"
                                                            @click="showMonthPicker = false"
                                                            class="rounded-lg px-3 py-2 text-sm text-center transition min-w-[80px]"
                                                            :class="selectedYear == currentYear && month.value ==
                                                                currentMonthValue ? 'bg-blue-600 text-white' :
                                                                'bg-blue-100 text-blue-700'"
                                                            x-text="month.label"></a>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" @click="goNextWeek()"
                                        class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-100 text-blue-700 hover:bg-blue-600 hover:text-white transition-colors border border-blue-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div
                                class="flex-1 flex flex-col justify-center bg-slate-950/40 rounded-2xl p-2 border border-slate-800/60 shadow-inner overflow-hidden min-h-[180px] max-h-[220px]">
                                <div
                                    class="flex flex-row justify-between w-full text-center text-[10px] font-black uppercase tracking-widest text-blue-400 border-b border-slate-800/50 pb-1 mb-2">
                                    <div class="w-[14.28%]">Dom</div>
                                    <div class="w-[14.28%]">Lun</div>
                                    <div class="w-[14.28%]">Mar</div>
                                    <div class="w-[14.28%]">Mié</div>
                                    <div class="w-[14.28%]">Jue</div>
                                    <div class="w-[14.28%]">Vie</div>
                                    <div class="w-[14.28%]">Sáb</div>
                                </div>
                                <template x-for="(w, wi) in weeks" :key="wi">
                                    <div x-show="activeWeek === wi"
                                        class="flex flex-row justify-between w-full min-h-[32px]">
                                        <template x-for="(cell, ci) in w" :key="ci">
                                            <div class="w-[14.28%] flex flex-col items-center px-0.5">
                                                {{-- Botón del día: hoy azul, día con pedidos verde, días vacíos opacos --}}
                                                <button type="button" :disabled="!cell"
                                                    @click="selectDate(cell ? cell.date : null)"
                                                    :class="!cell ? 'opacity-0' : (cell.isToday ?
                                                        'border-blue-500 bg-blue-600 text-white shadow-lg scale-105' :
                                                        ((deliveries[cell.date] || []).length ?
                                                            'border-emerald-500 bg-emerald-600 text-white shadow-lg scale-105' :
                                                            'border-slate-700 bg-slate-800/80 hover:bg-slate-700'))"
                                                    class="w-full py-1.5 rounded-xl border text-sm font-bold transition-all transform hover:shadow-lg hover:scale-105 min-h-[28px]">
                                                    <span x-text="cell ? cell.day : ''"></span>
                                                </button>
                                                {{-- Indicador pequeño si hay entregas en este día --}}
                                                <div class="h-1.5 mt-1.5">
                                                    <template x-if="cell && (deliveries[cell.date] || []).length">
                                                        <span
                                                            class="block w-1.5 h-1.5 rounded-full animate-pulse bg-emerald-400"></span>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>

                            {{-- Modal de entregas: muestra los pedidos del día seleccionado --}}
                            <div x-show="showModal" x-cloak
                                class="fixed inset-0 z-50 flex items-center justify-center p-4">
                                <div @click="showModal = false" class="absolute inset-0 bg-black/60"></div>
                                <div
                                    class="relative w-[min(90vw,44rem)] max-w-[44rem] max-h-[70vh] overflow-auto bg-white rounded-3xl p-4 shadow-2xl">
                                    <div class="flex justify-between items-center mb-3">
                                        <h4 class="font-black text-slate-800 uppercase text-sm">Entregas del día</h4>
                                        <button @click="showModal = false"
                                            class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-slate-100 text-slate-700 hover:bg-slate-200 transition"
                                            aria-label="Cerrar">
                                            <span class="text-lg leading-none">×</span>
                                        </button>
                                    </div>
                                    <div class="space-y-2 max-h-[56vh] overflow-y-auto">
                                        <template x-if="selectedDate && (deliveries[selectedDate] || []).length">
                                            <template x-for="item in (selectedDate ? deliveries[selectedDate] : [])"
                                                :key="item.id">
                                                <div
                                                    class="p-3 rounded-lg bg-slate-50 border flex justify-between items-center">
                                                    <div>
                                                        <div class="font-bold text-sm text-blue-700"
                                                            x-text="item.type"></div>
                                                        <div class="text-xs text-slate-500" x-text="item.company">
                                                        </div>
                                                    </div>
                                                    <div class="text-[11px] font-bold uppercase px-2 py-0.5 rounded-full bg-blue-100 text-blue-700"
                                                        x-text="item.status"></div>
                                                </div>
                                            </template>
                                        </template>
                                        <template x-if="!selectedDate || !(deliveries[selectedDate] || []).length">
                                            <p class="text-sm text-slate-600">No hay entregas para ese día.</p>
                                        </template>
                                    </div>
                                </div>
                            </div>
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
