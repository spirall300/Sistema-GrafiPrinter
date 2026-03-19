<x-app-layout>
    <div class="flex min-h-screen bg-slate-200">
        <x-sidebar />

        <main class="flex-1 p-10 overflow-y-auto">
            <div class="max-w-6xl mx-auto">
                <div
                    class="bg-white rounded-3xl p-8 shadow-xl border-b-8 border-blue-600 mb-10 flex justify-between items-center relative overflow-hidden">
                    <div class="relative z-10">
                        <h2 class="text-3xl font-black text-slate-800">
                            GESTIONAR USUARIOS
                        </h2>
                        <p class="text-slate-500 font-medium mt-1 uppercase text-sm">Lista de usuarios registrados</p>
                    </div>
                    <div class="text-right z-10 hidden md:block">
                        <p class="text-4xl font-black text-slate-100 uppercase tracking-tighter">ADMIN</p>
                        <p class="text-xs font-mono text-slate-400">{{ now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-50 rounded-full opacity-50"></div>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="mb-6">
                    <a href="{{ route('admin.users.create') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Registrar Nuevo
                        Usuario</a>
                </div>

                <div class="bg-white rounded-3xl shadow-lg p-6 border border-slate-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-slate-50">
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                        Nombre</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                        Email</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                        Rol</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                        Fecha de Registro</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                        Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                            {{ $user->name }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-500">
                                            {{ $user->email }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-500">
                                            {{ ucfirst($user->role) }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-500">
                                            {{ $user->created_at->format('d/m/Y') }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                                class="text-blue-600 hover:text-blue-900 mr-4">Editar</a>
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                                class="inline"
                                                onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
