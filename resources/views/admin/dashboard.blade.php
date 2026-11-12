@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Panel Principal
</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-gray-500">Docentes</h3>
        <p class="text-4xl font-bold text-blue-600">0</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-gray-500">Alumnos</h3>
        <p class="text-4xl font-bold text-green-600">0</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-gray-500">Cursos</h3>
        <p class="text-4xl font-bold text-orange-500">0</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-gray-500">Materias</h3>
        <p class="text-4xl font-bold text-red-500">0</p>
    </div>

</div>

@endsection