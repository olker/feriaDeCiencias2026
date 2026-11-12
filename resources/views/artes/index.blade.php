@extends('layouts.app')
@section('contenido')
<div class="mx-auto max-w-7xl space-y-6">
    <div class="flex flex-col gap-4 rounded-2xl bg-gradient-to-r from-violet-700 to-indigo-700 p-6 text-white shadow-lg sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wider text-violet-200">Feria de artes plásticas</p>
            <h1 class="mt-1 text-2xl font-bold sm:text-3xl">Trabajos y códigos QR</h1>
            <p class="mt-2 text-sm text-violet-100">Registra varios trabajos por alumno y genera etiquetas QR para cada obra.</p>
        </div>
        <a href="{{ route('artes.create') }}" class="rounded-xl bg-white px-5 py-3 text-center font-bold text-violet-700 shadow hover:bg-violet-50">+ Registrar trabajos</a>
    </div>

    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-green-800">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">{{ $errors->first() }}</div>
    @endif

    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <form method="GET" class="flex flex-col gap-3 sm:flex-row sm:items-end">
            <div class="flex-1">
                <label class="mb-1 block text-sm font-semibold text-slate-700">Filtrar por curso</label>
                <select name="curso" class="w-full rounded-lg border-slate-300" onchange="this.form.submit()">
                    <option value="">Todos mis cursos registrados</option>
                    @foreach($cursos as $curso)
                        <option value="{{ $curso->nombre }}" @selected(request('curso') == $curso->nombre)>{{ $curso->nombre }}</option>
                    @endforeach
                </select>
            </div>
            @if(request('curso'))
                <a href="{{ route('artes.imprimir', ['curso' => request('curso')]) }}" target="_blank" class="rounded-lg bg-slate-900 px-5 py-2.5 text-center font-semibold text-white hover:bg-slate-700">Imprimir QRs del curso / PDF</a>
            @endif
        </form>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-4">
            <h2 class="font-bold text-slate-800">Trabajos registrados <span class="ml-1 rounded-full bg-violet-100 px-2 py-1 text-xs text-violet-700">{{ $trabajos->count() }}</span></h2>
        </div>
        @forelse($trabajos->groupBy(fn($t) => $t->curso.'|'.$t->alumno_id) as $grupo)
            @php($primero = $grupo->first())
            <div class="border-b border-slate-100 p-5 last:border-0">
                <div class="mb-3 flex flex-wrap items-center justify-between gap-2">
                    <div>
                        <p class="font-bold text-slate-900">{{ $primero->alumno->nombre ?? 'Alumno eliminado' }}</p>
                        <p class="text-sm text-slate-500">{{ $primero->curso }} · {{ $grupo->count() }} trabajo(s)</p>
                    </div>
                </div>
                <div class="grid gap-3 md:grid-cols-2 xl:grid-cols-3">
                    @foreach($grupo as $trabajo)
                        <div class="rounded-xl border border-slate-200 p-4">
                            <p class="font-semibold text-slate-800">{{ $trabajo->titulo_trabajo }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ $trabajo->calificaciones_count }} valoración(es) recibida(s)</p>
                            <div class="mt-3 flex items-center gap-2">
                                <a href="{{ route('invitado.calificar', $trabajo->qr_token) }}" target="_blank" class="text-sm font-semibold text-violet-700 hover:underline">Ver página QR</a>
                                <form method="POST" action="{{ route('artes.destroy', $trabajo->id) }}" onsubmit="return confirm('¿Eliminar este trabajo y sus valoraciones?')">
                                    @csrf @method('DELETE')
                                    <button class="text-sm font-semibold text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="p-10 text-center">
                <p class="text-lg font-semibold text-slate-700">Todavía no registraste trabajos</p>
                <p class="mt-1 text-sm text-slate-500">Selecciona un curso, un alumno y agrega todos sus trabajos.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
