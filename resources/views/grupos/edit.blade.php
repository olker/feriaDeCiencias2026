@extends('layouts.app')

@section('contenido')

<div class="mx-auto max-w-4xl px-2 sm:px-4">

    <div class="rounded-2xl bg-white p-5 shadow-lg sm:p-8">

        <h1 class="mb-8 text-2xl font-bold text-green-700 sm:text-3xl">
            ✏️ Editar grupo de feria
        </h1>

        {{-- Mensaje general de error --}}
        @if(session('error'))
            <div class="mb-6 rounded-xl border border-red-300 bg-red-100 px-4 py-3 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        {{-- Resumen de errores de validación --}}
        @if($errors->any())
            <div class="mb-6 rounded-xl border border-red-300 bg-red-100 px-4 py-3 text-red-700">

                <p class="mb-2 font-bold">
                    No se pudo guardar el grupo:
                </p>

                <ul class="list-inside list-disc space-y-1 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif

        <form
            action="{{ route('grupos.update', $grupo->id) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            {{-- Nombre del grupo --}}
            <div class="mb-5">

                <label
                    for="nombre_grupo"
                    class="mb-2 block font-semibold"
                >
                    Nombre del grupo
                </label>

                <input
                    type="text"
                    name="nombre_grupo"
                    id="nombre_grupo"
                    value="{{ old('nombre_grupo', $grupo->nombre_grupo) }}"
                    maxlength="100"
                    required
                    class="w-full rounded-xl border p-3 focus:ring-2 focus:ring-green-500
                    {{ $errors->has('nombre_grupo') ? 'border-red-500' : 'border-slate-300' }}"
                >

                @error('nombre_grupo')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Tema --}}
            <div class="mb-5">

                <label
                    for="tema"
                    class="mb-2 block font-semibold"
                >
                    Tema del proyecto
                </label>

                <input
                    type="text"
                    name="tema"
                    id="tema"
                    value="{{ old('tema', $grupo->tema) }}"
                    maxlength="200"
                    required
                    class="w-full rounded-xl border p-3 focus:ring-2 focus:ring-green-500
                    {{ $errors->has('tema') ? 'border-red-500' : 'border-slate-300' }}"
                >

                @error('tema')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                {{-- Curso --}}
                <div>

                    <label
                        for="curso_id"
                        class="mb-2 block font-semibold"
                    >
                        Curso
                    </label>

                    <select
                        name="curso_id"
                        id="curso_id"
                        required
                        class="w-full rounded-xl border p-3 focus:ring-2 focus:ring-green-500
                        {{ $errors->has('curso_id') ? 'border-red-500' : 'border-slate-300' }}"
                    >
                        <option value="">
                            Seleccionar curso
                        </option>

                        @foreach($cursos as $curso)
                            <option
                                value="{{ $curso->id }}"
                                {{ (int) old('curso_id', $grupo->curso_id) === (int) $curso->id ? 'selected' : '' }}
                            >
                                {{ $curso->nombre }}
                            </option>
                        @endforeach
                    </select>

                    @error('curso_id')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Materia --}}
                <div>

                    <label
                        for="materia_id"
                        class="mb-2 block font-semibold"
                    >
                        Materia
                    </label>

                    <select
                        name="materia_id"
                        id="materia_id"
                        required
                        class="w-full rounded-xl border p-3 focus:ring-2 focus:ring-green-500
                        {{ $errors->has('materia_id') ? 'border-red-500' : 'border-slate-300' }}"
                    >
                        <option value="">
                            Seleccionar materia
                        </option>

                        @foreach($materias as $materia)
                            <option
                                value="{{ $materia->id }}"
                                {{ (int) old('materia_id', $grupo->materia_id) === (int) $materia->id ? 'selected' : '' }}
                            >
                                {{ $materia->nombre }}
                            </option>
                        @endforeach
                    </select>

                    @error('materia_id')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

            {{-- Tipo --}}
            <div class="mb-5 mt-5">

                <label
                    for="tipo"
                    class="mb-2 block font-semibold"
                >
                    Tipo de grupo
                </label>

                <select
                    name="tipo"
                    id="tipo"
                    required
                    class="w-full rounded-xl border p-3 focus:ring-2 focus:ring-green-500
                    {{ $errors->has('tipo') ? 'border-red-500' : 'border-slate-300' }}"
                >
                    <option value="">
                        Seleccionar tipo
                    </option>

                    <option
                        value="Individual"
                        {{ old('tipo', $grupo->tipo) === 'Individual' ? 'selected' : '' }}
                    >
                        Individual
                    </option>

                    <option
                        value="Grupal"
                        {{ old('tipo', $grupo->tipo) === 'Grupal' ? 'selected' : '' }}
                    >
                        Grupal
                    </option>
                </select>

                @error('tipo')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Descripción --}}
            <div class="mb-5">

                <label
                    for="descripcion"
                    class="mb-2 block font-semibold"
                >
                    Descripción
                </label>

                <textarea
                    name="descripcion"
                    id="descripcion"
                    rows="4"
                    maxlength="1000"
                    class="w-full rounded-xl border p-3 focus:ring-2 focus:ring-green-500
                    {{ $errors->has('descripcion') ? 'border-red-500' : 'border-slate-300' }}"
                >{{ old('descripcion', $grupo->descripcion) }}</textarea>

                @error('descripcion')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Advertencia por cambio de curso --}}
            @if($grupo->alumnos->isNotEmpty())
                <div class="mb-6 rounded-xl border border-yellow-300 bg-yellow-50 px-4 py-3 text-sm text-yellow-800">
                    ⚠️ Este grupo ya tiene integrantes. Si cambia el curso, los integrantes actuales serán retirados del grupo.
                </div>
            @endif

            {{-- Botones --}}
            <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-between">

                <a
                    href="{{ route('grupos.index') }}"
                    class="rounded-xl bg-gray-500 px-6 py-3 text-center text-white shadow-md hover:bg-gray-600"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="rounded-xl bg-green-600 px-6 py-3 text-white shadow-md hover:bg-green-700"
                >
                    Guardar cambios
                </button>

            </div>

        </form>

    </div>

</div>

@endsection