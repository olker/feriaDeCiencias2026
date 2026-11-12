<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrabajoArte;
use App\Models\CalificacionInvitado;

class InvitadoArteController extends Controller
{
    public function index()
    {
        return view('invitado.escaner');
    }

    // Muestra la vista de calificación para el trabajo del QR
    public function show($token)
    {
        // Buscamos el trabajo por su token único del QR (incluyendo los datos del alumno)
        $trabajo = TrabajoArte::where('qr_token', $token)->with('alumno')->firstOrFail();

        return view('invitado.calificar', compact('trabajo'));
    }

    // Guarda la calificación de estrellas enviada por el invitado
    public function store(Request $request, $token)
    {
        $request->validate([
            'estrellas' => 'required|integer|min:1|max:5',
        ]);

        $trabajo = TrabajoArte::where('qr_token', $token)->firstOrFail();

        // Guardamos la calificación
        CalificacionInvitado::create([
            'trabajo_arte_id' => $trabajo->id,
            'estrellas' => $request->estrellas,
            'ip_invitado' => $request->ip(),
        ]);

        return redirect()->route('invitado.calificar', $token)->with('success', '¡Gracias por calificar este trabajo de artes plásticas!');
    }
}