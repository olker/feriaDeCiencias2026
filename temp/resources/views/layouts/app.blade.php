<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name', 'Feria de Ciencias') }}
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="min-h-screen bg-slate-100 text-slate-800">

<div
    x-data="{ menuAbierto: false }"
    class="min-h-screen"
>

    {{-- Barra superior para celulares --}}
    <header
        class="fixed inset-x-0 top-0 z-40 flex h-16 items-center justify-between bg-slate-900 px-4 text-white shadow-lg lg:hidden"
    >
        <div class="flex items-center gap-3">

            <button
                type="button"
                @click="menuAbierto = true"
                class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-800 text-2xl transition hover:bg-slate-700"
                aria-label="Abrir menú"
            >
                ☰
            </button>

            <div>
                <p class="text-sm font-bold">
                    Feria de Ciencias
                </p>

                <p class="text-xs text-slate-300">
                    U. E. Yugoslavia
                </p>
            </div>

        </div>

        @auth
            <div class="max-w-[130px] truncate text-right text-xs text-slate-300">
                {{ auth()->user()->nombre }}
            </div>
        @endauth
    </header>

    {{-- Fondo oscuro del menú móvil --}}
    <div
        x-cloak
        x-show="menuAbierto"
        x-transition.opacity
        @click="menuAbierto = false"
        class="fixed inset-0 z-40 bg-black/60 lg:hidden"
    ></div>

    {{-- Menú lateral móvil --}}
    <aside
        x-cloak
        x-show="menuAbierto"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed inset-y-0 left-0 z-50 flex w-72 max-w-[85vw] flex-col bg-slate-900 text-white shadow-2xl lg:hidden"
    >
        <div class="flex h-16 items-center justify-between border-b border-slate-700 px-5">

            <div>
                <p class="font-bold">
                    Menú principal
                </p>

                <p class="text-xs text-slate-400">
                    Feria de Ciencias 2026
                </p>
            </div>

            <button
                type="button"
                @click="menuAbierto = false"
                class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-800 text-xl hover:bg-slate-700"
                aria-label="Cerrar menú"
            >
                ✕
            </button>

        </div>

        <div
            class="flex-1 overflow-y-auto"
            @click="menuAbierto = false"
        >
            @include('layouts.navigation')
        </div>

    </aside>

    {{-- Menú lateral de escritorio --}}
    <aside
        class="fixed inset-y-0 left-0 z-30 hidden w-64 flex-col bg-slate-900 text-white shadow-xl lg:flex"
    >
        <div class="flex h-20 items-center border-b border-slate-700 px-6">

            <div>
                <h1 class="text-lg font-bold">
                    Feria de Ciencias
                </h1>

                <p class="text-xs text-slate-400">
                    U. E. Yugoslavia
                </p>
            </div>

        </div>

        <div class="flex-1 overflow-y-auto">
            @include('layouts.navigation')
        </div>

    </aside>

    {{-- Contenido principal --}}
    <div class="min-h-screen lg:pl-64">

        {{-- Barra superior de escritorio --}}
        <header
            class="hidden h-20 items-center justify-between border-b border-slate-200 bg-white px-8 shadow-sm lg:flex"
        >
            <div>
                <h2 class="text-xl font-bold text-slate-800">
                    Sistema de Feria de Ciencias
                </h2>

                <p class="text-sm text-slate-500">
                    Gestión de grupos, evaluaciones y reportes
                </p>
            </div>

            @auth
                <div class="text-right">
                    <p class="font-semibold text-slate-800">
                        {{ auth()->user()->nombre }}
                    </p>

                    <p class="text-xs text-slate-500">
                        {{ auth()->user()->es_admin ? 'Administrador' : 'Docente' }}
                    </p>
                </div>
            @endauth
        </header>

        <main class="pt-16 lg:pt-0">

            <div class="w-full px-3 py-4 sm:px-5 lg:px-8 lg:py-7">

                @yield('contenido')

            </div>

        </main>

    </div>

</div>

</body>
</html>