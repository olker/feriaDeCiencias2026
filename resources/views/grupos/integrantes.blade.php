@extends('layouts.app')

@section('contenido')

<div class="max-w-6xl mx-auto px-4 py-6">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">
            Integrantes del grupo
        </h1>

        <p class="mt-1 text-slate-600">
            Seleccione los estudiantes que formarán parte del proyecto.
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

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

            <div>
                <p class="text-sm font-medium text-slate-500">
                    Nombre del grupo
                </p>

                <p class="text-lg font-semibold text-slate-800">
                    {{ $grupo->nombre_grupo }}
                </p>
            </div>

            <div>
                <p class="text-sm font-medium text-slate-500">
                    Tipo de exposición
                </p>

                <p class="text-lg font-semibold text-slate-800">
                    {{ $grupo->tipo }}
                </p>
            </div>

            <div>
                <p class="text-sm font-medium text-slate-500">
                    Tema
                </p>

                <p class="text-slate-800">
                    {{ $grupo->tema ?? 'Sin tema registrado' }}
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

        </div>

    </div>

    <div class="rounded-xl bg-white p-6 shadow">

        <form
            action="{{ route('grupos.integrantes.update', $grupo->id) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <div class="mb-5">

                <label class="mb-2 block text-sm font-medium text-slate-700">
                    Estudiantes disponibles
                </label>

                <p class="mb-4 text-sm text-slate-500">
                    @if($grupo->tipo === 'Individual')
                        Este proyecto debe tener exactamente un estudiante.
                    @else
                        Este proyecto puede tener varios estudiantes.
                    @endif
                </p>

                @error('alumnos')
                    <p class="mb-3 text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror

                @error('alumnos.*')
                    <p class="mb-3 text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror

                <div class="grid grid-cols-1 gap-3 md:grid-cols-2">

                    @forelse($alumnos as $alumno)

                        @php
                            $seleccionados = old(
                                'alumnos',
                                $grupo->alumnos->pluck('id')->toArray()
                            );
                        @endphp

                        <label
                            class="flex cursor-pointer items-center gap-3 rounded-lg border border-slate-200 p-4 transition hover:bg-slate-50"
                        >

                            <input
                                type="{{ $grupo->tipo === 'Individual' ? 'radio' : 'checkbox' }}"
                                name="alumnos[]"
                                value="{{ $alumno->id }}"
                                class="h-4 w-4"
                                {{ in_array($alumno->id, $seleccionados) ? 'checked' : '' }}
                            >

                            <div>
                                <p class="font-medium text-slate-800">
                                    {{ $alumno->nombre }}
                                </p>

                                <p class="text-sm text-slate-500">
                                    {{ $alumno->curso?->nombre ?? 'Sin curso' }}
                                </p>
                            </div>

                        </label>

                    @empty

                        <div class="col-span-full rounded-lg border border-yellow-200 bg-yellow-50 p-4 text-yellow-800">
                            No existen estudiantes disponibles para asignar.
                        </div>

                    @endforelse

                </div>

            </div>

            <div class="mt-6 flex flex-col gap-3 sm:flex-row">

                <button
                    type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-2 font-semibold text-white transition hover:bg-blue-700"
                >
                    Guardar integrantes
                </button>

                <a
                    href="{{ route('grupos.index') }}"
                    class="rounded-lg bg-slate-500 px-5 py-2 text-center font-semibold text-white transition hover:bg-slate-600"
                >
                    Volver
                </a>

            </div>

        </form>

    </div>

</div>

@endsection