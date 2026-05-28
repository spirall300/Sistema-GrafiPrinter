<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <button type="button"
                            class="block w-full px-4 py-2 text-start text-sm leading-5 text-blue-700 hover:bg-blue-100 transition"
                            @click="$dispatch('open-notifications-modal')">
                            <span class="inline-flex items-center gap-2">
                                <svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4 inline' fill='none'
                                    viewBox='0 0 24 24' stroke='currentColor'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2'
                                        d='M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9' />
                                </svg>
                                Notificaciones
                            </span>
                        </button>
                        <x-dropdown-link href="#" @click.prevent="$dispatch('open-logout-modal')">
                            <span class="inline-flex items-center gap-2">
                                <svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4 inline' fill='none'
                                    viewBox='0 0 24 24' stroke='currentColor'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2'
                                        d='M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 11-4 0v-1' />
                                </svg>
                                {{ __('Log Out') }}
                            </span>
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>

<div x-data="{ showNotificationsModal: false }" @open-notifications-modal.window="showNotificationsModal = true"
    x-show="showNotificationsModal" style="display: none;"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
    <div class="bg-white rounded-2xl shadow-xl p-8 max-w-md w-full flex flex-col items-center"
        @click.away="showNotificationsModal = false">
        <h2 class="text-lg font-bold text-slate-800 mb-2">Notificaciones</h2>
        <ul class="text-slate-700 text-sm mb-6 w-full list-disc pl-5">
            @if (isset($soonDeliveries) && $soonDeliveries->count())
                @foreach ($soonDeliveries as $soon)
                    <li>
                        <span class="font-semibold">{{ $soon->type }}</span> —
                        {{ $soon->company_name }} <span
                            class="italic">({{ \Carbon\Carbon::parse($soon->delivery_date)->format('d/m/Y') }})</span>
                    </li>
                @endforeach
            @else
                <li>No hay notificaciones nuevas.</li>
            @endif
        </ul>
        <button type="button" @click="showNotificationsModal = false"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl font-semibold">Cerrar</button>
    </div>
</div>

<div x-data="{ showLogoutModal: false }" @open-logout-modal.window="showLogoutModal = true" x-show="showLogoutModal"
    style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
    <div class="bg-white rounded-2xl shadow-xl p-8 max-w-sm w-full flex flex-col items-center"
        @click.away="showLogoutModal = false">
        <h2 class="text-lg font-bold text-slate-800 mb-2">¿Cerrar sesión?</h2>
        <p class="text-slate-600 text-sm mb-6">¿Seguro que deseas cerrar tu sesión?</p>
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <div class="flex gap-4 w-full justify-center">
                <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl font-semibold">Sí, cerrar
                    sesión</button>
                <button type="button" @click="showLogoutModal = false"
                    class="bg-slate-200 hover:bg-slate-300 text-slate-800 px-4 py-2 rounded-xl font-semibold">Cancelar</button>
            </div>
        </form>
    </div>
</div>
