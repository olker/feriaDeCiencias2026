<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\Materia;
use App\Models\Alumno;
use App\Models\DocenteAsignacion;
use App\Models\DocenteCurso;
use App\Models\Curso;
use Illuminate\Support\Str;

class GrupoController extends Controller
{
    public function index()
    {
        if (auth()->user()->es_admin) {
            $grupos = Grupo::with([
                'materia',
                'curso',
                'docente',
                'alumnos'
            ])->get();
        } else {
            $grupos = Grupo::where(
                    'docente_creador_id',
                    auth()->id()
                )
                ->with([
                    'materia',
                    'curso',
                    'docente',
                    'alumnos'
                ])
                ->get();
        }

        return view('grupos.index', compact('grupos'));
    }

    public function create()
    {
        $asignaciones = DocenteCurso::with([
            'curso',
            'materia'
        ])
            ->where('docente_id', auth()->id())
            ->get();

        $cursos = $asignaciones
            ->pluck('curso')
            ->filter()
            ->unique('id')
            ->sortBy('id')
            ->values();

        $materias = $asignaciones
            ->pluck('materia')
            ->filter()
            ->unique('id')
            ->sortBy('nombre')
            ->values();

        return view('grupos.create', compact(
            'cursos',
            'materias'
        ));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nombre_grupo' => 'required|string|max:100',
            'tema' => 'required|string|max:200',
            'materia_id' => 'required|exists:materias,id',
            'curso_id' => 'required|exists:cursos,id',
            'tipo' => 'required|in:Individual,Grupal',
            'descripcion' => 'nullable|string|max:1000',
        ], [
            'nombre_grupo.required' => 'Ingrese el nombre del grupo.',
            'tema.required' => 'Ingrese el tema del proyecto.',
            'materia_id.required' => 'Seleccione una materia.',
            'curso_id.required' => 'Seleccione un curso.',
            'tipo.required' => 'Seleccione el tipo de exposición.',
        ]);

        Grupo::create([
            'nombre_grupo' => $request->nombre_grupo,
            'tema' => $request->tema,
            'materia_id' => $request->materia_id,
            'curso_id' => $request->curso_id,
            'tipo' => $request->tipo,
            'qr_token' => Str::uuid(),
            'estado' => 'Pendiente',
            'descripcion' => $request->descripcion,
            'docente_creador_id' => auth()->id(),
        ]);

        return redirect()
            ->route('grupos.index')
            ->with('success', 'Grupo registrado correctamente.');
    }
    public function edit($id)
    {
        $grupo = Grupo::findOrFail($id);
        $materias = Materia::orderBy('nombre')->get();
        $cursos = Curso::orderBy('id')->get();

        return view('grupos.edit', compact(
            'grupo',
            'materias',
            'cursos'
        ));
    }
    public function update(Request $request, $id)
    {
        $grupo = Grupo::findOrFail($id);

        $request->validate([
            'nombre_grupo' => 'required|string|max:100',
            'tema' => 'required|string|max:200',
            'materia_id' => 'required|exists:materias,id',
            'curso_id' => 'required|exists:cursos,id',
            'tipo' => 'required|in:Individual,Grupal',
            'estado' => 'required|in:Pendiente,Evaluado',
            'descripcion' => 'nullable|string|max:1000',
        ]);

        $grupo->update([
            'nombre_grupo' => $request->nombre_grupo,
            'tema' => $request->tema,
            'materia_id' => $request->materia_id,
            'curso_id' => $request->curso_id,
            'tipo' => $request->tipo,
            'estado' => $request->estado,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()
            ->route('grupos.index')
            ->with('success', 'Grupo actualizado correctamente.');
    }
   public function integrantes($id)
    {
        $grupo = Grupo::with([
            'alumnos.curso',
            'materia',
            'curso'
        ])->findOrFail($id);

        $alumnosOcupados = DB::table('grupo_alumno')
            ->where('grupo_id', '!=', $grupo->id)
            ->pluck('alumno_id');

        $alumnos = Alumno::with('curso')
            ->where('curso_id', $grupo->curso_id)
            ->whereNotIn('id', $alumnosOcupados)
            ->orderBy('nombre')
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
