<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Docente;
use App\Models\DocenteCurso;
use App\Models\Materia;
use Illuminate\Http\Request;

class AsignacionController extends Controller
{
    public function index()
    {
        $docentes = Docente::where('estado', 1)
            ->where('es_admin', 0)
            ->orderBy('nombre')
            ->get();
        $cursos = Curso::orderBy('id')->get();
        $materias = Materia::orderBy('nombre')->get();
        $asignaciones = DocenteCurso::with([
            'docente',
            'curso',
            'materia'
        ])
            ->orderBy('curso_id')
            ->orderBy('docente_id')
            ->get();

        return view('asignaciones.index', compact(
            'docentes',
            'cursos',
            'materias',
            'asignaciones'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'docente_id' => 'required|exists:docentes,id',
            'curso_id' => 'required|exists:cursos,id',
            'materia_id' => 'required|exists:materias,id',
        ], [
            'docente_id.required' => 'Debe seleccionar un docente.',
            'docente_id.exists' => 'El docente seleccionado no existe.',
            'curso_id.required' => 'Debe seleccionar un curso.',
            'curso_id.exists' => 'El curso seleccionado no existe.',
            'materia_id.required' => 'Debe seleccionar una materia.',
            'materia_id.exists' => 'La materia seleccionada no existe.',
        ]);

        $existe = DocenteCurso::where('docente_id', $request->docente_id)
            ->where('curso_id', $request->curso_id)
            ->where('materia_id', $request->materia_id)
            ->exists();

        if ($existe) {
            return redirect()
                ->route('asignaciones.index')
                ->withInput()
                ->with('error', 'Esta asignación ya se encuentra registrada.');
        }

        DocenteCurso::create([
            'docente_id' => $request->docente_id,
            'curso_id' => $request->curso_id,
            'materia_id' => $request->materia_id,
        ]);

        return redirect()
            ->route('asignaciones.index')
            ->with('success', 'Asignación registrada correctamente.');
    }

    public function destroy($id)
    {
        $asignacion = DocenteCurso::findOrFail($id);

        $asignacion->delete();

        return redirect()
            ->route('asignaciones.index')
            ->with('success', 'Asignación eliminada correctamente.');
    }
}