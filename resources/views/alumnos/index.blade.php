@extends('layouts.app')

@section('contenido')

<div class="p-6">

    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Lista de Alumnos
            </h1>

            <p class="text-gray-500">
                Administración de estudiantes registrados.
            </p>
        </div>

        <a href="{{ route('alumnos.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">

            + Nuevo Alumno

        </a>

    </div>


    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        <table class="w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="p-4 text-left">
                        Nombre
                    </th>

                    <th class="p-4 text-left">
                        Curso
                    </th>

                    <th class="p-4 text-left">
                        Nivel
                    </th>

                    <th class="p-4 text-left">
                        Grado
                    </th>

                    <th class="p-4 text-center">
                        Acciones
                    </th>

                </tr>

            </thead>


            <tbody>

                @foreach($alumnos as $alumno)

                <tr class="border-b hover:bg-gray-50">

                    <td class="p-4 font-medium">
                        {{ $alumno->nombre }}
                    </td>

                    <td class="p-4">
                        {{ $alumno->curso->nombre }}
                    </td>

                    <td class="p-4">

                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">

                            {{ $alumno->curso->nivel }}

                        </span>

                    </td>

                    <td class="p-4">

                        {{ $alumno->curso->grado }}°

                    </td>

                    <td class="p-4">

                        <div class="flex justify-center gap-2">

                            <a href="{{ route('alumnos.edit', $alumno->id) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">

                                Editar

                            </a>


                            <form action="{{ route('alumnos.destroy', $alumno->id) }}"
                                  method="POST">

                                @csrf
                                @method('DELETE')

                                <button
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg"
                                    onclick="return confirm('¿Desea eliminar este alumno?')">

                                    Eliminar

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection