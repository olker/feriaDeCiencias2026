<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Grupo;
use App\Models\DocenteAsignacion;
use Illuminate\Http\Request;

class AsignacionEvaluadorController extends Controller
{
    public function index()
    {
        if (!auth()->user()->es_admin) {
            abort(403, 'Acceso no autorizado.');
        }

        $docentes = Docente::where('estado', 1)
            ->where('es_admin', 0)
            ->orderBy('nombre')
            ->get();

        $grupos = Grupo::with([
            'curso',
            'materia',
            'alumnos'
        ])
            ->orderBy('nombre_grupo')
            ->get();

        $asignaciones = DocenteAsignacion::with([
            'docente',
            'grupo.curso',
            'grupo.materia'
        ])
            ->orderBy('grupo_id')
            ->orderBy('docente_id')
            ->get();

        return view('evaluadores.index', compact(
            'docentes',
            'grupos',
            'asignaciones'
        ));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->es_admin) {
            abort(403, 'Acceso no autorizado.');
        }

        $request->validate([
            'docente_id' => 'required|exists:docentes,id',
            'grupo_id' => 'required|exists:grupos,id',
        ], [
            'docente_id.required' => 'Debe seleccionar un docente.',
            'docente_id.exists' => 'El docente seleccionado no existe.',
            'grupo_id.required' => 'Debe seleccionar un grupo.',
            'grupo_id.exists' => 'El grupo seleccionado no existe.',
        ]);

        $docente = Docente::findOrFail($request->docente_id);

        if (!$docente->estado) {
            return back()
                ->withInput()
                ->with('error', 'El docente seleccionado está inactivo.');
        }

        $existe = DocenteAsignacion::where(
                'docente_id',
                $request->docente_id
            )
            ->where('grupo_id', $request->grupo_id)
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Este docente ya está asignado a ese grupo.'
                );
        }

        DocenteAsignacion::create([
            'docente_id' => $request->docente_id,
            'grupo_id' => $request->grupo_id,
        ]);

        return redirect()
            ->route('evaluadores.index')
            ->with(
                'success',
                'Docente evaluador asignado correctamente.'
            );
    }

    public function destroy($id)
    {
        if (!auth()->user()->es_admin) {
            abort(403, 'Acceso no autorizado.');
        }

        $asignacion = DocenteAsignacion::findOrFail($id);

        $asignacion->delete();

        return redirect()
            ->route('evaluadores.index')
            ->with(
                'success',
                'Asignación eliminada correctamente.'
            );
    }
}