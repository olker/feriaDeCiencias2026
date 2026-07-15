@extends('layouts.app')

@section('contenido')

<div class="bg-white rounded-2xl shadow-lg p-8">

    <div class="flex justify-between items-center mb-8">

        <div>

            <h1 class="text-3xl font-bold text-blue-700">
                Grupos de Feria
            </h1>

            <p class="text-gray-600 mt-2">
                Administración de los grupos registrados.
            </p>

        </div>

        <a href="{{ route('grupos.create') }}"
           class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl shadow-lg">

            ➕ Nuevo Grupo

        </a>

    </div>


    @if(session('success'))

        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6">

            {{ session('success') }}

        </div>

    @endif


    <div class="overflow-x-auto">

        <table class="min-w-full bg-white">

            <thead class="bg-slate-100">

                <tr>

                    <th class="p-4 text-left">Grupo</th>
                    <th class="p-4 text-left">Tema</th>
                    <th class="p-4 text-left">Materia</th>
                    <th class="p-4 text-left">Tipo</th>
                    <th class="p-4 text-left">Docente</th>
                    <th class="p-4 text-left">Estado</th>
                    <th class="p-4 text-center">Acciones</th>

                </tr>

            </thead>

            <tbody>

                @forelse($grupos as $grupo)

                    <tr class="border-b hover:bg-slate-50">

                        <td class="p-4">

                            {{ $grupo->nombre_grupo }}

                        </td>

                        <td class="p-4">

                            {{ $grupo->tema }}

                        </td>

                        <td class="p-4">

                            {{ $grupo->materia->nombre ?? '-' }}

                        </td>

                        <td class="p-4">

                            {{ $grupo->tipo }}

                        </td>

                        <td class="p-4">

                            {{ $grupo->docente->nombre ?? '-' }}

                        </td>

                        <td class="p-4">

                            @if($grupo->estado == 'Pendiente')

                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">

                                    {{ $grupo->estado }}

                                </span>

                            @elseif($grupo->estado == 'Aprobado')

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

                                    {{ $grupo->estado }}

                                </span>

                            @else

                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">

                                    {{ $grupo->estado }}

                                </span>

                            @endif

                        </td>

                        <td class="p-4">
                        <div class="flex flex-col items-center gap-2">

                            <a
                                href="{{ route('grupos.integrantes', $grupo->id) }}"
                                class="w-32 rounded-lg bg-indigo-600 px-3 py-2 text-center text-white hover:bg-indigo-700"
                            >
                                Integrantes
                            </a>

                            <a
                                href="{{ route('grupos.edit', $grupo->id) }}"
                                class="w-32 rounded-lg bg-yellow-500 px-3 py-2 text-center text-white hover:bg-yellow-600"
                            >
                                Editar
                            </a>

                            <form
                                action="{{ route('grupos.destroy', $grupo->id) }}"
                                method="POST"
                                class="w-32"
                                onsubmit="return confirm('¿Está seguro de eliminar este grupo?');"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="w-full rounded-lg bg-red-600 px-3 py-2 text-white hover:bg-red-700"
                                >
                                    Eliminar
                                </button>
                            </form>

                        </div>
                    </td>

                        </tr>

                    @empty

                    <tr>

                        <td colspan="7"
                            class="text-center py-8 text-gray-500">

                            No existen grupos registrados.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection