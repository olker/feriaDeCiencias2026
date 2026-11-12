<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Curso;
use App\Models\DocenteCurso;
use App\Models\Grupo;
use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GrupoController extends Controller
{
    public function index()
    {
        $consulta = Grupo::with([
            'materia',
            'curso',
            'docente',
            'alumnos',
        ]);

        if (!auth()->user()->es_admin) {
            $consulta->where(
                'docente_creador_id',
                auth()->id()
            );
        }

        $grupos = $consulta
            ->orderBy('curso_id')
            ->orderBy('nombre_grupo')
            ->get();

        return view('grupos.index', compact('grupos'));
    }

    public function create()
    {
        /*
         * El administrador puede escoger cualquier curso y materia.
         * El docente solo puede utilizar sus asignaciones.
         */
        if (auth()->user()->es_admin) {
            $cursos = Curso::orderBy('id')->get();
            $materias = Materia::orderBy('nombre')->get();
            $asignaciones = collect();
        } else {
            $asignaciones = DocenteCurso::with([
                'curso',
                'materia',
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
        }

        return view('grupos.create', compact(
            'cursos',
            'materias',
            'asignaciones'
        ));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre_grupo' => 'required|string|max:100',
            'tema' => 'required|string|max:200',
            'materia_id' => 'required|exists:materias,id',
            'curso_id' => 'required|exists:cursos,id',
            'tipo' => 'required|in:Individual,Grupal',
            'descripcion' => 'nullable|string|max:1000',
        ], [
            'nombre_grupo.required' =>
                'Ingrese el nombre del grupo.',

            'tema.required' =>
                'Ingrese el tema del proyecto.',

            'materia_id.required' =>
                'Seleccione una materia.',

            'curso_id.required' =>
                'Seleccione un curso.',

            'tipo.required' =>
                'Seleccione el tipo de exposición.',
        ]);

        /*
         * Comprobar que el docente tenga asignada exactamente
         * la combinación curso + materia.
         */
        if (!auth()->user()->es_admin) {
            $asignacionValida = DocenteCurso::where(
                    'docente_id',
                    auth()->id()
                )
                ->where('curso_id', $datos['curso_id'])
                ->where('materia_id', $datos['materia_id'])
                ->exists();

            if (!$asignacionValida) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'El curso y la materia seleccionados no corresponden a sus asignaciones.'
                    );
            }
        }

        Grupo::create([
            'nombre_grupo' => $datos['nombre_grupo'],
            'tema' => $datos['tema'],
            'materia_id' => $datos['materia_id'],
            'curso_id' => $datos['curso_id'],
            'tipo' => $datos['tipo'],
            'qr_token' => (string) Str::uuid(),
            'estado' => 'Pendiente',
            'descripcion' => $datos['descripcion'] ?? null,
            'docente_creador_id' => auth()->id(),
        ]);

        return redirect()
            ->route('grupos.index')
            ->with(
                'success',
                'Grupo registrado correctamente.'
            );
    }

    public function edit($id)
    {
        $grupo = Grupo::findOrFail($id);

        $this->verificarPropietario($grupo);

        /*
         * El administrador puede ver todos los cursos y materias.
         * El docente solo los que tiene asignados.
         */
        if (auth()->user()->es_admin) {
            $cursos = Curso::orderBy('id')->get();
            $materias = Materia::orderBy('nombre')->get();
            $asignaciones = collect();
        } else {
            $asignaciones = DocenteCurso::with([
                'curso',
                'materia',
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
        }

        return view('grupos.edit', compact(
            'grupo',
            'materias',
            'cursos',
            'asignaciones'
        ));
    }

    public function update(Request $request, $id)
    {
        $grupo = Grupo::findOrFail($id);

        $this->verificarPropietario($grupo);

        $datos = $request->validate([
            'nombre_grupo' => 'required|string|max:100',
            'tema' => 'required|string|max:200',
            'materia_id' => 'required|exists:materias,id',
            'curso_id' => 'required|exists:cursos,id',
            'tipo' => 'required|in:Individual,Grupal',
            'descripcion' => 'nullable|string|max:1000',
        ], [
            'nombre_grupo.required' =>
                'Ingrese el nombre del grupo.',

            'tema.required' =>
                'Ingrese el tema del proyecto.',

            'materia_id.required' =>
                'Seleccione una materia.',

            'curso_id.required' =>
                'Seleccione un curso.',

            'tipo.required' =>
                'Seleccione el tipo de exposición.',
        ]);

        if (!auth()->user()->es_admin) {
            $asignacionValida = DocenteCurso::where(
                    'docente_id',
                    auth()->id()
                )
                ->where('curso_id', $datos['curso_id'])
                ->where('materia_id', $datos['materia_id'])
                ->exists();

            if (!$asignacionValida) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'El curso y la materia seleccionados no corresponden a sus asignaciones.'
                    );
            }
        }

        /*
         * Si se cambia el curso y ya había integrantes,
         * se eliminan para evitar estudiantes de otro curso.
         */
        if ((int) $grupo->curso_id !== (int) $datos['curso_id']) {
            $grupo->alumnos()->detach();
        }

        $grupo->update([
            'nombre_grupo' => $datos['nombre_grupo'],
            'tema' => $datos['tema'],
            'materia_id' => $datos['materia_id'],
            'curso_id' => $datos['curso_id'],
            'tipo' => $datos['tipo'],
            'descripcion' => $datos['descripcion'] ?? null,
        ]);

        return redirect()
            ->route('grupos.index')
            ->with(
                'success',
                'Grupo actualizado correctamente.'
            );
    }

    public function integrantes($id)
    {
        $grupo = Grupo::with([
            'alumnos.curso',
            'materia',
            'curso',
        ])->findOrFail($id);

        $this->verificarPropietario($grupo);

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

        $this->verificarPropietario($grupo);

        $request->validate([
            'alumnos' => 'required|array|min:1',
            'alumnos.*' => 'required|exists:alumnos,id',
        ], [
            'alumnos.required' =>
                'Debe seleccionar al menos un estudiante.',

            'alumnos.min' =>
                'Debe seleccionar al menos un estudiante.',

            'alumnos.*.exists' =>
                'Uno de los estudiantes seleccionados no existe.',
        ]);

        if (
            $grupo->tipo === 'Individual'
            && count($request->alumnos) !== 1
        ) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Un proyecto individual debe tener exactamente un estudiante.'
                );
        }

        /*
         * Comprobar que todos los estudiantes seleccionados
         * pertenezcan al curso del grupo.
         */
        $cantidadValidos = Alumno::whereIn(
                'id',
                $request->alumnos
            )
            ->where('curso_id', $grupo->curso_id)
            ->count();

        if ($cantidadValidos !== count($request->alumnos)) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Uno o más estudiantes no pertenecen al curso del grupo.'
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
            ->with(
                'success',
                'Integrantes asignados correctamente.'
            );
    }

    public function destroy($id)
    {
        $grupo = Grupo::findOrFail($id);

        $this->verificarPropietario($grupo);

        try {
            DB::transaction(function () use ($grupo) {
                /*
                 * El orden es importante por las llaves foráneas.
                 */

                DB::table('calificaciones')
                    ->where('grupo_id', $grupo->id)
                    ->delete();

                DB::table('docente_asignacion')
                    ->where('grupo_id', $grupo->id)
                    ->delete();

                DB::table('grupo_alumno')
                    ->where('grupo_id', $grupo->id)
                    ->delete();

                $grupo->delete();
            });

            return redirect()
                ->route('grupos.index')
                ->with(
                    'success',
                    'Grupo eliminado correctamente.'
                );
        } catch (\Throwable $e) {
            report($e);

            return redirect()
                ->route('grupos.index')
                ->with(
                    'error',
                    'No se pudo eliminar el grupo porque tiene información relacionada.'
                );
        }
    }

    /**
     * El administrador puede administrar cualquier grupo.
     * El docente solo puede administrar los grupos que creó.
     */
    private function verificarPropietario(Grupo $grupo)
    {
        $usuario = auth()->user();

        if (
            !$usuario->es_admin
            && (int) $grupo->docente_creador_id !== (int) $usuario->id
        ) {
            abort(
                403,
                'No tiene permiso para administrar este grupo.'
            );
        }
    }
}