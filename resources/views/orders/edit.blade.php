<x-app-layout>
    <div class="flex min-h-screen bg-slate-200">

        <x-sidebar />

        <main class="flex-1 p-10 overflow-y-auto">
            <div class="max-w-4xl mx-auto">
                <div
                    class="bg-white rounded-3xl p-8 shadow-xl border-b-8 border-blue-600 mb-10 flex justify-between items-center relative overflow-hidden">
                    <div class="relative z-10">
                        <h2 class="text-3xl font-black text-slate-800">
                            EDITAR PEDIDO
                        </h2>
                        <p class="text-slate-500 font-medium mt-1 uppercase text-sm">Modifica los datos del pedido</p>
                    </div>
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-50 rounded-full opacity-50"></div>
                </div>

                @if (session('status'))
                    <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                <form id="order-form" action="{{ route('orders.update', $order) }}" method="POST"
                    class="space-y-6 bg-white rounded-3xl shadow-lg p-8 border border-slate-100"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="type" :value="__('Tipo de Artículo')" class="text-slate-800 font-bold" />
                            <select id="type" name="type" required
                                class="mt-1 block w-full rounded-xl border border-slate-300 bg-white py-2 px-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Seleccione...</option>
                                @if ($productTypes->isEmpty())
                                    <option value="" disabled>No hay tipos de producto. Agrega uno en "Añadir Tipo
                                        de Producto".</option>
                                @else
                                    @foreach ($productTypes as $productType)
                                        <option value="{{ $productType->name }}"
                                            {{ old('type', $order->type) === $productType->name ? 'selected' : '' }}>
                                            {{ $productType->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="status" :value="__('Estado del Pedido')" class="text-slate-800 font-bold" />
                            <select id="status" name="status" required
                                class="mt-1 block w-full rounded-xl border border-slate-300 bg-white py-2 px-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-blue-500">
                                <option value="Pendiente"
                                    {{ old('status', $order->status) == 'Pendiente' ? 'selected' : '' }}>
                                    Pendiente
                                </option>
                                <option value="Revisado"
                                    {{ old('status', $order->status) == 'Revisado' ? 'selected' : '' }}>
                                    Revisado
                                </option>
                                <option value="Pagado"
                                    {{ old('status', $order->status) == 'Pagado' ? 'selected' : '' }}>
                                    Pagado
                                </option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="company_name" :value="__('Nombre de la Empresa')" class="text-slate-800 font-bold" />
                            <x-text-input id="company_name" name="company_name" type="text" required
                                value="{{ old('company_name', $order->company_name) }}"
                                class="mt-1 block w-full rounded-xl border border-slate-300 bg-white py-2 px-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-blue-500" />
                            <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="quantity" :value="__('Cantidad')" class="text-slate-800 font-bold" />
                            <x-text-input id="quantity" name="quantity" type="number" min="1" required
                                value="{{ old('quantity', $order->quantity) }}"
                                class="mt-1 block w-full rounded-xl border border-slate-300 bg-white py-2 px-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-blue-500" />
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="buyer" :value="__('Comprador')" class="text-slate-800 font-bold" />
                            <x-text-input id="buyer" name="buyer" type="text" required
                                value="{{ old('buyer', $order->buyer) }}"
                                class="mt-1 block w-full rounded-xl border border-slate-300 bg-white py-2 px-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-blue-500" />
                            <x-input-error :messages="$errors->get('buyer')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="identity_cedula" :value="__('Cédula de Identidad')" class="text-slate-800 font-bold" />
                            <x-text-input id="identity_cedula" name="identity_cedula" type="text" required
                                value="{{ old('identity_cedula', $order->identity_cedula) }}"
                                class="mt-1 block w-full rounded-xl border border-slate-300 bg-white py-2 px-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-blue-500" />
                            <x-input-error :messages="$errors->get('identity_cedula')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="entry_date" :value="__('Fecha de Ingreso')" class="text-slate-800 font-bold" />
                            <x-text-input id="entry_date" name="entry_date" type="date" required
                                value="{{ old('entry_date', optional($order->entry_date)->toDateString()) }}"
                                class="mt-1 block w-full rounded-xl border border-slate-300 bg-white py-2 px-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-blue-500" />
                            <x-input-error :messages="$errors->get('entry_date')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="delivery_date" :value="__('Fecha de Entrega')" class="text-slate-800 font-bold" />
                            <x-text-input id="delivery_date" name="delivery_date" type="date" required
                                value="{{ old('delivery_date', optional($order->delivery_date)->toDateString()) }}"
                                class="mt-1 block w-full rounded-xl border border-slate-300 bg-white py-2 px-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-blue-500" />
                            <x-input-error :messages="$errors->get('delivery_date')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="file" :value="__('Archivo de Diseño (opcional)')" class="text-slate-800 font-bold" />
                            <input id="file" name="file" type="file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                                class="mt-1 block w-full rounded-xl border border-slate-300 bg-white py-2 px-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-blue-500" />
                            <p class="mt-1 text-xs text-slate-500">Formatos permitidos: PDF, JPG, PNG, DOC, DOCX.
                                Máximo 10MB.</p>
                            @if ($order->file_path)
                                <p class="mt-2 text-xs text-slate-500">Archivo actual: <a
                                        href="{{ \Illuminate\Support\Facades\Storage::url($order->file_path) }}"
                                        target="_blank" class="text-blue-600 underline">Descargar</a></p>
                            @endif
                            <x-input-error :messages="$errors->get('file')" class="mt-2" />
                        </div>

                    </div>

                    <div class="flex items-center justify-end gap-4 pt-4">
                        <a href="{{ route('orders.index') }}"
                            class="text-sm font-semibold text-red-600 hover:text-red-700">
                            Cancelar
                        </a>
                        <button type="button" id="confirm-edit-btn"
                            class="bg-slate-900 hover:bg-blue-900 py-3 px-8 text-white font-bold rounded-xl shadow-lg transition">
                            Guardar Cambios
                        </button>
                    </div>
                    <!-- Modal de confirmación -->
                    <div id="modal-confirm-edit"
                        class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-40">
                        <div class="bg-white rounded-2xl shadow-xl p-8 max-w-xs w-full flex flex-col items-center">
                            <h3 class="text-lg font-bold text-slate-800 mb-2">¿Confirmar edición?</h3>
                            <p class="text-slate-600 text-sm mb-6 text-center">¿Deseas guardar los cambios realizados
                                en el pedido?</p>
                            <div class="flex gap-4 w-full justify-center">
                                <button type="button" id="cancel-modal-btn"
                                    class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-red-600 p-3 text-white transition hover:bg-red-700"
                                    aria-label="Cancelar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                                <button type="button" id="accept-modal-btn"
                                    class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600 p-3 text-white transition hover:bg-blue-700"
                                    aria-label="Confirmar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const form = document.getElementById('order-form');
                        const fileInput = document.getElementById('file');
                        const maxFileSize = 10 * 1024 * 1024; // 10MB
                        const confirmBtn = document.getElementById('confirm-edit-btn');
                        const modal = document.getElementById('modal-confirm-edit');
                        const cancelModalBtn = document.getElementById('cancel-modal-btn');
                        const acceptModalBtn = document.getElementById('accept-modal-btn');

                        if (!form || !fileInput || !confirmBtn || !modal) {
                            return;
                        }

                        confirmBtn.addEventListener('click', function() {
                            modal.classList.remove('hidden');
                            modal.classList.add('flex');
                        });
                        cancelModalBtn.addEventListener('click', function() {
                            modal.classList.add('hidden');
                            modal.classList.remove('flex');
                            window.location.href = '{{ route('orders.index') }}';
                        });
                        acceptModalBtn.addEventListener('click', function() {
                            modal.classList.add('hidden');
                            modal.classList.remove('flex');
                            form.submit();
                        });

                        form.addEventListener('submit', function(event) {
                            const file = fileInput.files[0];
                            if (file && file.size > maxFileSize) {
                                event.preventDefault();
                                alert('El archivo es demasiado grande. El tamaño máximo permitido es 10MB.');
                            }
                        });
                    });
                </script>
            </div>
        </main>
    </div>

    <script>
        // Oculta la URL cambiando a la raíz
        window.history.replaceState(null, null, '/');
    </script>
</x-app-layout>
