<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\Materia;
use App\Models\Alumno;

class GrupoController extends Controller
{
    public function index()
    {
        if (auth()->user()->es_admin) {
            $grupos = Grupo::with(['materia','docente'])->get();
        } else {
            $grupos = Grupo::where(
                'docente_creador_id',
                auth()->id()
            )->with(['materia','docente'])->get();
        }

        return view('grupos.index', compact('grupos'));
    }

    public function create()
    {
           
        $materias = Materia::all();
        return view(
            'grupos.create',
            compact('materias')
        );
    }
    public function store(Request $request)
    {
        
         $request->validate([
            'nombre_grupo' => 'required|string|max:255',
            'tema' => 'required|string|max:255',
            'materia_id' => 'required|exists:materias,id',
            'tipo' => 'required|string|max:255',
            'stand' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
        ]);

        Grupo::create([
            'nombre_grupo' => $request->nombre_grupo,
            'tema' => $request->tema,
            'materia_id' => $request->materia_id,
            'tipo' => $request->tipo,
            'estado' => 1,
            'descripcion' => $request->descripcion,
            'docente_creador_id' => auth()->id(),
        ]);

        return redirect()
                ->route('grupos.index')
                ->with('success', 'Grupo creado correctamente');
    }
    function edit($id)
    {
        $grupo = Grupo::findOrFail($id);
        $materias = Materia::all();
        return view(
            'grupos.edit',
            compact('grupo', 'materias')
        );
    }
    function update(Request $request, $id)
    {
        $request->validate([
            'nombre_grupo' => 'required|string|max:255',
            'tema' => 'required|string|max:255',
            'materia_id' => 'required|exists:materias,id',
            'tipo' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
        ]); 

        $grupo = Grupo::findOrFail($id);
        $grupo->update($request->all());

        return redirect()
                ->route('grupos.index')
                ->with('success', 'Grupo actualizado correctamente');
    }
    public function integrantes($id)
    {
        $grupo = Grupo::with(['alumnos.curso', 'materia'])
            ->findOrFail($id);
        $alumnosAsignados = DB::table('grupo_alumno')
            ->pluck('alumno_id');
        $alumnos = Alumno::where('id', $grupo->curso_id)
            ->get();

        return view('grupos.integrantes', compact(
            'grupo',
            'alumnos'
        ));
    }
    public function guardarIntegrantes(Request $request, $id)
    {
        $grupo = Grupo::with('alumnos')->findOrFail($id);

        $request->validate([
            'alumnos' => 'required|array|min:1',
            'alumnos.*' => 'required|exists:alumnos,id',
        ], [
            'alumnos.required' => 'Debe seleccionar al menos un estudiante.',
            'alumnos.min' => 'Debe seleccionar al menos un estudiante.',
            'alumnos.*.exists' => 'Uno de los estudiantes seleccionados no existe.',
        ]);

        if ($grupo->tipo === 'Individual' && count($request->alumnos) !== 1) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Un proyecto individual debe tener exactamente un estudiante.'
                );
        }

        $ocupados = DB::table('grupo_alumno')
            ->whereIn('alumno_id', $request->alumnos)
            ->where('grupo_id', '!=', $grupo->id)
            ->exists();

        if ($ocupados) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Uno o más estudiantes ya pertenecen a otro grupo.'
                );
        }

        $grupo->alumnos()->sync($request->alumnos);

        return redirect()
            ->route('grupos.index')
            ->with('success', 'Integrantes asignados correctamente.');
    }
}
