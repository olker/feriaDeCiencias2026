<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Curso;

class AlumnoController extends Controller
{
    // LISTAR
    public function index()
    { 
        $alumnos = Alumno::with('curso')->get();
        return view('alumnos.index', compact('alumnos'));

    }

    // FORMULARIO CREATE
    public function create()
    {
        $cursos = Curso::all();
        return view('alumnos.create', compact('cursos'));
    }

    // GUARDAR
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'id_curso' => 'required'
        ]);

        Alumno::create([
            'nombre' => $request->nombre,
            'id_curso' => $request->id_curso
        ]);

        return redirect()
                ->route('alumnos.index')
                ->with('success', 'Alumno registrado correctamente');
    }

    // FORMULARIO EDIT
    public function edit($id)
    {
            // Traemos el alumno con sus datos del curso
            $alumno = Alumno::with('curso')->findOrFail($id);
            // Traemos todos los cursos para mostrarlos en el selector
            $cursos = Curso::orderBy('nombre', 'asc')->get();
            return view('alumnos.edit', compact('alumno', 'cursos'));
    }

    // ACTUALIZAR
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'curso_id' => 'required'
        ]);

        $alumno = Alumno::findOrFail($id);
        $alumno->update([
            'nombre' => $request->nombre,
            'curso_id' => $request->curso_id
        ]);

        return redirect()->route('alumnos.index')
            ->with('success', 'Alumno actualizado correctamente');
    }

    // ELIMINAR
    public function destroy($id)
    {
        $alumno = Alumno::findOrFail($id);
        $alumno->delete();

        return redirect()->route('alumnos.index')
            ->with('success', 'Alumno eliminado correctamente');
    }
}
