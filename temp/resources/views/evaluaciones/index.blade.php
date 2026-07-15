@extends('layouts.app')

@section('contenido')

<div class="max-w-7xl mx-auto px-4 py-6">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">
            Asignación de evaluadores
        </h1>

        <p class="mt-1 text-slate-600">
            Asigne los proyectos que debe evaluar cada docente.
        </p>
    </div>

    @if(session('success'))
        <div class="mb-5 rounded-lg border border-green-300 bg-green-100 px-4 py-3 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-5 rounded-lg border border-red-300 bg-red-100 px-4 py-3 text-red-800">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-8 rounded-xl bg-white p-6 shadow">

        <h2 class="mb-5 text-lg font-semibold text-slate-800">
            Nueva asignación
        </h2>

        <form
            action="{{ route('evaluadores.store') }}"
            method="POST"
        >
            @csrf

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                <div>
                    <label
                        for="docente_id"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Docente evaluador
                    </label>

                    <select
                            name="docente_id"
                            id="docente_id"
                            @class([
                                'w-full rounded-lg border px-3 py-2',
                                'border-red-500' => $errors->has('docente_id'),
                                'border-slate-300' => !$errors->has('docente_id'),
                            ])
                        >
                        <option value="">
                            Seleccione un docente
                        </option>

                        @foreach($docentes as $docente)
                            <option
                                value="{{ $docente->id }}"
                                {{ old('docente_id') == $docente->id ? 'selected' : '' }}
                            >
                                {{ $docente->nombre }}
                            </option>
                        @endforeach
                    </select>

                    @error('docente_id')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="grupo_id"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Grupo o proyecto
                    </label>

                    <select
                            name="grupo_id"
                            id="grupo_id"
                            @class([
                                'w-full rounded-lg border px-3 py-2',
                                'border-red-500' => $errors->has('grupo_id'),
                                'border-slate-300' => !$errors->has('grupo_id'),
                            ])
                        >
                        <option value="">
                            Seleccione un grupo
                        </option>

                        @foreach($grupos as $grupo)
                            <option
                                value="{{ $grupo->id }}"
                                {{ old('grupo_id') == $grupo->id ? 'selected' : '' }}
                            >
                                {{ $grupo->nombre_grupo }}
                                —
                                {{ $grupo->materia?->nombre ?? 'Sin materia' }}
                            </option>
                        @endforeach
                    </select>

                    @error('grupo_id')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            <div class="mt-6">
                <button
                    type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-2 font-semibold text-white transition hover:bg-blue-700"
                >
                    Guardar asignación
                </button>
            </div>

        </form>
    </div>

    <div class="overflow-hidden rounded-xl bg-white shadow">

        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-lg font-semibold text-slate-800">
                Evaluadores asignados
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="bg-slate-100 text-xs uppercase text-slate-700">
                    <tr>
                        <th class="px-6 py-3">
                            Docente
                        </th>

                        <th class="px-6 py-3">
                            Grupo
                        </th>

                        <th class="px-6 py-3">
                            Tema
                        </th>

                        <th class="px-6 py-3">
                            Materia
                        </th>

                        <th class="px-6 py-3 text-center">
                            Acción
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200">

                    @forelse($asignaciones as $asignacion)

                        <tr class="hover:bg-slate-50">

                            <td class="px-6 py-4">
                                {{ $asignacion->docente?->nombre ?? 'Docente no encontrado' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $asignacion->grupo?->nombre_grupo ?? 'Grupo no encontrado' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $asignacion->grupo?->tema ?? 'Sin tema' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $asignacion->grupo?->materia?->nombre ?? 'Sin materia' }}
                            </td>

                            <td class="px-6 py-4 text-center">

                                <form
                                    action="{{ route('evaluadores.destroy', $asignacion->id) }}"
                                    method="POST"
                                    class="inline"
                                    onsubmit="return confirm('¿Desea eliminar esta asignación?');"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="rounded-lg bg-red-600 px-3 py-2 text-white transition hover:bg-red-700"
                                    >
                                        Eliminar
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="5"
                                class="px-6 py-8 text-center text-slate-500"
                            >
                                No existen evaluadores asignados.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection