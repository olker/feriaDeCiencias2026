@extends('layouts.app')

@section('contenido')

<div class="max-w-3xl mx-auto">

    <div class="bg-white shadow-xl rounded-2xl p-8">

        <h1 class="text-3xl font-bold text-yellow-600 mb-8">
            Editar Docente
        </h1>

        <form action="{{ route('docentes.update', $docente->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block font-semibold mb-2">
                    Nombre
                </label>

                <input type="text"
                       name="nombre"
                       value="{{ old('nombre', $docente->nombre) }}"
                       class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-yellow-500">
            </div>

            <div class="mb-5">
                <label class="block font-semibold mb-2">
                    Correo electrónico
                </label>

                <input type="email"
                       name="email"
                       value="{{ old('email', $docente->email) }}"
                       class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-yellow-500">
            </div>

            <div class="mb-5">

                <label class="block font-semibold mb-2">
                    Nueva Contraseña
                </label>

                <input type="password"
                    name="password"
                    class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-yellow-500">

                <p class="text-gray-500 text-sm mt-1">
                    Dejar vacío si no desea cambiar la contraseña.
                </p>

            </div>

            <div class="mb-5">
                <label class="block font-semibold mb-2">
                    Administrador
                </label>

                <select name="es_admin"
                        class="w-full border rounded-xl p-3">
                    <option value="0" {{ $docente->es_admin == 0 ? 'selected' : '' }}>
                        No
                    </option>

                    <option value="1" {{ $docente->es_admin == 1 ? 'selected' : '' }}>
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
                    <option value="1" {{ $docente->estado == 1 ? 'selected' : '' }}>
                        Activo
                    </option>

                    <option value="0" {{ $docente->estado == 0 ? 'selected' : '' }}>
                        Inactivo
                    </option>
                </select>
            </div>

            <div class="flex gap-4">

                <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-xl shadow-md">
                    Actualizar
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