<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Calificacion;
use App\Models\DocenteCurso;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteCalificacionController extends Controller
{
    /**
     * Reporte detallado de calificaciones.
     */
    public function detalle()
    {
        $consulta = Grupo::with([
            'curso',
            'materia',
            'alumnos',
            'calificaciones.docente',
            'calificaciones.alumno',
        ]);

        /*
         * El administrador ve todos los grupos.
         *
         * El docente solo ve:
         * - Los grupos que él creó.
         * - Los grupos cuyo curso y materia tiene asignados.
         */
        if (!auth()->user()->es_admin) {
            $consulta
                ->where('docente_creador_id', auth()->id())
                ->whereExists(function ($query) {
                    $query
                        ->select(DB::raw(1))
                        ->from('docente_curso')
                        ->whereColumn(
                            'docente_curso.curso_id',
                            'grupos.curso_id'
                        )
                        ->whereColumn(
                            'docente_curso.materia_id',
                            'grupos.materia_id'
                        )
                        ->where(
                            'docente_curso.docente_id',
                            auth()->id()
                        );
                });
        }

        $grupos = $consulta
            ->orderBy('curso_id')
            ->orderBy('materia_id')
            ->orderBy('nombre_grupo')
            ->get();

        return view(
            'reportes.detalle',
            compact('grupos')
        );
    }

    /**
     * Lista resumida por curso y materia.
     */
    public function resumen(Request $request)
    {
        $usuario = auth()->user();

        /*
        * Solo pueden ingresar:
        * - El administrador.
        * - Docentes que hayan creado al menos un grupo.
        */
        if (!$usuario->es_admin) {
            $creoAlgunGrupo = Grupo::where(
                    'docente_creador_id',
                    $usuario->id
                )
                ->exists();

            if (!$creoAlgunGrupo) {
                abort(
                    403,
                    'No tiene grupos creados para acceder a los reportes.'
                );
            }
        }

        /*
        * Cursos disponibles.
        *
        * Administrador:
        * ve todos los cursos que tienen grupos de feria.
        *
        * Docente:
        * ve solamente los cursos que tiene asignados,
        * sin repetirlos por materia.
        */
        if ($usuario->es_admin) {
            $cursos = Grupo::with('curso')
                ->get()
                ->pluck('curso')
                ->filter()
                ->unique('id')
                ->sortBy('id')
                ->values();
        } else {
            $cursos = DocenteCurso::with('curso')
                ->where('docente_id', $usuario->id)
                ->get()
                ->pluck('curso')
                ->filter()
                ->unique('id')
                ->sortBy('id')
                ->values();
        }

        $cursoId = $request->curso_id;

        $cursoSeleccionado = null;
        $alumnos = collect();

        if ($cursoId) {
            /*
            * Verificar que el docente realmente tenga
            * asignado el curso seleccionado.
            */
            if (!$usuario->es_admin) {
                $cursoPermitido = DocenteCurso::where(
                        'docente_id',
                        $usuario->id
                    )
                    ->where('curso_id', $cursoId)
                    ->exists();

                if (!$cursoPermitido) {
                    abort(
                        403,
                        'No tiene acceso a las notas de este curso.'
                    );
                }
            }

            $cursoSeleccionado = $cursos->firstWhere(
                'id',
                (int) $cursoId
            );

            if (!$cursoSeleccionado) {
                abort(404, 'Curso no encontrado.');
            }

            /*
            * Obtenemos todos los grupos de feria del curso,
            * sin importar qué docente creó el grupo
            * ni en qué materia se registró.
            */
            $gruposCurso = Grupo::with([
                'materia',
                'alumnos',
                'calificaciones',
            ])
                ->where('curso_id', $cursoId)
                ->get();

            /*
            * Lista completa de estudiantes del curso.
            */
            $alumnos = Alumno::where(
                    'curso_id',
                    $cursoId
                )
                ->orderBy('nombre')
                ->get()
                ->map(function ($alumno) use ($gruposCurso) {

                    /*
                    * Encontramos el grupo de feria
                    * al que pertenece el estudiante.
                    */
                    $grupoAlumno = $gruposCurso->first(
                        function ($grupo) use ($alumno) {
                            return $grupo->alumnos->contains(
                                'id',
                                $alumno->id
                            );
                        }
                    );

                    $alumno->grupo_feria = null;
                    $alumno->materia_feria = null;
                    $alumno->cantidad_evaluadores = 0;
                    $alumno->promedio_final = null;

                    if ($grupoAlumno) {
                        $alumno->grupo_feria =
                            $grupoAlumno->nombre_grupo;

                        $alumno->materia_feria =
                            $grupoAlumno->materia?->nombre
                            ?? 'Sin materia';

                        /*
                        * Solo calificaciones correspondientes
                        * a este estudiante.
                        */
                        $notasAlumno = $grupoAlumno
                            ->calificaciones
                            ->where('alumno_id', $alumno->id);

                        $alumno->cantidad_evaluadores =
                            $notasAlumno
                                ->pluck('docente_id')
                                ->unique()
                                ->count();

                        if ($notasAlumno->isNotEmpty()) {
                            $alumno->promedio_final = round(
                                $notasAlumno->avg('nota_final'),
                                2
                            );
                        }
                    }

                    return $alumno;
                });
        }

        return view('reportes.resumen', compact(
            'cursos',
            'cursoId',
            'cursoSeleccionado',
            'alumnos'
        ));
    }
}