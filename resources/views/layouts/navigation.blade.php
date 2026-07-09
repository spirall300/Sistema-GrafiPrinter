@php
    $activeNotificationsCount = isset($soonDeliveries) ? $soonDeliveries->count() : 0;
@endphp

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
                            class="flex w-full items-center justify-between px-4 py-2 text-start text-sm font-semibold leading-5 text-blue-700 hover:bg-slate-100 transition"
                            @click="$dispatch('open-notifications-modal')">
                            <span class="inline-flex items-center gap-2">
                                <span class="relative">
                                    <svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4 inline' fill='none'
                                        viewBox='0 0 24 24' stroke='currentColor'>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2'
                                            d='M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9' />
                                    </svg>
                                    @if ($activeNotificationsCount > 0)
                                        <span
                                            class="absolute -top-2 -right-2 inline-flex h-4 w-4 items-center justify-center rounded-full bg-blue-600 text-[10px] font-bold text-white ring-2 ring-white">
                                            {{ $activeNotificationsCount }}
                                        </span>
                                    @endif
                                </span>
                                Notificaciones
                            </span>
                        </button>
                        <x-dropdown-link href="#" @click.prevent="$dispatch('open-logout-modal')"
                            class="text-red-600 hover:bg-red-50 hover:text-red-700">
                            <span class="inline-flex items-center gap-2">
                                <svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4 inline' fill='none'
                                    viewBox='0 0 24 24' stroke='currentColor'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2'
                                        d='M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 11-4 0v-1' />
                                </svg>
                                Cerrar sesión
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
    class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 px-4">
    <div class="w-full max-w-lg overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl"
        @click.away="showNotificationsModal = false">
        <div class="bg-slate-900 px-6 py-5">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-black uppercase tracking-wider text-blue-400">Notificaciones</h2>
                    <p class="text-sm text-slate-300">Pedidos pagados próximos a entregar</p>
                </div>
            </div>
        </div>
        <div class="p-6">
            <ul class="space-y-3">
                @if (isset($soonDeliveries) && $soonDeliveries->count())
                    @foreach ($soonDeliveries as $soon)
                        <li class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                                    <circle cx="12" cy="12" r="9" />
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="text-sm font-semibold text-slate-800">{{ $soon->type }}</p>
                                    <span
                                        class="rounded-full bg-amber-100 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-amber-700">
                                        Próximo
                                    </span>
                                </div>
                                <p class="mt-1 text-sm text-slate-600">{{ $soon->company_name }}</p>
                                <p class="mt-1 text-xs text-slate-500">
                                    Entrega: {{ \Carbon\Carbon::parse($soon->delivery_date)->format('d/m/Y') }}
                                </p>
                            </div>
                        </li>
                    @endforeach
                @else
                    <li
                        class="flex items-center gap-3 rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-4">
                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">Todo al día</p>
                            <p class="text-sm text-slate-600">No hay notificaciones nuevas por ahora.</p>
                        </div>
                    </li>
                @endif
            </ul>
            <div class="mt-6 flex justify-end">
                <a href="{{ route('orders.index') }}"
                    class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
                    Ver detalles
                </a>
            </div>
        </div>
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
                    class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-red-600 p-3 text-white transition hover:bg-red-700"
                    aria-label="Aceptar cierre de sesión">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
                <button type="button" @click="showLogoutModal = false"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600 p-3 text-white transition hover:bg-blue-700"
                    aria-label="Cancelar cierre de sesión">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>
