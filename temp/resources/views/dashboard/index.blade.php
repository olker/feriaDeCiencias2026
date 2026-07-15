@extends('layouts.app')

@section('contenido')

<div class="bg-white rounded-2xl shadow-lg p-8">

    @if(auth()->user()->es_admin)

        <h1 class="text-3xl font-bold text-blue-700">
            Bienvenido Administrador
        </h1>

        <p class="text-gray-600 mt-2">
            Desde aquí podrás administrar docentes, alumnos, cursos, materias, grupos y calificaciones.
        </p>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">

            <a href="{{ route('docentes.index') }}"
            class="bg-blue-500 text-white p-6 rounded-2xl shadow-lg hover:bg-blue-600 duration-300">
                <h2 class="text-xl font-bold">
                    Docentes
                </h2>
            </a>

            <a href="{{ route('alumnos.index') }}"
            class="bg-green-500 text-white p-6 rounded-2xl shadow-lg hover:bg-green-600 duration-300">
                <h2 class="text-xl font-bold">
                    Alumnos
                </h2>
            </a>

            <a href="{{ route('cursos.index') }}"
            class="bg-yellow-500 text-white p-6 rounded-2xl shadow-lg hover:bg-yellow-600 duration-300">
                <h2 class="text-xl font-bold">
                    Cursos
                </h2>
            </a>

            <a href="{{ route('materias.index') }}"
            class="bg-purple-500 text-white p-6 rounded-2xl shadow-lg hover:bg-purple-600 duration-300">
                <h2 class="text-xl font-bold">
                    Materias
                </h2>
            </a>

        </div>

    @else

        <h1 class="text-3xl font-bold text-green-700">
            Bienvenido Profesor
        </h1>

        <p class="text-gray-600 mt-2">
            Desde aquí podrás gestionar tus grupos y registrar las evaluaciones.
        </p>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">

            <a href="{{ route('grupos.index') }}"
            class="bg-indigo-500 text-white p-6 rounded-2xl shadow-lg hover:bg-indigo-600 duration-300">
                <h2 class="text-xl font-bold">
                    Mis Grupos
                </h2>
            </a>

            <a href="{{ route('evaluaciones.index') }}"
            class="bg-red-500 text-white p-6 rounded-2xl shadow-lg hover:bg-red-600 duration-300">
                <h2 class="text-xl font-bold">
                    Evaluaciones
                </h2>
            </a>

        </div>

    @endif

</div>

@endsection