@extends('layouts.app')

@section('contenido')

<div class="max-w-7xl mx-auto px-4 py-6">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">
            Asignación de docentes
        </h1>

        <p class="text-slate-600 mt-1">
            Asigne un docente a un curso y una materia.
        </p>
    </div>

    @if(session('success'))
        <div class="mb-5 rounded-lg bg-green-100 border border-green-300 px-4 py-3 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-5 rounded-lg bg-red-100 border border-red-300 px-4 py-3 text-red-800">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow p-6 mb-8">

        <h2 class="text-lg font-semibold text-slate-800 mb-5">
            Nueva asignación
        </h2>

        <form action="{{ route('asignaciones.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <div>
                    <label for="docente_id" class="block text-sm font-medium text-slate-700 mb-2">
                        Docente
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
                        <option value="">Seleccione un docente</option>

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
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="curso_id" class="block text-sm font-medium text-slate-700 mb-2">
                        Curso
                    </label>

                    <select
                        name="curso_id"
                        id="curso_id"
                        class="w-full rounded-lg border px-3 py-2
                        @class([
                            'border-red-500' => $errors->has('curso_id'),
                            'border-slate-300' => !$errors->has('curso_id'),
                        ])"
                    >
                        <option value="">Seleccione un curso</option>

                        @foreach($cursos as $curso)
                            <option
                                value="{{ $curso->id }}"
                                {{ old('curso_id') == $curso->id ? 'selected' : '' }}
                            >
                                {{ $curso->nombre }}
                            </option>
                        @endforeach
                    </select>

                    @error('curso_id')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="materia_id" class="block text-sm font-medium text-slate-700 mb-2">
                        Materia
                    </label>

                    <select
                        name="materia_id"
                        id="materia_id"
                        class="w-full rounded-lg border px-3 py-2
                        @class([
                            'border-red-500' => $errors->has('materia_id'),
                            'border-slate-300' => !$errors->has('materia_id'),
                        ])"
                    >
                        <option value="">Seleccione una materia</option>

                        @foreach($materias as $materia)
                            <option
                                value="{{ $materia->id }}"
                                {{ old('materia_id') == $materia->id ? 'selected' : '' }}
                            >
                                {{ $materia->nombre }}
                            </option>
                        @endforeach
                    </select>

                    @error('materia_id')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            <div class="mt-6">
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg transition"
                >
                    Guardar asignación
                </button>
            </div>

        </form>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="px-6 py-4 border-b border-slate-200">
            <h2 class="text-lg font-semibold text-slate-800">
                Asignaciones registradas
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">

                <thead class="bg-slate-100 text-slate-700 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">Docente</th>
                        <th class="px-6 py-3">Curso</th>
                        <th class="px-6 py-3">Materia</th>
                        <th class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200">

                    @forelse($asignaciones as $asignacion)

                        <tr class="hover:bg-slate-50">

                            <td class="px-6 py-4">
                                {{ $asignacion->docente?->nombre ?? 'Docente no encontrado' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $asignacion->curso?->nombre ?? 'Curso no encontrado' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $asignacion->materia?->nombre ?? 'Materia no encontrada' }}
                            </td>

                            <td class="px-6 py-4 text-center">

                                <form
                                    action="{{ route('asignaciones.destroy', $asignacion->id) }}"
                                    method="POST"
                                    class="inline"
                                    onsubmit="return confirm('¿Está seguro de eliminar esta asignación?');"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg transition"
                                    >
                                        Eliminar
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                                No existen asignaciones registradas.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection