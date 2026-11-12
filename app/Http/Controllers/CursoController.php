<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::all(); // Replace 'Curso' with your actual model name
        return view('cursos.index', compact('cursos'));
    }

    public function create()
    {
        return view('cursos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'nivel' => 'required',
            'grado' => 'required|integer|min:1|max:6'
        ]);

        Curso::create([
            'nombre' => $request->nombre,
            'nivel' => $request->nivel,
            'grado' => $request->grado
        ]);

        return redirect()
                ->route('cursos.index')
                ->with('success', 'Curso creado correctamente');
    }

    public function edit($id)
    {
        $curso = Curso::findOrFail($id);
        return view('cursos.edit', compact('curso'));
    }

    public function update(Request $request, $id)
    {
         $request->validate([
            'nombre' => 'required',
            'nivel' => 'required',
            'grado' => 'required|integer|min:1|max:6'
        ]);

        $curso = Curso::findOrFail($id);

        $curso->update([
            'nombre' => $request->nombre,
            'nivel' => $request->nivel,
            'grado' => $request->grado
        ]);

        return redirect()
                ->route('cursos.index')
                ->with('success', 'Curso actualizado correctamente');
    }

    public function destroy($id)
    {
        $curso = Curso::findOrFail($id);
        $curso->delete();

        return redirect()
                ->route('cursos.index')
                ->with('success', 'Curso eliminado correctamente');
    }
}
