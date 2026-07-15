@extends('layouts.app')
@section('contenido')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Lista de Cursos
            </h1>
            <p class="text-gray-500">
                Administración de cursos disponibles.
            </p>
        </div>

        <a href="{{ route('cursos.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">
            + Nuevo Curso
        </a>
    </div>
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-4 text-left">
                        Curso
                    </th>
                    <th class="p-4 text-left">
                        Nivel
                    </th>
                    <th class="p-4 text-center">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($cursos as $curso)

                <tr class="border-b hover:bg-gray-50">

                    <td class="p-4 font-medium">
                        {{ $curso->nombre }}
                    </td>

                    <td class="p-4">
                        {{ $curso->nivel }}
                    </td>
                    <td class="p-4">
                        <div class="flex justify-center gap-2">

                            <a href="{{ route('cursos.edit', $curso->id) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                                Editar
                            </a>
                            <form action="{{ route('cursos.destroy', $curso->id) }}"
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