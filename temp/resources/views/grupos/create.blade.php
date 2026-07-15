@extends('layouts.app')

@section('contenido')

<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-2xl shadow-lg p-8">

        <h1 class="text-3xl font-bold text-green-700 mb-8">
            ➕ Nuevo Grupo de Feria
        </h1>

        <form action="{{ route('grupos.store') }}" method="POST">

            @csrf

            <!-- Nombre del Grupo -->
            <div class="mb-5">

                <label class="block font-semibold mb-2">
                    Nombre del Grupo
                </label>

                <input type="text"
                       name="nombre_grupo"
                       value="{{ old('nombre_grupo') }}"
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
                       value="{{ old('tema') }}"
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
                        Seleccione una materia
                    </option>

                    @foreach($materias as $materia)

                        <option value="{{ $materia->id }}">

                            {{ $materia->nombre }}

                        </option>

                    @endforeach

                </select>

            </div>


            <!-- Tipo -->
            <div class="mb-5">

                <label class="block font-semibold mb-2">
                    Tipo de Proyecto
                </label>

                <select name="tipo"
                        class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-green-500"
                        required>

                    <option value="">
                        Seleccione un tipo
                    </option>

                    <option value="Individual">
                        Individual
                    </option>
                      <option value="Grupal">
                        Grupal
                    </option>
                </select>

            </div>

            <!-- Descripción -->
            <div class="mb-8">

                <label class="block font-semibold mb-2">
                    Descripción
                </label>

                <textarea
                    name="descripcion"
                    rows="5"
                    class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-green-500">{{ old('descripcion') }}</textarea>

            </div>


            <div class="flex gap-4">

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl shadow-md">

                    Guardar Grupo

                </button>


                <a href="{{ route('grupos.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl shadow-lg">

                    Cancelar

                </a>

            </div>

        </form>

    </div>

</div>

@endsection