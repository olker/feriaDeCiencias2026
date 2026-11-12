@extends('layouts.app')

@section('contenido')

<div class="max-w-3xl mx-auto">

    <div class="bg-white shadow-xl rounded-2xl p-8">

        <h1 class="text-3xl font-bold text-yellow-600 mb-8">
            Editar Curso
        </h1>

        <form action="{{ route('cursos.update', $curso->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="mb-5">

                <label class="block font-semibold mb-2">
                    Nombre del Curso
                </label>

                <input type="text"
                       name="nombre"
                       value="{{ old('nombre', $curso->nombre) }}"
                       class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-yellow-500">

            </div>


            <div class="mb-5">

                <label class="block font-semibold mb-2">
                    Nivel
                </label>

                <select name="nivel"
                        class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-yellow-500">

                    <option value="Primaria"
                        {{ $curso->nivel == 'Primaria' ? 'selected' : '' }}>
                        Primaria
                    </option>

                    <option value="Secundaria"
                        {{ $curso->nivel == 'Secundaria' ? 'selected' : '' }}>
                        Secundaria
                    </option>

                </select>

            </div>


            <div class="mb-8">

                <label class="block font-semibold mb-2">
                    Grado
                </label>

                <select name="grado"
                        class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-yellow-500">

                    @for($i = 1; $i <= 6; $i++)

                        <option value="{{ $i }}"
                            {{ $curso->grado == $i ? 'selected' : '' }}>

                            {{ $i }}°

                        </option>

                    @endfor

                </select>

            </div>


            <div class="flex gap-4">

                <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-xl shadow-md">

                    Actualizar

                </button>


                <a href="{{ route('cursos.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl shadow-md">

                    Cancelar

                </a>

            </div>

        </form>

    </div>

</div>

@endsection