@extends('layouts.app')

@section('contenido')

<div class="max-w-5xl mx-auto px-4 py-6">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">
            Registrar nuevo grupo
        </h1>

        <p class="mt-1 text-slate-600">
            Complete los datos del proyecto para registrarlo en la Feria de Ciencias.
        </p>
    </div>

    @if(session('error'))
        <div class="mb-5 rounded-lg border border-red-300 bg-red-100 px-4 py-3 text-red-800">
            {{ session('error') }}
        </div>
    @endif

    <div class="rounded-xl bg-white p-6 shadow">

        <form
            action="{{ route('grupos.store') }}"
            method="POST"
        >
            @csrf

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Nombre del grupo --}}
                <div>
                    <label
                        for="nombre_grupo"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Nombre del grupo
                    </label>

                    <input
                        type="text"
                        name="nombre_grupo"
                        id="nombre_grupo"
                        value="{{ old('nombre_grupo') }}"
                        placeholder="Ejemplo: Semáforo inteligente"
                        class="w-full rounded-lg border px-3 py-2 {{ $errors->has('nombre_grupo') ? 'border-red-500' : 'border-slate-300' }}"
                    >

                    @error('nombre_grupo')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Tema --}}
                <div>
                    <label
                        for="tema"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Tema del proyecto
                    </label>

                    <input
                        type="text"
                        name="tema"
                        id="tema"
                        value="{{ old('tema') }}"
                        placeholder="Ejemplo: Control inteligente del tráfico"
                        class="w-full rounded-lg border px-3 py-2 {{ $errors->has('tema') ? 'border-red-500' : 'border-slate-300' }}"
                    >

                    @error('tema')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Materia --}}
                <div>
                    <label
                        for="materia_id"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Materia
                    </label>

                    <select
                        name="materia_id"
                        id="materia_id"
                        class="w-full rounded-lg border px-3 py-2 {{ $errors->has('materia_id') ? 'border-red-500' : 'border-slate-300' }}"
                    >
                        <option value="">
                            Seleccione una materia
                        </option>

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
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Curso --}}
                <div>
                    <label
                        for="curso_id"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Curso
                    </label>

                    <select
                        name="curso_id"
                        id="curso_id"
                        class="w-full rounded-lg border px-3 py-2 {{ $errors->has('curso_id') ? 'border-red-500' : 'border-slate-300' }}"
                    >
                        <option value="">
                            Seleccione un curso
                        </option>

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
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Tipo --}}
                <div>
                    <label
                        for="tipo"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Tipo de exposición
                    </label>

                    <select
                        name="tipo"
                        id="tipo"
                        class="w-full rounded-lg border px-3 py-2 {{ $errors->has('tipo') ? 'border-red-500' : 'border-slate-300' }}"
                    >
                        <option value="">
                            Seleccione el tipo
                        </option>

                        <option
                            value="Individual"
                            {{ old('tipo') === 'Individual' ? 'selected' : '' }}
                        >
                            Individual
                        </option>

                        <option
                            value="Grupal"
                            {{ old('tipo') === 'Grupal' ? 'selected' : '' }}
                        >
                            Grupal
                        </option>
                    </select>

                    @error('tipo')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div class="md:col-span-2">
                    <label
                        for="descripcion"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Descripción del proyecto
                    </label>

                    <textarea
                        name="descripcion"
                        id="descripcion"
                        rows="5"
                        placeholder="Describa brevemente el funcionamiento y objetivo del proyecto."
                        class="w-full rounded-lg border px-3 py-2 {{ $errors->has('descripcion') ? 'border-red-500' : 'border-slate-300' }}"
                    >{{ old('descripcion') }}</textarea>

                    @error('descripcion')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row">

                <button
                    type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-2 font-semibold text-white transition hover:bg-blue-700"
                >
                    Guardar grupo
                </button>

                <a
                    href="{{ route('grupos.index') }}"
                    class="rounded-lg bg-slate-500 px-5 py-2 text-center font-semibold text-white transition hover:bg-slate-600"
                >
                    Cancelar
                </a>

            </div>

        </form>

    </div>

</div>

@endsection