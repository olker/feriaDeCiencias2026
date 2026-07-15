<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Feria 2026</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100">

    <div class="min-h-screen flex">

        {{-- Menú lateral --}}
        @include('layouts.navigation')

        {{-- Contenido principal --}}
        <main class="flex-1 p-6">
            @yield('contenido')
        </main>

    </div>

</body>
</html>