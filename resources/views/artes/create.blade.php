@extends('layouts.app')
@section('contenido')
<div class="mx-auto max-w-3xl space-y-5">
    <a href="{{ route('artes.index') }}" class="text-sm font-semibold text-violet-700 hover:underline">← Volver a trabajos</a>
    <div class="rounded-2xl bg-white p-6 shadow-sm sm:p-8">
        <h1 class="text-2xl font-bold text-slate-900">Registrar trabajos de un alumno</h1>
        <p class="mt-1 text-sm text-slate-500">Ejemplo: 4to de secundaria → alumno → sus 3 trabajos. Se generará un QR diferente para cada trabajo.</p>
        @if($errors->any())
            <div class="mt-4 rounded-lg bg-red-50 p-3 text-sm text-red-700">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('artes.store') }}" class="mt-6 space-y-5" id="form-artes">
            @csrf
            <div>
                <label class="mb-1 block text-sm font-semibold">Curso / grado</label>
                <select name="curso_id" id="curso_id" required class="w-full rounded-lg border-slate-300">
                    <option value="">Seleccionar curso</option>
                    @foreach($cursos as $curso)
                        <option value="{{ $curso->id }}" @selected(old('curso_id') == $curso->id)>{{ $curso->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold">Alumno</label>
                <select name="alumno_id" id="alumno_id" required disabled class="w-full rounded-lg border-slate-300">
                    <option value="">Primero selecciona un curso</option>
                </select>
                <p id="cargando" class="mt-1 text-xs text-slate-500"></p>
            </div>
            <div>
                <div class="mb-2 flex items-center justify-between">
                    <label class="text-sm font-semibold">Títulos de los trabajos</label>
                    <button type="button" id="agregar" class="rounded-lg bg-violet-100 px-3 py-2 text-sm font-bold text-violet-800 hover:bg-violet-200">+ Agregar trabajo</button>
                </div>
                <div id="lista-trabajos" class="space-y-3">
                    @foreach(old('trabajos', ['']) as $i => $titulo)
                        <div class="fila-trabajo flex gap-2">
                            <input name="trabajos[]" required maxlength="180" value="{{ $titulo }}" placeholder="Ej. Pintura al óleo, dibujo, maqueta..." class="min-w-0 flex-1 rounded-lg border-slate-300">
                            <button type="button" class="quitar rounded-lg border border-red-200 px-3 text-red-600 hover:bg-red-50" title="Quitar">✕</button>
                        </div>
                    @endforeach
                </div>
                <p class="mt-2 text-xs text-slate-500">Cada trabajo tendrá su propio código QR para que el invitado lo escanee y valore esa obra.</p>
            </div>
            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                <a href="{{ route('artes.index') }}" class="rounded-lg border border-slate-300 px-5 py-3 text-center font-semibold text-slate-700">Cancelar</a>
                <button class="rounded-lg bg-violet-700 px-6 py-3 font-bold text-white hover:bg-violet-800">Guardar y generar QRs</button>
            </div>
        </form>
    </div>
</div>
<script>
const curso = document.getElementById('curso_id');
const alumno = document.getElementById('alumno_id');
const cargando = document.getElementById('cargando');
curso.addEventListener('change', async () => {
    alumno.innerHTML = '<option value="">Cargando alumnos...</option>';
    alumno.disabled = true;
    if (!curso.value) { alumno.innerHTML = '<option value="">Primero selecciona un curso</option>'; return; }
    cargando.textContent = 'Buscando alumnos del curso...';
    try {
        const response = await fetch(@json(url('/artes/alumnos')) + '/' + encodeURIComponent(curso.value), {headers:{'Accept':'application/json'}});
        if (!response.ok) throw new Error('No se pudo cargar la lista');
        const alumnos = await response.json();
        alumno.innerHTML = '<option value="">Seleccionar alumno</option>';
        alumnos.forEach(a => {
            const option = document.createElement('option');
            option.value = a.id; option.textContent = a.nombre;
            alumno.appendChild(option);
        });
        alumno.disabled = alumnos.length === 0;
        cargando.textContent = alumnos.length ? `${alumnos.length} alumno(s) encontrado(s)` : 'No hay alumnos registrados en este curso.';
    } catch(e) { alumno.innerHTML = '<option value="">Error al cargar alumnos</option>'; cargando.textContent = e.message; }
});
document.getElementById('agregar').addEventListener('click', () => {
    const fila = document.createElement('div');
    fila.className = 'fila-trabajo flex gap-2';
    fila.innerHTML = '<input name="trabajos[]" required maxlength="180" placeholder="Título del trabajo" class="min-w-0 flex-1 rounded-lg border-slate-300"><button type="button" class="quitar rounded-lg border border-red-200 px-3 text-red-600 hover:bg-red-50" title="Quitar">✕</button>';
    document.getElementById('lista-trabajos').appendChild(fila);
});
document.getElementById('lista-trabajos').addEventListener('click', e => {
    if (e.target.classList.contains('quitar')) {
        const filas = document.querySelectorAll('.fila-trabajo');
        if (filas.length > 1) e.target.closest('.fila-trabajo').remove();
    }
});
</script>
@endsection
