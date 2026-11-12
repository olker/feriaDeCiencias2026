<!doctype html>
<html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Valorar trabajo - Feria de Artes</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="min-h-screen bg-slate-100 p-4 flex items-center justify-center">
<main class="w-full max-w-lg rounded-3xl bg-white p-7 shadow-xl">
    <div class="mb-5 text-center"><div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-violet-100 text-3xl">🎨</div>
    <p class="text-xs font-bold uppercase tracking-widest text-violet-600">Feria de Artes Plásticas</p>
    <h1 class="mt-2 text-2xl font-extrabold text-slate-900">Valora esta obra</h1></div>
    <div class="rounded-2xl bg-slate-50 p-5">
        <p class="text-xs font-semibold uppercase text-slate-500">Estudiante</p>
        <p class="mt-1 text-lg font-bold text-slate-900">{{ $trabajo->alumno->nombre ?? 'Alumno' }}</p>
        <p class="mt-3 text-xs font-semibold uppercase text-slate-500">Curso</p>
        <p class="mt-1 font-semibold text-slate-800">{{ $trabajo->curso }}</p>
        <p class="mt-3 text-xs font-semibold uppercase text-slate-500">Trabajo presentado</p>
        <p class="mt-1 text-lg font-bold text-violet-700">{{ $trabajo->titulo_trabajo }}</p>
    </div>
    @if(session('success'))
        <div class="mt-5 rounded-xl bg-green-50 p-4 text-center font-semibold text-green-700">{{ session('success') }}</div>
    @else
        <form method="POST" action="{{ route('invitado.calificar.store', $trabajo->qr_token) }}" class="mt-6">
            @csrf
            <label class="block text-center font-semibold text-slate-800">¿Cuánto te gustó este trabajo?</label>
            <div class="mt-4 flex justify-center gap-2" id="estrellas">
                @for($i=1;$i<=5;$i++)
                    <button type="button" data-value="{{ $i }}" class="estrella text-4xl text-slate-300 transition hover:scale-110" aria-label="{{ $i }} estrellas">★</button>
                @endfor
            </div>
            <input type="hidden" name="estrellas" id="valor" required>
            <p id="texto" class="mt-2 h-5 text-center text-sm text-slate-500">Selecciona de 1 a 5 estrellas</p>
            @error('estrellas')<p class="mt-2 text-center text-sm text-red-600">{{ $message }}</p>@enderror
            <button class="mt-5 w-full rounded-xl bg-violet-700 px-5 py-3 font-bold text-white hover:bg-violet-800">Enviar valoración</button>
        </form>
    @endif
    <p class="mt-6 text-center text-xs text-slate-400">Gracias por apoyar el talento de nuestros estudiantes.</p>
</main>
<script>
const botones=[...document.querySelectorAll('.estrella')], valor=document.getElementById('valor'), texto=document.getElementById('texto');
const nombres=['','No me gustó','Puede mejorar','Bueno','Muy bueno','Excelente'];
botones.forEach(b=>b.addEventListener('click',()=>{const n=Number(b.dataset.value);valor.value=n;botones.forEach(x=>x.classList.toggle('text-amber-400',Number(x.dataset.value)<=n));botones.forEach(x=>x.classList.toggle('text-slate-300',Number(x.dataset.value)>n));texto.textContent=nombres[n];}));
</script></body></html>
