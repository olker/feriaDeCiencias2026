<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materia;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Materia::all(); // Replace 'Materia' with your actual model name
        return view('materias.index', compact('materias'));
    }
    public function create()
    {
        return view('materias.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);
        Materia::create(['nombre' => $request->nombre]);
        return redirect()->route('materias.index')
                         ->with('success', 'Materia created successfully.');
    }
    public function edit($id)
    {
        $materia = Materia::findOrFail($id);
        return view('materias.edit', compact('materia'));
    }
    public function update(Request $request, $id){
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);
        $materia = Materia::findOrFail($id);
        $materia->update(['nombre' => $request->nombre]);
        return redirect()->route('materias.index')
                         ->with('success', 'Materia updated successfully.');
    }
    public function destroy($id)
    {
        $materia = Materia::findOrFail($id);
        $materia->delete();
        return redirect()->route('materias.index')
                         ->with('success', 'Materia deleted successfully.');
    }
}
