<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\DocenteAsignacion;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DocenteController extends Controller
{
    public function index()
    {
        $docentes = Docente::all();

        return view('docentes.index', compact('docentes'));
    }

    public function create()
    {
        return view('docentes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>'required',
            'email'=>'required|email|unique:docentes',
            'password'=>'required|min:6'
        ]);

        Docente::create([
            'nombre'=>$request->nombre,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'es_admin'=>0,
            'estado'=>1
        ]);

        return redirect()->route('docentes.index');
    }

    public function edit($id)
    {
        $docente = Docente::findOrFail($id);

        return view('docentes.edit', compact('docente'));
    }

    public function update(Request $request, $id)
    {
        $docente = Docente::findOrFail($id);
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:docentes,email,' . $id,
        ]);
        $datos = [
            'nombre' => $request->nombre,
            'email' => $request->email,
            'es_admin' => $request->es_admin,
            'estado' => $request->estado,
        ];
        // Solo actualizar si escribió una nueva contraseña
        if ($request->filled('password')) {
            $datos['password'] = Hash::make($request->password);
        }
        $docente->update($datos);
        return redirect()
                ->route('docentes.index')
                ->with('success', 'Docente actualizado correctamente');
    }

    public function destroy($id)
    {
        Docente::findOrFail($id)->delete();

        return redirect()->route('docentes.index');
    }
    public function evaluadorIndex()
    {
        $docentes = Docente::where('estado', 1)
            ->where('es_admin', 0)
            ->orderBy('nombre')
            ->get();

        $grupos = Grupo::with([
            'materia',
            'curso'
        ])
            ->orderBy('nombre_grupo')
            ->get();

        $asignaciones = DocenteAsignacion::with([
            'docente',
            'grupo.materia',
            'grupo.curso'
        ])
            ->orderBy('docente_id')
            ->get();

        return view('docentes.evaluadores', compact(
            'docentes',
            'grupos',
            'asignaciones'
        ));
    }
    public function guardarEvaluador(Request $request)
    {
        $request->validate([
            'docente_id' => 'required|exists:docentes,id',
            'grupo_id' => 'required|exists:grupos,id',
        ], [
            'docente_id.required' => 'Seleccione un docente.',
            'docente_id.exists' => 'El docente seleccionado no existe.',
            'grupo_id.required' => 'Seleccione un grupo.',
            'grupo_id.exists' => 'El grupo seleccionado no existe.',
        ]);

        $existe = DocenteAsignacion::where('docente_id', $request->docente_id)
            ->where('grupo_id', $request->grupo_id)
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->with('error', 'Este docente ya está asignado a ese grupo.');
        }

        DocenteAsignacion::create([
            'docente_id' => $request->docente_id,
            'grupo_id' => $request->grupo_id,
        ]);

        return redirect()
            ->route('docentes.evaluadores')
            ->with('success', 'Evaluador asignado correctamente.');
    }
    public function eliminarEvaluador($id)
    {
        $asignacion = DocenteAsignacion::findOrFail($id);

        $asignacion->delete();

        return redirect()
            ->route('docentes.evaluadores')
            ->with('success', 'Asignación eliminada correctamente.');
    }
}