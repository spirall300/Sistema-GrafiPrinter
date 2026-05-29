<x-app-layout>
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-slate-200 relative">
        <!-- Botón menú solo en móvil -->
<<<<<<< HEAD
        @include('components.sidebar-hamburger')
=======
        <button @click="sidebarOpen = true"
            class="md:hidden block fixed top-6 left-4 z-50 bg-blue-700 hover:bg-blue-800 text-white p-4 rounded-full shadow-2xl border-4 border-white focus:outline-none focus:ring-2 focus:ring-blue-400 flex items-center justify-center transition-all duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-7 h-7">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 7h16M4 12h16M4 17h16"
                    stroke="#fff" />
            </svg>
        </button>
>>>>>>> 5314ffeff583e2d3e622bc9c89d9f83a96f15f9d
        <!-- Sidebar modal en móvil -->
        <template x-if="sidebarOpen">
            <div class="fixed inset-0 z-50 flex items-center justify-center">
                <div @click="sidebarOpen = false" class="absolute inset-0 bg-slate-900/40"></div>
                <div
                    class="relative w-11/12 max-w-sm bg-slate-900 shadow-2xl rounded-2xl border-2 border-blue-900/30 flex flex-col animate-fade-in mx-auto">
                    @include('components.sidebar-modal')
                </div>
            </div>
        </template>
        <x-sidebar />

        <main class="flex-1 p-10 overflow-y-auto">
            <div class="max-w-4xl mx-auto">
                <div
                    class="bg-white rounded-3xl p-8 shadow-xl border-b-8 border-blue-600 mb-10 flex justify-between items-center relative overflow-hidden">
                    <div class="relative z-10">
                        <h2 class="text-3xl font-black text-slate-800">
                            CREAR USUARIO
                        </h2>
                        <p class="text-slate-500 font-medium mt-1 uppercase text-sm">Registrar un nuevo usuario en el
                            sistema</p>
                    </div>
                    <div class="text-right z-10 hidden md:block">
                        <p class="text-4xl font-black text-slate-700 uppercase tracking-tighter">ADMIN</p>
                        <p class="text-xs font-mono text-slate-600">{{ now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-50 rounded-full opacity-50"></div>
                </div>

                <form x-ref="createUserForm" method="POST" action="{{ route('admin.users.store') }}"
                    class="bg-white rounded-3xl shadow-lg p-8 border border-slate-100" x-data="passwordStrength()">
                    @csrf

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
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Nombre</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="role" class="block text-sm font-medium text-slate-700 mb-2">Tipo de
                            Usuario</label>
                        <select name="role" id="role"
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="encargado" {{ old('role') == 'encargado' ? 'selected' : '' }}>Encargado
                            </option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Contraseña</label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" name="password" id="password"
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                :class="passwordTouched && !isPasswordValid ? 'border-red-500' : 'border-slate-300'"
                                x-model="password" @input="passwordTouched = true; checkStrength(); checkMatch();"
                                required>
                            <button type="button" tabindex="-1" @click="showPassword = !showPassword"
                                class="absolute right-2 top-2 text-slate-500 hover:text-blue-600">
                                <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.042-3.368m3.087-2.86A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.965 9.965 0 01-4.873 5.607M15 12a3 3 0 11-6 0 3 3 0 016 0zm-6.708 6.708L20.485 3.515" />
                                </svg>
                            </button>
                        </div>
                        <!-- Medidor de fortaleza -->
                        <div class="mt-2 h-2 w-full bg-slate-200 rounded-full overflow-hidden">
                            <div :class="strengthBarClass" :style="'width:' + strengthPercent + '%'"
                                class="h-2 transition-all"></div>
                        </div>
                        <div class="mt-2 flex flex-wrap gap-2 text-xs">
                            <span
                                :class="passwordTouched ? (lengthValid ? 'text-green-600' : 'text-red-500') : 'text-slate-400'">Mín.
                                16 caracteres</span>
                            <span
                                :class="passwordTouched ? (upperValid ? 'text-green-600' : 'text-red-500') : 'text-slate-400'">Mayúscula</span>
                            <span
                                :class="passwordTouched ? (lowerValid ? 'text-green-600' : 'text-red-500') : 'text-slate-400'">Minúscula</span>
                            <span
                                :class="passwordTouched ? (symbolValid ? 'text-green-600' : 'text-red-500') : 'text-slate-400'">Número
                                o símbolo</span>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-slate-700 mb-2">Confirmar Contraseña</label>
                        <div class="relative">
                            <input :type="showPasswordConfirm ? 'text' : 'password'" name="password_confirmation"
                                id="password_confirmation"
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                :class="passwordTouched && !passwordsMatch ? 'border-red-500' : 'border-slate-300'"
                                x-model="passwordConfirm" @input="passwordTouched = true; checkMatch();" required>
                            <button type="button" tabindex="-1" @click="showPasswordConfirm = !showPasswordConfirm"
                                class="absolute right-2 top-2 text-slate-500 hover:text-blue-600">
                                <svg x-show="!showPasswordConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showPasswordConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.042-3.368m3.087-2.86A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.965 9.965 0 01-4.873 5.607M15 12a3 3 0 11-6 0 3 3 0 016 0zm-6.708 6.708L20.485 3.515" />
                                </svg>
                            </button>
                        </div>
                        <div class="mt-2 text-xs" x-show="passwordTouched">
                            <span :class="passwordsMatch ? 'text-green-600' : 'text-red-500'">
                                <template x-if="passwordConfirm.length > 0">
                                    <span
                                        x-text="passwordsMatch ? 'Las contraseñas coinciden' : 'Las contraseñas no coinciden'"></span>
                                </template>
                            </span>
                        </div>
                        @error('password_confirmation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="security_question" class="block text-sm font-medium text-slate-700 mb-2">Pregunta
                            de
                            Seguridad</label>
                        <select name="security_question" id="security_question"
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Seleccionar pregunta</option>
                            <option value="1" {{ old('security_question') == '1' ? 'selected' : '' }}>¿Cuál es su
                                color favorito?</option>
                            <option value="2" {{ old('security_question') == '2' ? 'selected' : '' }}>¿Cuál es su
                                comida favorita?</option>
                            <option value="3" {{ old('security_question') == '3' ? 'selected' : '' }}>¿Cuál es su
                                pasatiempo favorito?</option>
                            <option value="4" {{ old('security_question') == '4' ? 'selected' : '' }}>¿Cuál es su
                                deporte favorito?</option>
                            <option value="5" {{ old('security_question') == '5' ? 'selected' : '' }}>¿Cuál es su
                                fruta favorita?</option>
                            <option value="6" {{ old('security_question') == '6' ? 'selected' : '' }}>¿Cuál es su
                                música favorita?</option>
                        </select>
                        @error('security_question')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="security_answer" class="block text-sm font-medium text-slate-700 mb-2">Respuesta
                            de
                            Seguridad</label>
                        <input type="text" name="security_answer" id="security_answer"
                            value="{{ old('security_answer') }}"
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('security_answer')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('admin.users.index') }}"
                            class="mr-4 px-4 py-2 bg-slate-300 text-slate-700 rounded-md hover:bg-slate-400">Cancelar</a>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Crear
                            Usuario</button>
                    </div>
                </form>
                <!-- Modal de confirmación eliminado temporalmente para pruebas -->
            </div>
        </main>
    </div>

    <script>
        // Oculta la URL cambiando a la raíz
        window.history.replaceState(null, null, '/');

        function passwordStrength() {
            return {
                password: '',
                passwordConfirm: '',
                showPassword: false,
                showPasswordConfirm: false,
                passwordTouched: false,
                strengthPercent: 0,
                strengthBarClass: 'bg-red-400',
                passwordsMatch: true,
                isPasswordValid: false,
                lengthValid: false,
                upperValid: false,
                lowerValid: false,
                symbolValid: false,
                checkStrength() {
                    const pwd = this.password;
                    this.lengthValid = pwd.length >= 16;
                    this.upperValid = /[A-Z]/.test(pwd);
                    this.lowerValid = /[a-z]/.test(pwd);
                    this.symbolValid = /[0-9!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/.test(pwd);
                    let score = 0;
                    if (this.lengthValid) score += 1;
                    if (this.upperValid) score += 1;
                    if (this.lowerValid) score += 1;
                    if (this.symbolValid) score += 1;
                    this.strengthPercent = score * 25;
                    if (score <= 1) this.strengthBarClass = 'bg-red-400';
                    else if (score === 2) this.strengthBarClass = 'bg-yellow-400';
                    else if (score === 3) this.strengthBarClass = 'bg-blue-400';
                    else this.strengthBarClass = 'bg-green-500';
                    this.isPasswordValid = score === 4;
                },
                checkMatch() {
                    this.passwordsMatch = this.password === this.passwordConfirm && this.password.length > 0;
                }
            }
        }
    </script>
</x-app-layout>
