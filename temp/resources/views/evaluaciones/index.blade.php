@extends('layouts.app')

@section('contenido')

<div class="max-w-7xl mx-auto px-4 py-6">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">
            Evaluaciones asignadas
        </h1>

        <p class="mt-1 text-slate-600">
            Proyectos que debe evaluar.
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

    <div class="overflow-hidden rounded-xl bg-white shadow">

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="bg-slate-100 text-xs uppercase text-slate-700">
                    <tr>
                        <th class="px-6 py-3">
                            Grupo
                        </th>

                        <th class="px-6 py-3">
                            Curso
                        </th>

                        <th class="px-6 py-3">
                            Materia
                        </th>

                        <th class="px-6 py-3">
                            Tema
                        </th>

                        <th class="px-6 py-3">
                            Integrantes
                        </th>

                        <th class="px-6 py-3 text-center">
                            Estado
                        </th>

                        <th class="px-6 py-3 text-center">
                            Acción
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200">

                    @forelse($asignaciones as $asignacion)

                        @php
                            $grupo = $asignacion->grupo;

                            $yaEvaluado = $grupo
                                && in_array(
                                    $grupo->id,
                                    $gruposEvaluados
                                );
                        @endphp

                        <tr class="hover:bg-slate-50">

                            <td class="px-6 py-4 font-medium text-slate-800">
                                {{ $grupo?->nombre_grupo ?? 'Grupo no encontrado' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $grupo?->curso?->nombre ?? 'Sin curso' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $grupo?->materia?->nombre ?? 'Sin materia' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $grupo?->tema ?? 'Sin tema' }}
                            </td>

                            <td class="px-6 py-4">

                                @if($grupo && $grupo->alumnos->isNotEmpty())

                                    <div class="space-y-1">

                                        @foreach($grupo->alumnos as $alumno)
                                            <div>
                                                {{ $alumno->nombre }}
                                            </div>
                                        @endforeach

                                    </div>

                                @else

                                    <span class="text-slate-500">
                                        Sin integrantes
                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-4 text-center">

                                @if($yaEvaluado)

                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                        Evaluado
                                    </span>

                                @else

                                    <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                        Pendiente
                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-4 text-center">

                                @if(!$grupo)

                                    <span class="text-sm text-red-500">
                                        Grupo no disponible
                                    </span>

                                @elseif($grupo->alumnos->isEmpty())

                                    <span class="text-sm font-medium text-red-500">
                                        Sin integrantes
                                    </span>

                                @elseif($yaEvaluado)

                                    <span class="text-sm font-medium text-slate-500">
                                        No modificable
                                    </span>

                                @else

                                    <a
                                        href="{{ route('evaluaciones.create', $grupo->id) }}"
                                        class="inline-block rounded-lg bg-blue-600 px-4 py-2 font-semibold text-white transition hover:bg-blue-700"
                                    >
                                        Evaluar
                                    </a>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="7"
                                class="px-6 py-10 text-center text-slate-500"
                            >
                                No tiene proyectos asignados para evaluar.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection