<x-app-layout>
    <div class="flex min-h-screen bg-slate-200">
        <x-sidebar />

        <main class="flex-1 p-10 overflow-y-auto">
            <div class="max-w-6xl mx-auto">
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
