@extends('layouts.app')

@section('contenido')

<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-2xl shadow-lg p-8">

        <h1 class="text-3xl font-bold text-green-700 mb-8">
            ✏️ Editar Grupo de Feria
        </h1>

        <form action="{{ route('grupos.update', $grupo->id) }}" method="POST">

            @csrf
            @method('PUT')

            <!-- Nombre del Grupo -->
            <div class="mb-5">

                <label class="block font-semibold mb-2">
                    Nombre del Grupo
                </label>

                <input type="text"
                       name="nombre_grupo"
                       value="{{ old('nombre_grupo', $grupo->nombre_grupo) }}"
                       class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-green-500"
                       required>

            </div>


            <!-- Tema -->
            <div class="mb-5">

                <label class="block font-semibold mb-2">
                    Tema del Proyecto
                </label>

                <input type="text"
                       name="tema"
                       value="{{ old('tema', $grupo->tema) }}"
                       class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-green-500"
                       required>

            </div>


            <!-- Materia -->
            <div class="mb-5">

                <label class="block font-semibold mb-2">
                    Materia
                </label>

                <select name="materia_id"
                        class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-green-500"
                        required>

                    <option value="">
                        Seleccionar Materia
                    </option>

                    @foreach($materias as $materia)
                        <option value="{{ $materia->id }}"
                                {{ old('materia_id', $grupo->materia_id) == $materia->id ? 'selected' : '' }}>
                            {{ $materia->nombre }}
                        </option>
                    @endforeach

                </select>

            </div>


            <!-- Tipo -->
            <div class="mb-5">

                <label class="block font-semibold mb-2">
                    Tipo de Grupo
                </label>

                <input type="text"
                       name="tipo"
                       value="{{ old('tipo', $grupo->tipo) }}"
                       class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-green-500"
                       required>

            </div>


            <!-- Descripción -->
            <div class="mb-5">

                <label class="block font-semibold mb-2">
                    Descripción
                </label>

                <textarea name="descripcion"
                          class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-green-500"
                          rows="4">{{ old('descripcion', $grupo->descripcion) }}</textarea>

            </div>


            <!-- Botones -->
            <div class="flex justify-between items-center mt-8">

                <a href="{{ route('grupos.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl shadow-md">
                    Cancelar
                </a>

                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl shadow-md">
                    Guardar Cambios
                </button>

            </div>

        </form>

    </div>

</div>

@endsection