<div class="w-64 bg-slate-900 text-white min-h-screen shadow-xl">

    <div class="p-6 border-b border-slate-700">

        <h1 class="text-2xl font-bold text-cyan-400">
            Feria 2026
        </h1>

        <p class="text-sm text-gray-300">
            Panel Administrativo
        </p>

    </div>

    <div class="mt-6 space-y-2">
        <a href="{{ route('dashboard') }}"
        class="block px-6 py-3 hover:bg-slate-800">
            🏠 Panel Principal
        </a>
       @if(auth()->user()->es_admin)

            <a href="{{ route('docentes.index') }}"
            class="block px-6 py-3 hover:bg-slate-800">
                👨‍🏫 Docentes
            </a>

            <a href="{{ route('alumnos.index') }}"
            class="block px-6 py-3 hover:bg-slate-800">
                🎓 Alumnos
            </a>

            <a href="{{ route('cursos.index') }}"
            class="block px-6 py-3 hover:bg-slate-800">
                📚 Cursos
            </a>

            <a href="{{ route('materias.index') }}"
            class="block px-6 py-3 hover:bg-slate-800">
                📖 Materias
            </a>

            <a href="{{ route('asignaciones.index') }}"
            class="block px-6 py-3 hover:bg-slate-800">
                📝 Asignaciones Docente
            </a>

             <a
                href="{{ route('evaluadores.index') }}"
                class="block px-6 py-3 hover:bg-slate-800"
            >
                👨‍🏫 Asignar evaluadores
            </a>

        @endif
        <a href="{{ route('grupos.index') }}"
        class="block px-6 py-3 hover:bg-slate-800">
            🧪 Mis Grupos
        </a>
        <a href="{{ route('evaluaciones.index') }}"
        class="block px-6 py-3 hover:bg-slate-800">
            ⭐ Evaluaciones
        </a>
        @php
            $mostrarReportes =
                auth()->user()->es_admin
                || auth()->user()
                    ->gruposCreados()
                    ->exists();
        @endphp

        @if($mostrarReportes)

            <div class="px-6 pt-4 pb-1 text-xs font-bold uppercase text-slate-400">
                Reportes
            </div>

            <a
                href="{{ route('reportes.detalle') }}"
                class="block px-6 py-3 hover:bg-slate-800"
            >
                📊 Reporte detallado
            </a>

            <a
                href="{{ route('reportes.resumen') }}"
                class="block px-6 py-3 hover:bg-slate-800"
            >
                📋 Notas por curso
            </a>

        @endif
       <form method="POST" action="{{ route('cerrar.sesion') }}">
            @csrf
            <button type="submit"
                class="block w-full text-left px-6 py-3 hover:bg-slate-800">
                🚪 Cerrar sesión
            </button>
        </form>
    </div>

</div>
