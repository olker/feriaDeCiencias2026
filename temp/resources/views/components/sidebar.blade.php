<aside class="w-64 bg-slate-800 text-white min-h-screen">

    <div class="p-5 text-center border-b border-slate-700">

        <h2 class="text-xl font-bold">
            Menú Principal
        </h2>

    </div>

    <ul class="p-4 space-y-2">

        <li>
            <a href="{{ route('home') }}"
               class="block p-3 rounded hover:bg-slate-700">
                Dashboard
            </a>
        </li>

        <li>
            <a href="{{ route('docentes.index') }}"
               class="block p-3 rounded hover:bg-slate-700">
                Docentes
            </a>
        </li>

        <li>
            <a href="{{ route('alumnos.index') }}"
               class="block p-3 rounded hover:bg-slate-700">
                Alumnos
            </a>
        </li>

        <li>
            <a href="{{ route('cursos.index') }}"
               class="block p-3 rounded hover:bg-slate-700">
                Cursos
            </a>
        </li>

        <li>
            <a href="{{ route('materias.index') }}"
               class="block p-3 rounded hover:bg-slate-700">
                Materias
            </a>
        </li>

    </ul>

</aside>