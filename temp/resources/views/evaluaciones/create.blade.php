@extends('layouts.app')

@section('contenido')

<div class="max-w-6xl mx-auto px-4 py-6">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">
            Evaluar proyecto
        </h1>

        <p class="mt-1 text-slate-600">
            Registre la evaluación grupal y la nota individual de cada estudiante.
        </p>
    </div>

    @if(session('error'))
        <div class="mb-5 rounded-lg border border-red-300 bg-red-100 px-4 py-3 text-red-800">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-8 rounded-xl bg-white p-6 shadow">

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

            <div>
                <p class="text-sm font-medium text-slate-500">
                    Grupo
                </p>

                <p class="text-lg font-semibold text-slate-800">
                    {{ $grupo->nombre_grupo }}
                </p>
            </div>

            <div>
                <p class="text-sm font-medium text-slate-500">
                    Curso
                </p>

                <p class="text-slate-800">
                    {{ $grupo->curso?->nombre ?? 'Sin curso' }}
                </p>
            </div>

            <div>
                <p class="text-sm font-medium text-slate-500">
                    Materia
                </p>

                <p class="text-slate-800">
                    {{ $grupo->materia?->nombre ?? 'Sin materia' }}
                </p>
            </div>

            <div>
                <p class="text-sm font-medium text-slate-500">
                    Tema
                </p>

                <p class="text-slate-800">
                    {{ $grupo->tema ?? 'Sin tema' }}
                </p>
            </div>

        </div>

    </div>

    <form
        action="{{ route('evaluaciones.store', $grupo->id) }}"
        method="POST"
        id="formEvaluacion"
    >
        @csrf

        {{-- Evaluación grupal --}}
        <div class="mb-8 rounded-xl bg-white p-6 shadow">

            <h2 class="mb-2 text-lg font-semibold text-slate-800">
                Evaluación grupal
            </h2>

            <p class="mb-6 text-sm text-slate-500">
                Estos tres criterios se aplicarán a todos los integrantes.
            </p>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

                <div>
                    <label
                        for="dominio_tema"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Dominio del tema
                    </label>

                    <input
                        type="number"
                        name="dominio_tema"
                        id="dominio_tema"
                        min="0"
                        max="15"
                        value="{{ old('dominio_tema') }}"
                        class="criterio-grupal w-full rounded-lg border px-3 py-2 {{ $errors->has('dominio_tema') ? 'border-red-500' : 'border-slate-300' }}"
                    >

                    <p class="mt-1 text-xs text-slate-500">
                        Puntaje de 0 a 15.
                    </p>

                    @error('dominio_tema')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="material_apoyo"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Material de apoyo
                    </label>

                    <input
                        type="number"
                        name="material_apoyo"
                        id="material_apoyo"
                        min="0"
                        max="15"
                        value="{{ old('material_apoyo') }}"
                        class="criterio-grupal w-full rounded-lg border px-3 py-2 {{ $errors->has('material_apoyo') ? 'border-red-500' : 'border-slate-300' }}"
                    >

                    <p class="mt-1 text-xs text-slate-500">
                        Puntaje de 0 a 15.
                    </p>

                    @error('material_apoyo')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="expresion_defensa"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Expresión y defensa
                    </label>

                    <input
                        type="number"
                        name="expresion_defensa"
                        id="expresion_defensa"
                        min="0"
                        max="15"
                        value="{{ old('expresion_defensa') }}"
                        class="criterio-grupal w-full rounded-lg border px-3 py-2 {{ $errors->has('expresion_defensa') ? 'border-red-500' : 'border-slate-300' }}"
                    >

                    <p class="mt-1 text-xs text-slate-500">
                        Puntaje de 0 a 15.
                    </p>

                    @error('expresion_defensa')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            <div class="mt-6 rounded-lg bg-blue-50 p-4">

                <p class="text-sm font-medium text-blue-700">
                    Nota grupal
                </p>

                <p class="text-3xl font-bold text-blue-800">
                    <span id="notaGrupal">0</span> / 45
                </p>

            </div>

        </div>

        {{-- Evaluación individual --}}
        <div class="rounded-xl bg-white p-6 shadow">

            <h2 class="mb-2 text-lg font-semibold text-slate-800">
                Evaluación individual
            </h2>

            <p class="mb-6 text-sm text-slate-500">
                Asigne a cada estudiante una nota individual de 0 a 45.
                La nota final será el promedio entre la nota grupal y la individual.
            </p>

            <div class="space-y-5">

                @foreach($grupo->alumnos as $alumno)

                    <div class="rounded-xl border border-slate-200 p-5">

                        <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">

                            <div>
                                <p class="text-sm font-medium text-slate-500">
                                    Estudiante
                                </p>

                                <p class="mt-1 font-semibold text-slate-800">
                                    {{ $alumno->nombre }}
                                </p>
                            </div>

                            <div>
                                <label
                                    for="nota_individual_{{ $alumno->id }}"
                                    class="mb-2 block text-sm font-medium text-slate-700"
                                >
                                    Nota individual
                                </label>

                                <input
                                    type="number"
                                    name="notas_individuales[{{ $alumno->id }}]"
                                    id="nota_individual_{{ $alumno->id }}"
                                    min="0"
                                    max="45"
                                    value="{{ old('notas_individuales.' . $alumno->id) }}"
                                    data-alumno="{{ $alumno->id }}"
                                    class="nota-individual w-full rounded-lg border px-3 py-2 {{ $errors->has('notas_individuales.' . $alumno->id) ? 'border-red-500' : 'border-slate-300' }}"
                                >

                                @error('notas_individuales.' . $alumno->id)
                                    <p class="mt-1 text-sm text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <p class="mb-2 text-sm font-medium text-slate-700">
                                    Nota final
                                </p>

                                <div class="rounded-lg bg-green-50 px-4 py-3">
                                    <span
                                        id="nota-final-{{ $alumno->id }}"
                                        class="text-2xl font-bold text-green-700"
                                    >
                                        0.00
                                    </span>

                                    <span class="text-green-700">
                                        / 45
                                    </span>
                                </div>
                            </div>

                        </div>

                        <div class="mt-5">

                            <label
                                for="observacion_{{ $alumno->id }}"
                                class="mb-2 block text-sm font-medium text-slate-700"
                            >
                                Observación individual
                            </label>

                            <textarea
                                name="observaciones[{{ $alumno->id }}]"
                                id="observacion_{{ $alumno->id }}"
                                rows="3"
                                placeholder="Observación opcional sobre el desempeño del estudiante."
                                class="w-full rounded-lg border px-3 py-2 {{ $errors->has('observaciones.' . $alumno->id) ? 'border-red-500' : 'border-slate-300' }}"
                            >{{ old('observaciones.' . $alumno->id) }}</textarea>

                            @error('observaciones.' . $alumno->id)
                                <p class="mt-1 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                @endforeach

            </div>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row">

                <button
                    type="submit"
                    class="rounded-lg bg-green-600 px-5 py-2 font-semibold text-white transition hover:bg-green-700"
                    onclick="return confirm('¿Está seguro de guardar la evaluación? Después no podrá modificarla.');"
                >
                    Guardar evaluación
                </button>

                <a
                    href="{{ route('evaluaciones.index') }}"
                    class="rounded-lg bg-slate-500 px-5 py-2 text-center font-semibold text-white transition hover:bg-slate-600"
                >
                    Cancelar
                </a>

            </div>

        </div>

    </form>

</div>

<script>
    const criteriosGrupales =
        document.querySelectorAll('.criterio-grupal');

    const notasIndividuales =
        document.querySelectorAll('.nota-individual');

    const notaGrupalTexto =
        document.getElementById('notaGrupal');

    function obtenerNotaGrupal() {
        let total = 0;

        criteriosGrupales.forEach(function (campo) {
            let valor = parseInt(campo.value) || 0;

            if (valor < 0) {
                valor = 0;
            }

            if (valor > 15) {
                valor = 15;
            }

            total += valor;
        });

        return total;
    }

    function calcularNotas() {
        const notaGrupal = obtenerNotaGrupal();

        notaGrupalTexto.textContent = notaGrupal;

        notasIndividuales.forEach(function (campo) {
            const alumnoId = campo.dataset.alumno;

            let notaIndividual =
                parseInt(campo.value) || 0;

            if (notaIndividual < 0) {
                notaIndividual = 0;
            }

            if (notaIndividual > 45) {
                notaIndividual = 45;
            }

            const notaFinal =
                (notaGrupal + notaIndividual) / 2;

            const resultado =
                document.getElementById(
                    'nota-final-' + alumnoId
                );

            resultado.textContent =
                notaFinal.toFixed(2);
        });
    }

    criteriosGrupales.forEach(function (campo) {
        campo.addEventListener(
            'input',
            calcularNotas
        );
    });

    notasIndividuales.forEach(function (campo) {
        campo.addEventListener(
            'input',
            calcularNotas
        );
    });

    calcularNotas();
</script>

@endsection