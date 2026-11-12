<!doctype html>
<html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Escáner de QR - Feria</title><script src="https://cdn.tailwindcss.com"></script><script src="https://unpkg.com/html5-qrcode"></script></head>
<body class="min-h-screen bg-slate-100 p-4 flex items-center justify-center">
<main class="w-full max-w-md rounded-3xl bg-white p-7 shadow-xl text-center">
    <div class="text-4xl">📷</div><h1 class="mt-3 text-2xl font-extrabold text-slate-900">Escanear trabajo</h1>
    <p class="mt-2 text-sm text-slate-500">Apunta la cámara al código QR pegado en la obra para abrir su valoración.</p>
    <div id="reader" class="mt-6 overflow-hidden rounded-xl"></div>
    <p id="estado" class="mt-3 text-sm text-slate-500">Pulsa iniciar para activar la cámara.</p>
    <button id="iniciar" class="mt-4 w-full rounded-xl bg-violet-700 px-5 py-3 font-bold text-white">Iniciar cámara</button>
    <div class="mt-5 border-t pt-4 text-left"><label class="text-sm font-semibold">O introduce el enlace o token del QR</label>
    <input id="manual" class="mt-2 w-full rounded-lg border-slate-300" placeholder="Pega aquí el enlace del QR">
    <button id="abrir" class="mt-2 w-full rounded-lg bg-slate-800 px-4 py-2 font-semibold text-white">Abrir trabajo</button></div>
</main>
<script>
let scanner;
document.getElementById('iniciar').addEventListener('click',async()=>{
 const estado=document.getElementById('estado');
 try{
  scanner=new Html5Qrcode('reader');
  const cameras=await Html5Qrcode.getCameras();
  if(!cameras.length) throw new Error('No se encontró una cámara.');
  await scanner.start(cameras[0].id,{fps:10,qrbox:{width:230,height:230}},decoded=>{
    window.location.href=decoded;
  },()=>{});
  estado.textContent='Cámara activa. Enfoca un código QR.';
  document.getElementById('iniciar').disabled=true;
 }catch(e){estado.textContent='No se pudo iniciar la cámara: '+e+'. Verifica los permisos y que uses HTTPS o localhost.';}
});
document.getElementById('abrir').addEventListener('click',()=>{
 const v=document.getElementById('manual').value.trim();
 if(!v)return;
 if(/^https?:\/\//i.test(v)) window.location.href=v;
 else window.location.href=@json(url('/invitado/calificar'))+'/'+encodeURIComponent(v);
});
</script></body></html>
