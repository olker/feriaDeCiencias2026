@extends('layouts.app')

@section('contenido')

<div class="max-w-3xl mx-auto">

    <div class="bg-white shadow-xl rounded-2xl p-8">

        <h1 class="text-3xl font-bold text-yellow-600 mb-8">
            Editar Alumno
        </h1>

        <form action="{{ route('alumnos.update', $alumno->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block font-semibold mb-2">
                    Nombre completo
                </label>

                <input type="text"
                       name="nombre"
                       value="{{ old('nombre', $alumno->nombre) }}"
                       class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-yellow-500">
            </div>

            <div class="mb-8">
                <label class="block font-semibold mb-2">
                    Curso
                </label>

                <select name="curso_id"
                        class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-yellow-500">

                    <option value="">
                        Seleccione un curso
                    </option>

                    @foreach($cursos as $curso)
                        <option value="{{ $curso->id }}"
                            {{ old('curso_id', $alumno->curso_id) == $curso->id ? 'selected' : '' }}>
                            {{ $curso->nombre }} - {{ $curso->nivel }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="flex gap-4">

                <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-xl shadow-md">
                    Actualizar
                </button>

                <a href="{{ route('alumnos.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl shadow-md">
                    Cancelar
                </a>

            </div>

        </form>

    </div>

</div>

@endsection