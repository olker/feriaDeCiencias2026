@auth

<nav class="space-y-1 px-3 py-5">

    {{-- Inicio --}}
    <a
        href="{{ route('dashboard') }}"
        class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition
        {{ request()->routeIs('dashboard')
            ? 'bg-blue-600 text-white'
            : 'text-slate-200 hover:bg-slate-800 hover:text-white' }}"
    >
        <span>🏠</span>
        <span>Inicio</span>
    </a>

    {{-- Administrador --}}
    @if(auth()->user()->es_admin)

        <div class="px-4 pb-1 pt-5 text-xs font-bold uppercase tracking-wider text-slate-500">
            Administración
        </div>

        <a
            href="{{ route('docentes.index') }}"
            class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition
            {{ request()->routeIs('docentes.*')
                ? 'bg-blue-600 text-white'
                : 'text-slate-200 hover:bg-slate-800 hover:text-white' }}"
        >
            <span>👨‍🏫</span>
            <span>Docentes</span>
        </a>

        <a
            href="{{ route('alumnos.index') }}"
            class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition
            {{ request()->routeIs('alumnos.*')
                ? 'bg-blue-600 text-white'
                : 'text-slate-200 hover:bg-slate-800 hover:text-white' }}"
        >
            <span>👨‍🎓</span>
            <span>Estudiantes</span>
        </a>

        <a
            href="{{ route('cursos.index') }}"
            class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition
            {{ request()->routeIs('cursos.*')
                ? 'bg-blue-600 text-white'
                : 'text-slate-200 hover:bg-slate-800 hover:text-white' }}"
        >
            <span>🏫</span>
            <span>Cursos</span>
        </a>

        <a
            href="{{ route('materias.index') }}"
            class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition
            {{ request()->routeIs('materias.*')
                ? 'bg-blue-600 text-white'
                : 'text-slate-200 hover:bg-slate-800 hover:text-white' }}"
        >
            <span>📚</span>
            <span>Materias</span>
        </a>

        <a
            href="{{ route('asignaciones.index') }}"
            class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition
            {{ request()->routeIs('asignaciones.*')
                ? 'bg-blue-600 text-white'
                : 'text-slate-200 hover:bg-slate-800 hover:text-white' }}"
        >
            <span>📌</span>
            <span>Asignar cursos</span>
        </a>

        <a
            href="{{ route('evaluadores.index') }}"
            class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition
            {{ request()->routeIs('evaluadores.*')
                ? 'bg-blue-600 text-white'
                : 'text-slate-200 hover:bg-slate-800 hover:text-white' }}"
        >
            <span>✅</span>
            <span>Asignar evaluadores</span>
        </a>

    @endif

    {{-- Feria --}}
    <div class="px-4 pb-1 pt-5 text-xs font-bold uppercase tracking-wider text-slate-500">
        Feria
    </div>

    <a
        href="{{ route('grupos.index') }}"
        class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition
        {{ request()->routeIs('grupos.*')
            ? 'bg-blue-600 text-white'
            : 'text-slate-200 hover:bg-slate-800 hover:text-white' }}"
    >
        <span>👥</span>
        <span>Grupos</span>
    </a>

    @if(!auth()->user()->es_admin)

        <a
            href="{{ route('evaluaciones.index') }}"
            class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition
            {{ request()->routeIs('evaluaciones.*')
                ? 'bg-blue-600 text-white'
                : 'text-slate-200 hover:bg-slate-800 hover:text-white' }}"
        >
            <span>📝</span>
            <span>Evaluaciones</span>
        </a>

    @endif

    {{-- Reportes --}}
    @php
        $mostrarReportes =
            auth()->user()->es_admin
            || \App\Models\Grupo::where(
                'docente_creador_id',
                auth()->id()
            )->exists();
    @endphp

    @if($mostrarReportes)

        <div class="px-4 pb-1 pt-5 text-xs font-bold uppercase tracking-wider text-slate-500">
            Reportes
        </div>

        <a
            href="{{ route('reportes.detalle') }}"
            class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition
            {{ request()->routeIs('reportes.detalle')
                ? 'bg-blue-600 text-white'
                : 'text-slate-200 hover:bg-slate-800 hover:text-white' }}"
        >
            <span>📊</span>
            <span>Reporte detallado</span>
        </a>

        <a
            href="{{ route('reportes.resumen') }}"
            class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition
            {{ request()->routeIs('reportes.resumen')
                ? 'bg-blue-600 text-white'
                : 'text-slate-200 hover:bg-slate-800 hover:text-white' }}"
        >
            <span>📋</span>
            <span>Notas por curso</span>
        </a>

    @endif

    {{-- Cerrar sesión --}}
    <div class="pt-6">

        <form
            action="{{ route('cerrar.sesion') }}"
            method="POST"
        >
            @csrf

            <button
                type="submit"
                class="flex w-full items-center gap-3 rounded-lg px-4 py-3 text-left text-sm font-medium text-red-300 transition hover:bg-red-900/40 hover:text-red-200"
            >
                <span>🚪</span>
                <span>Cerrar sesión</span>
            </button>

        </form>

    </div>

</nav>

@endauth