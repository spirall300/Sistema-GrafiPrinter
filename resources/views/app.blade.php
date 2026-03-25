@extends('layouts.app')

@section('content')
    <div x-data="app()" class="min-h-screen bg-gray-100">
        <!-- Sección Login -->
        <div x-show="page === 'login'" x-transition>
            @include('auth.login')
        </div>

        <!-- Sección Dashboard -->
        <div x-show="page === 'dashboard'" x-transition>
            @include('dashboard')
        </div>

        <!-- Más secciones si necesitas -->
    </div>

    <script>
        function app() {
            return {
                page: window.location.hash.substring(1) || 'login', // Lee el hash, por defecto 'login'

                init() {
                    // Escucha cambios en el hash
                    window.addEventListener('hashchange', () => {
                        this.page = window.location.hash.substring(1) || 'login';
                    });
                }
            }
        }
    </script>
@endsection
