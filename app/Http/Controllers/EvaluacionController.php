<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\DocenteAsignacion;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluacionController extends Controller
{
    public function index()
    {
        $asignaciones = DocenteAsignacion::with([
            'grupo.materia',
            'grupo.curso',
            'grupo.alumnos'
        ])
            ->where('docente_id', auth()->id())
            ->get();

        /*
         * Ahora un grupo genera varias filas en calificaciones,
         * una por cada estudiante. Solo necesitamos saber qué
         * grupos ya fueron evaluados por el docente conectado.
         */
        $gruposEvaluados = Calificacion::where(
                'docente_id',
                auth()->id()
            )
            ->distinct()
            ->pluck('grupo_id')
            ->toArray();

        return view('evaluaciones.index', compact(
            'asignaciones',
            'gruposEvaluados'
        ));
    }

    public function create($grupoId)
    {
        $grupo = Grupo::with([
            'materia',
            'curso',
            'alumnos'
        ])->findOrFail($grupoId);

        $asignado = DocenteAsignacion::where(
                'docente_id',
                auth()->id()
            )
            ->where('grupo_id', $grupo->id)
            ->exists();

        if (!$asignado) {
            abort(
                403,
                'No tiene autorización para evaluar este grupo.'
            );
        }

        if ($grupo->alumnos->isEmpty()) {
            return redirect()
                ->route('evaluaciones.index')
                ->with(
                    'error',
                    'El grupo no tiene estudiantes asignados.'
                );
        }

        $yaEvaluado = Calificacion::where(
                'docente_id',
                auth()->id()
            )
            ->where('grupo_id', $grupo->id)
            ->exists();

        if ($yaEvaluado) {
            return redirect()
                ->route('evaluaciones.index')
                ->with(
                    'error',
                    'Este grupo ya fue evaluado y no puede modificarse.'
                );
        }

        return view('evaluaciones.create', compact('grupo'));
    }

    public function store(Request $request, $grupoId)
    {
        $grupo = Grupo::with('alumnos')
            ->findOrFail($grupoId);

        $asignado = DocenteAsignacion::where(
                'docente_id',
                auth()->id()
            )
            ->where('grupo_id', $grupo->id)
            ->exists();

        if (!$asignado) {
            abort(
                403,
                'No tiene autorización para evaluar este grupo.'
            );
        }

        if ($grupo->alumnos->isEmpty()) {
            return redirect()
                ->route('evaluaciones.index')
                ->with(
                    'error',
                    'El grupo no tiene estudiantes asignados.'
                );
        }

        /*
         * Bloqueamos una segunda evaluación del mismo docente
         * para el mismo grupo.
         */
        $yaEvaluado = Calificacion::where(
                'docente_id',
                auth()->id()
            )
            ->where('grupo_id', $grupo->id)
            ->exists();

        if ($yaEvaluado) {
            return redirect()
                ->route('evaluaciones.index')
                ->with(
                    'error',
                    'Este grupo ya fue evaluado y no puede modificarse.'
                );
        }

        $datos = $request->validate([
            'dominio_tema' =>
                'required|integer|min:0|max:15',

            'material_apoyo' =>
                'required|integer|min:0|max:15',

            'expresion_defensa' =>
                'required|integer|min:0|max:15',

            'notas_individuales' =>
                'required|array',

            'notas_individuales.*' =>
                'required|integer|min:0|max:45',

            'observaciones' =>
                'nullable|array',

            'observaciones.*' =>
                'nullable|string|max:1000',
        ], [
            'dominio_tema.required' =>
                'Ingrese la nota de dominio del tema.',

            'dominio_tema.min' =>
                'La nota mínima es 0.',

            'dominio_tema.max' =>
                'La nota máxima es 15.',

            'material_apoyo.required' =>
                'Ingrese la nota del material de apoyo.',

            'material_apoyo.min' =>
                'La nota mínima es 0.',

            'material_apoyo.max' =>
                'La nota máxima es 15.',

            'expresion_defensa.required' =>
                'Ingrese la nota de expresión y defensa.',

            'expresion_defensa.min' =>
                'La nota mínima es 0.',

            'expresion_defensa.max' =>
                'La nota máxima es 15.',

            'notas_individuales.required' =>
                'Debe registrar las notas individuales.',

            'notas_individuales.*.required' =>
                'Debe ingresar la nota individual del estudiante.',

            'notas_individuales.*.min' =>
                'La nota individual mínima es 0.',

            'notas_individuales.*.max' =>
                'La nota individual máxima es 45.',
        ]);

        /*
         * Verificamos que el formulario incluya exactamente
         * a los estudiantes que pertenecen al grupo.
         */
        $idsIntegrantes = $grupo->alumnos
            ->pluck('id')
            ->sort()
            ->values();

        $idsRecibidos = collect(
            array_keys($datos['notas_individuales'])
        )
            ->map(fn ($id) => (int) $id)
            ->sort()
            ->values();

        if ($idsIntegrantes->toArray() !== $idsRecibidos->toArray()) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'La lista de estudiantes no corresponde a los integrantes del grupo.'
                );
        }

        $notaGrupal =
            $datos['dominio_tema'] +
            $datos['material_apoyo'] +
            $datos['expresion_defensa'];

        DB::transaction(function () use (
            $grupo,
            $datos,
            $notaGrupal
        ) {
            foreach ($grupo->alumnos as $alumno) {
                $notaIndividual = (int)
                    $datos['notas_individuales'][$alumno->id];

                $notaFinal = round(
                    ($notaGrupal + $notaIndividual) / 2,
                    2
                );

                Calificacion::create([
                    'grupo_id' => $grupo->id,
                    'alumno_id' => $alumno->id,
                    'docente_id' => auth()->id(),

                    'dominio_tema' =>
                        $datos['dominio_tema'],

                    'material_apoyo' =>
                        $datos['material_apoyo'],

                    'expresion_defensa' =>
                        $datos['expresion_defensa'],

                    'nota_grupal' => $notaGrupal,
                    'nota_individual' => $notaIndividual,
                    'nota_final' => $notaFinal,

                    'observacion' =>
                        $datos['observaciones'][$alumno->id]
                        ?? null,
                ]);
            }
        });

        return redirect()
            ->route('evaluaciones.index')
            ->with(
                'success',
                'Evaluación registrada correctamente. Ya no puede modificarse.'
            );
    }
}