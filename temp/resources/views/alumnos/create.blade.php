@extends('layouts.app')

@section('contenido')

<div class="max-w-4xl mx-auto">

    <!-- Encabezado -->
    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Nuevo Alumno
            </h1>

            <p class="text-gray-500 mt-1">
                Registrar un nuevo estudiante en el sistema.
            </p>
        </div>

        <a href="{{ route('alumnos.index') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded-lg shadow">
            Volver
        </a>

    </div>

    <!-- Tarjeta -->
    <div class="bg-white rounded-2xl shadow-lg p-8">

        <form action="{{ route('alumnos.store') }}" method="POST">

            @csrf

            <div class="grid grid-cols-1 gap-6">

                <!-- Nombre -->
                <div>

                    <label class="block text-gray-700 font-semibold mb-2">
                        Nombre del Alumno
                    </label>

                    <input
                        type="text"
                        name="nombre"
                        value="{{ old('nombre') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="Ingrese el nombre completo">

                    @error('nombre')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <!-- Curso -->
                <div>

                    <label class="block text-gray-700 font-semibold mb-2">
                        Curso
                    </label>

                    <select
                        name="id_curso"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500">

                        <option value="">
                            Seleccione un curso
                        </option>

                        @foreach($cursos as $curso)

                            <option value="{{ $curso->id }}">

                                {{ $curso->nombre }}

                            </option>

                        @endforeach

                    </select>

                    @error('id_curso')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

            <!-- Botones -->
            <div class="mt-8 flex gap-4">

                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg shadow-md font-semibold">

                    Guardar Alumno

                </button>

                <a href="{{ route('alumnos.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-8 py-3 rounded-lg shadow-md">

                    Cancelar

                </a>

            </div>

        </form>

    </div>

</div>

@endsection