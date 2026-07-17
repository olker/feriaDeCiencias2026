@extends('layouts.app')
@section('contenido')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            Docentes
        </h1>
        <a href="{{ route('docentes.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl shadow-md">
            + Nuevo Docente
        </a>
    </div>
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">

        <table class="min-w-[800px] w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-4 text-left">Nombre</th>
                    <th class="p-4 text-left">Correo</th>
                    <th class="p-4 text-center">Administrador</th>
                    <th class="p-4 text-center">Estado</th>
                    <th class="p-4 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($docentes as $docente)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-4">
                        {{ $docente->nombre }}
                    </td>
                    <td class="p-4">
                        {{ $docente->email }}
                    </td>
                    <td class="text-center">
                        @if($docente->es_admin)
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
                                Sí
                            </span>
                        @else
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full">
                                No
                            </span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($docente->estado)
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
                                Activo
                            </span>
                        @else
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">
                                Inactivo
                            </span>
                        @endif
                    </td>
                    <td class="text-center space-x-2">
                        <a href="{{ route('docentes.edit',$docente->id) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                            Editar
                        </a>
                        <form action="{{ route('docentes.destroy',$docente->id) }}"
                              method="POST"
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection