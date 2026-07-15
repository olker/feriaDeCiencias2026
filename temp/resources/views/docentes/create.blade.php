@extends('layouts.app')

@section('contenido')

<div class="max-w-3xl mx-auto">

    <div class="bg-white shadow-xl rounded-2xl p-8">

        <h1 class="text-3xl font-bold text-blue-700 mb-8">
            Nuevo Docente
        </h1>

        <form action="{{ route('docentes.store') }}" method="POST">

            @csrf

            <div class="mb-5">

                <label class="block font-semibold mb-2">
                    Nombre
                </label>

                <input type="text"
                       name="nombre"
                       class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-blue-500">

            </div>


            <div class="mb-5">

                <label class="block font-semibold mb-2">
                    Correo electrónico
                </label>

                <input type="email"
                       name="email"
                       class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-blue-500">

            </div>


            <div class="mb-5">

                <label class="block font-semibold mb-2">
                    Contraseña
                </label>

                <input type="password"
                       name="password"
                       class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-blue-500">

            </div>


            <div class="mb-5">

                <label class="block font-semibold mb-2">
                    Administrador
                </label>

                <select name="es_admin"
                        class="w-full border rounded-xl p-3">

                    <option value="0">
                        No
                    </option>

                    <option value="1">
                        Sí
                    </option>

                </select>

            </div>


            <div class="mb-8">

                <label class="block font-semibold mb-2">
                    Estado
                </label>

                <select name="estado"
                        class="w-full border rounded-xl p-3">

                    <option value="1">
                        Activo
                    </option>

                    <option value="0">
                        Inactivo
                    </option>

                </select>

            </div>


            <div class="flex gap-4">

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl shadow-md">

                    Guardar

                </button>


                <a href="{{ route('docentes.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl shadow-md">

                    Cancelar

                </a>

            </div>

        </form>

    </div>

</div>

@endsection