<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-blue-300 font-bold uppercase tracking-widest">Verificación de Seguridad</h2>
    </div>

    <form method="POST" action="{{ route('password.questions.verify') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="p-4 bg-slate-900 rounded-lg border border-blue-500">
            <p class="text-blue-300 text-xs uppercase font-bold mb-2">Tu pregunta registrada:</p>
            <p class="text-white text-lg italic mb-4">"{{ $question }}"</p>

            <x-input-label for="answer" :value="__('Tu Respuesta')" class="text-blue-100 text-sm" />
            <x-text-input id="answer" class="block mt-1 w-full bg-white text-slate-900" type="text" name="answer"
                required autofocus />
        </div>

        <x-primary-button class="w-full justify-center mt-6 bg-green-700 hover:bg-green-800">
            VERIFICAR Y CONTINUAR
        </x-primary-button>
    </form>
</x-guest-layout>
