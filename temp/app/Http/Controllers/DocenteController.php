<?php

namespace App\Http\Controllers;

use App\Models\Docente;
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
}