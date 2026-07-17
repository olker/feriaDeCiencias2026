@extends('layouts.app')

@section('contenido')

<div class="max-w-7xl mx-auto px-4 py-6">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">
            Notas finales por curso
        </h1>

        <p class="mt-1 text-slate-600">
            Calificaciones obtenidas por los estudiantes en la Feria de Ciencias.
        </p>
    </div>

    {{-- Selector de curso --}}
    <div class="mb-8 rounded-xl bg-white p-6 shadow">

        <form
            action="{{ route('reportes.resumen') }}"
            method="GET"
        >
            <div class="grid grid-cols-1 gap-5 md:grid-cols-3">

                <div class="md:col-span-2">

                    <label
                        for="curso_id"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Seleccione un curso
                    </label>

                    <select
                        name="curso_id"
                        id="curso_id"
                        required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2"
                    >
                        <option value="">
                            Seleccione un curso
                        </option>

                        @foreach($cursos as $curso)

                            <option
                                value="{{ $curso->id }}"
                                {{ (int) $cursoId === (int) $curso->id ? 'selected' : '' }}
                            >
                                {{ $curso->nombre }}
                            </option>

                        @endforeach
                    </select>

                </div>

                <div class="flex items-end">

                    <button
                        type="submit"
                        class="w-full rounded-lg bg-blue-600 px-5 py-2 font-semibold text-white transition hover:bg-blue-700"
                    >
                        Ver notas
                    </button>

                </div>

            </div>

        </form>

    </div>

    @if($cursoId && $cursoSeleccionado)

        <div class="overflow-hidden rounded-xl bg-white shadow">

            {{-- Encabezado --}}
            <div class="border-b border-slate-200 bg-slate-50 px-6 py-5">

                <h2 class="text-xl font-bold text-slate-800">
                    {{ $cursoSeleccionado->nombre }}
                </h2>

                <p class="mt-1 text-sm text-slate-600">
                    La nota final corresponde al promedio obtenido en la Feria de Ciencias.
                </p>

            </div>

            {{-- Tabla --}}
            <div class="overflow-x-auto">

                <table class="w-full text-left text-sm">

                    <thead class="bg-slate-100 text-xs uppercase text-slate-700">

                        <tr>
                            <th class="px-5 py-3">
                                N.º
                            </th>

                            <th class="px-5 py-3">
                                Estudiante
                            </th>

                            <th class="px-5 py-3">
                                Grupo de feria
                            </th>

                            <th class="px-5 py-3">
                                Materia del proyecto
                            </th>

                            <th class="px-5 py-3 text-center">
                                Evaluadores
                            </th>

                            <th class="px-5 py-3 text-center">
                                Nota final
                            </th>
                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-200">

                        @forelse($alumnos as $alumno)

                            <tr class="hover:bg-slate-50">

                                <td class="px-5 py-4">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-5 py-4 font-medium text-slate-800">
                                    {{ $alumno->nombre }}
                                </td>

                                <td class="px-5 py-4">

                                    @if($alumno->grupo_feria)

                                        {{ $alumno->grupo_feria }}

                                    @else

                                        <span class="text-slate-400">
                                            No participa
                                        </span>

                                    @endif

                                </td>

                                <td class="px-5 py-4">

                                    @if($alumno->materia_feria)

                                        <span class="rounded-full bg-purple-100 px-3 py-1 text-xs font-semibold text-purple-700">
                                            {{ $alumno->materia_feria }}
                                        </span>

                                    @else

                                        <span class="text-slate-400">
                                            Sin materia
                                        </span>

                                    @endif

                                </td>

                                <td class="px-5 py-4 text-center">
                                    {{ $alumno->cantidad_evaluadores }}
                                </td>

                                <td class="px-5 py-4 text-center">

                                    @if($alumno->promedio_final !== null)

                                        <span class="inline-block rounded-full bg-green-100 px-4 py-1 font-bold text-green-700">
                                            {{ number_format(
                                                $alumno->promedio_final,
                                                2
                                            ) }}
                                            / 45
                                        </span>

                                    @elseif($alumno->grupo_feria)

                                        <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                            Pendiente
                                        </span>

                                    @else

                                        <span class="text-slate-400">
                                            Sin nota
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td
                                    colspan="6"
                                    class="px-6 py-10 text-center text-slate-500"
                                >
                                    No existen estudiantes registrados en este curso.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    @elseif($cursos->isEmpty())

        <div class="rounded-xl border border-yellow-200 bg-yellow-50 px-6 py-5 text-yellow-800">
            No tiene cursos asignados.
        </div>

    @else

        <div class="rounded-xl border border-blue-200 bg-blue-50 px-6 py-5 text-blue-800">
            Seleccione un curso para mostrar las calificaciones.
        </div>

    @endif

</div>

@endsection