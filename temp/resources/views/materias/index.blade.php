@extends('layouts.app')
@section('contenido')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Lista de Materias
            </h1>
            <p class="text-gray-500">
                Administración de materias registradas.
            </p>
        </div>
        <a href="{{ route('materias.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">
            + Nueva Materia
        </a>
    </div>
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-4 text-left">
                        Nombre de la Materia
                    </th>
                    <th class="p-4 text-center">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($materias as $materia)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-4 font-medium">
                        {{ $materia->nombre }}
                    </td>
                    <td class="p-4">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('materias.edit', $materia->id) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                                Editar
                            </a>
                            <form action="{{ route('materias.destroy', $materia->id) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg"
                                    onclick="return confirm('¿Desea eliminar esta materia?')">
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