<x-app-layout>
    <div class="flex min-h-screen bg-slate-200">
        <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-slate-200 relative">
            <!-- Botón menú solo en móvil -->
            <button @click="sidebarOpen = true"
                class="md:hidden block fixed top-6 left-4 z-50 bg-blue-700 hover:bg-blue-800 text-white p-4 rounded-full shadow-2xl border-4 border-white focus:outline-none focus:ring-2 focus:ring-blue-400 flex items-center justify-center transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    class="w-9 h-9">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 7h16M4 12h16M4 17h16"
                        stroke="#fff" />
                </svg>
            </button>
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
                    class="bg-white rounded-3xl p-8 shadow-xl border-b-8 border-blue-600 mb-10 flex justify-between items-center relative overflow-hidden">
                    <div class="relative z-10">
                        <h2 class="text-3xl font-black text-slate-800">
                            BITÁCORA DE ACTIVIDAD
                        </h2>
                        <p class="text-slate-500 font-medium mt-1 uppercase text-sm">Registros de acciones realizadas
                            por usuarios</p>
                    </div>
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-50 rounded-full opacity-50"></div>
                </div>

                <div class="bg-white rounded-3xl shadow-lg p-6 border border-slate-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-slate-50">
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                        Fecha</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                        Usuario</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                        Acción</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                        IP</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                        User Agent</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @forelse($logs as $log)
                                    <tr>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-500">
                                            {{ $log->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                            {{ $log->user->name ?? 'Desconocido' }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-500">
                                            {{ $log->accion }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-500">
                                            {{ $log->ip_address }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-500">
                                            {{ \Illuminate\Support\Str::limit($log->user_agent, 60) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-4 text-sm text-slate-500">No hay registros en
                                            la bitácora.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $logs->links() }}
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
