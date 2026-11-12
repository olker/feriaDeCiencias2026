<!doctype html>
<html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Etiquetas QR - Feria de Artes</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<style>
*{box-sizing:border-box}body{font-family:Arial,sans-serif;margin:0;background:#eef2f7;color:#172033}.toolbar{padding:16px;background:#fff;display:flex;gap:10px;justify-content:center;position:sticky;top:0;z-index:5;box-shadow:0 2px 8px #0001}.btn{border:0;border-radius:8px;padding:11px 18px;font-weight:bold;cursor:pointer;background:#4f46e5;color:white}.btn.secondary{background:#334155}.sheet{max-width:900px;margin:22px auto;background:white;padding:16mm;display:grid;grid-template-columns:repeat(2,1fr);gap:8mm}.label{border:1px dashed #94a3b8;border-radius:8px;min-height:65mm;padding:7mm;display:flex;align-items:center;gap:7mm;break-inside:avoid}.qr{width:34mm;height:34mm;flex:0 0 34mm}.qr img,.qr canvas{width:100%!important;height:100%!important}.info{min-width:0}.school{font-size:9pt;color:#64748b;font-weight:bold;text-transform:uppercase}.student{font-size:12pt;font-weight:bold;margin:5px 0}.work{font-size:11pt;margin:0 0 5px;overflow-wrap:anywhere}.course{font-size:9pt;color:#475569}.hint{font-size:8pt;color:#64748b;margin-top:6px}@media print{body{background:white}.toolbar{display:none}.sheet{margin:0;max-width:none;padding:8mm;box-shadow:none;gap:6mm}.label{border:1px dashed #777;min-height:61mm;page-break-inside:avoid}}
</style></head><body>
<div class="toolbar">
<button class="btn" onclick="descargarPDF()">Descargar PDF</button>
<button class="btn secondary" onclick="window.print()">Imprimir etiquetas</button>
<button class="btn secondary" onclick="window.close()">Cerrar</button>
</div>
<div class="sheet" id="etiquetas">
@foreach($trabajos as $trabajo)
<div class="label">
    <div class="qr" data-url="{{ route('invitado.calificar', $trabajo->qr_token) }}"></div>
    <div class="info">
        <div class="school">Feria de Artes Plásticas</div>
        <div class="student">{{ $trabajo->alumno->nombre ?? 'Alumno' }}</div>
        <p class="work">{{ $trabajo->titulo_trabajo }}</p>
        <div class="course">{{ $trabajo->curso }}</div>
        <div class="hint">Escanea el QR para valorar esta obra</div>
    </div>
</div>
@endforeach
</div>
<script>
document.querySelectorAll('.qr').forEach(el => new QRCode(el,{text:el.dataset.url,width:220,height:220,correctLevel:QRCode.CorrectLevel.M}));
async function descargarPDF(){
 const {jsPDF}=window.jspdf; const pdf=new jsPDF({orientation:'portrait',unit:'mm',format:'a4'});
 const labels=[...document.querySelectorAll('.label')];
 const marginX=10, marginY=10, gapX=6, gapY=6, w=(210-2*marginX-gapX)/2, h=62;
 for(let i=0;i<labels.length;i++){
   const col=i%2,row=Math.floor(i/2)%4;
   if(i>0 && i%8===0) pdf.addPage();
   const x=marginX+col*(w+gapX), y=marginY+row*(h+gapY);
   const el=labels[i], qr=el.querySelector('.qr canvas') || el.querySelector('.qr img');
   pdf.setDrawColor(150);pdf.setLineDashPattern([1,1],0);pdf.roundedRect(x,y,w,h,2,2);
   if(qr){const data=qr.tagName==='CANVAS'?qr.toDataURL('image/png'):qr.src;pdf.addImage(data,'PNG',x+5,y+13,35,35);}
   const txt=el.querySelector('.info');
   pdf.setFont('helvetica','bold');pdf.setFontSize(8);pdf.setTextColor(90);pdf.text('FERIA DE ARTES PLÁSTICAS',x+44,y+13);
   pdf.setTextColor(20);pdf.setFontSize(11);pdf.text(pdf.splitTextToSize(el.querySelector('.student').innerText,w-49),x+44,y+21);
   pdf.setFont('helvetica','normal');pdf.setFontSize(10);
   const title=pdf.splitTextToSize(el.querySelector('.work').innerText,w-49);
   pdf.text(title,x+44,y+32);
   pdf.setFontSize(8);pdf.setTextColor(80);pdf.text(el.querySelector('.course').innerText,x+44,y+49);
   pdf.text('Escanea para valorar esta obra',x+44,y+55);
 }
 pdf.save('etiquetas-QR-feria-artes.pdf');
}
</script></body></html>
