@extends('layouts.app')

@section('contenido')

<div class="max-w-7xl mx-auto px-4 py-6">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">
            Reporte de calificaciones
        </h1>

        <p class="mt-1 text-slate-600">
            Resultados obtenidos por los estudiantes en los proyectos de la Feria de Ciencias.
        </p>
    </div>

    @if(session('success'))
        <div class="mb-5 rounded-lg border border-green-300 bg-green-100 px-4 py-3 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-8">

        @forelse($grupos as $grupo)

            <div class="overflow-hidden rounded-xl bg-white shadow">

                {{-- Encabezado del grupo --}}
                <div class="border-b border-slate-200 bg-slate-50 px-6 py-5">

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">

                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">
                                Grupo
                            </p>

                            <p class="mt-1 font-bold text-slate-800">
                                {{ $grupo->nombre_grupo }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">
                                Curso
                            </p>

                            <p class="mt-1 text-slate-800">
                                {{ $grupo->curso?->nombre ?? 'Sin curso' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">
                                Materia
                            </p>

                            <p class="mt-1 text-slate-800">
                                {{ $grupo->materia?->nombre ?? 'Sin materia' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">
                                Tema
                            </p>

                            <p class="mt-1 text-slate-800">
                                {{ $grupo->tema ?? 'Sin tema' }}
                            </p>
                        </div>

                    </div>

                </div>

                {{-- Contenido --}}
                <div class="p-6">

                    @if($grupo->alumnos->isEmpty())

                        <div class="rounded-lg border border-yellow-200 bg-yellow-50 px-4 py-3 text-yellow-800">
                            Este grupo no tiene estudiantes asignados.
                        </div>

                    @elseif($grupo->calificaciones->isEmpty())

                        <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-slate-600">
                            Este grupo todavía no recibió ninguna evaluación.
                        </div>

                    @else

                        <div class="overflow-x-auto">

                            <table class="w-full text-left text-sm">

                                <thead class="bg-slate-100 text-xs uppercase text-slate-700">
                                    <tr>
                                        <th class="px-4 py-3">
                                            Estudiante
                                        </th>

                                        <th class="px-4 py-3 text-center">
                                            Evaluaciones
                                        </th>

                                        <th class="px-4 py-3 text-center">
                                            Promedio grupal
                                        </th>

                                        <th class="px-4 py-3 text-center">
                                            Promedio individual
                                        </th>

                                        <th class="px-4 py-3 text-center">
                                            Promedio final
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-slate-200">

                                    @foreach($grupo->alumnos as $alumno)

                                        @php
                                            $notasAlumno = $grupo
                                                ->calificaciones
                                                ->where('alumno_id', $alumno->id);

                                            $cantidadEvaluaciones =
                                                $notasAlumno->count();

                                            $promedioGrupal =
                                                $cantidadEvaluaciones > 0
                                                    ? $notasAlumno->avg('nota_grupal')
                                                    : null;

                                            $promedioIndividual =
                                                $cantidadEvaluaciones > 0
                                                    ? $notasAlumno->avg('nota_individual')
                                                    : null;

                                            $promedioFinal =
                                                $cantidadEvaluaciones > 0
                                                    ? $notasAlumno->avg('nota_final')
                                                    : null;
                                        @endphp

                                        <tr class="hover:bg-slate-50">

                                            <td class="px-4 py-4 font-medium text-slate-800">
                                                {{ $alumno->nombre }}
                                            </td>

                                            <td class="px-4 py-4 text-center">
                                                {{ $cantidadEvaluaciones }}
                                            </td>

                                            <td class="px-4 py-4 text-center">
                                                @if($promedioGrupal !== null)
                                                    {{ number_format($promedioGrupal, 2) }}
                                                    / 45
                                                @else
                                                    <span class="text-slate-400">
                                                        Sin nota
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="px-4 py-4 text-center">
                                                @if($promedioIndividual !== null)
                                                    {{ number_format($promedioIndividual, 2) }}
                                                    / 45
                                                @else
                                                    <span class="text-slate-400">
                                                        Sin nota
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="px-4 py-4 text-center">

                                                @if($promedioFinal !== null)

                                                    <span class="inline-block rounded-full bg-green-100 px-3 py-1 font-bold text-green-700">
                                                        {{ number_format($promedioFinal, 2) }}
                                                        / 45
                                                    </span>

                                                @else

                                                    <span class="text-slate-400">
                                                        Sin nota
                                                    </span>

                                                @endif

                                            </td>

                                        </tr>

                                        {{-- Detalle por evaluador --}}
                                        @if($notasAlumno->isNotEmpty())

                                            <tr class="bg-slate-50">

                                                <td colspan="5" class="px-6 py-4">

                                                    <p class="mb-3 text-xs font-bold uppercase text-slate-500">
                                                        Detalle de evaluaciones
                                                    </p>

                                                    <div class="overflow-x-auto">

                                                        <table class="w-full text-xs">

                                                            <thead>
                                                                <tr class="text-slate-500">
                                                                    <th class="py-2 text-left">
                                                                        Evaluador
                                                                    </th>

                                                                    <th class="py-2 text-center">
                                                                        Dominio
                                                                    </th>

                                                                    <th class="py-2 text-center">
                                                                        Material
                                                                    </th>

                                                                    <th class="py-2 text-center">
                                                                        Expresión
                                                                    </th>

                                                                    <th class="py-2 text-center">
                                                                        Grupal
                                                                    </th>

                                                                    <th class="py-2 text-center">
                                                                        Individual
                                                                    </th>

                                                                    <th class="py-2 text-center">
                                                                        Final
                                                                    </th>

                                                                    <th class="py-2 text-left">
                                                                        Observación
                                                                    </th>
                                                                </tr>
                                                            </thead>

                                                            <tbody class="divide-y divide-slate-200">

                                                                @foreach($notasAlumno as $nota)

                                                                    <tr>
                                                                        <td class="py-2 pr-3">
                                                                            {{ $nota->docente?->nombre ?? 'Docente no encontrado' }}
                                                                        </td>

                                                                        <td class="py-2 text-center">
                                                                            {{ $nota->dominio_tema }}
                                                                            /15
                                                                        </td>

                                                                        <td class="py-2 text-center">
                                                                            {{ $nota->material_apoyo }}
                                                                            /15
                                                                        </td>

                                                                        <td class="py-2 text-center">
                                                                            {{ $nota->expresion_defensa }}
                                                                            /15
                                                                        </td>

                                                                        <td class="py-2 text-center">
                                                                            {{ $nota->nota_grupal }}
                                                                            /45
                                                                        </td>

                                                                        <td class="py-2 text-center">
                                                                            {{ $nota->nota_individual }}
                                                                            /45
                                                                        </td>

                                                                        <td class="py-2 text-center font-bold text-green-700">
                                                                            {{ number_format($nota->nota_final, 2) }}
                                                                            /45
                                                                        </td>

                                                                        <td class="py-2 pl-3">
                                                                            {{ $nota->observacion ?: 'Sin observación' }}
                                                                        </td>
                                                                    </tr>

                                                                @endforeach

                                                            </tbody>

                                                        </table>

                                                    </div>

                                                </td>

                                            </tr>

                                        @endif

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @endif

                </div>

            </div>

        @empty

            <div class="rounded-xl bg-white p-10 text-center shadow">
                <p class="text-slate-500">
                    No tiene grupos registrados para mostrar en el reporte.
                </p>
            </div>

        @endforelse

    </div>

</div>

@endsection