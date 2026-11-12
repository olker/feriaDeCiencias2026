<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Curso;
use App\Models\TrabajoArte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class TrabajoArteController extends Controller
{
    private function columnaCursoAlumno()
    {
        if (Schema::hasColumn('alumnos', 'id_curso')) return 'id_curso';
        return 'curso_id';
    }

    public function index(Request $request)
    {
        $cursos = Curso::orderBy('nombre')->get();
        $query = TrabajoArte::with('alumno')->withCount('calificaciones')
            ->where('docente_id', auth()->id());

        if ($request->filled('curso')) $query->where('curso', $request->curso);
        $trabajos = $query->latest()->get();

        return view('artes.index', compact('cursos', 'trabajos'));
    }

    public function create()
    {
        $cursos = Curso::orderBy('nombre')->get();
        return view('artes.create', compact('cursos'));
    }

    public function alumnosPorCurso($cursoId)
    {
        $columna = $this->columnaCursoAlumno();
        $alumnos = Alumno::where($columna, $cursoId)->orderBy('nombre')->get(['id', 'nombre']);
        return response()->json($alumnos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'alumno_id' => 'required|exists:alumnos,id',
            'trabajos' => 'required|array|min:1',
            'trabajos.*' => 'required|string|max:180',
        ], [
            'trabajos.required' => 'Registre al menos un trabajo.',
            'trabajos.*.required' => 'No deje títulos vacíos.',
        ]);

        $columna = $this->columnaCursoAlumno();
        $alumno = Alumno::where('id', $request->alumno_id)
            ->where($columna, $request->curso_id)->firstOrFail();
        $curso = Curso::findOrFail($request->curso_id);

        $creados = 0;
        foreach ($request->trabajos as $titulo) {
            $titulo = trim($titulo);
            if ($titulo === '') continue;

            TrabajoArte::create([
                'docente_id' => auth()->id(),
                'alumno_id' => $alumno->id,
                'curso' => $curso->nombre,
                'titulo_trabajo' => $titulo,
                'qr_token' => Str::random(48),
            ]);
            $creados++;
        }

        return redirect()->route('artes.index')
            ->with('success', $creados . ' trabajo(s) registrado(s) para ' . $alumno->nombre . '.');
    }

    public function imprimir(Request $request)
    {
        $request->validate(['curso' => 'required|string']);
        $trabajos = TrabajoArte::with('alumno')
            ->where('docente_id', auth()->id())
            ->where('curso', $request->curso)
            ->orderBy('alumno_id')->orderBy('id')->get();

        abort_if($trabajos->isEmpty(), 404, 'No existen trabajos registrados para ese curso.');
        return view('artes.imprimir', compact('trabajos'));
    }

    public function destroy($id)
    {
        $trabajo = TrabajoArte::where('docente_id', auth()->id())->findOrFail($id);
        $trabajo->delete();
        return back()->with('success', 'Trabajo eliminado correctamente.');
    }
}
