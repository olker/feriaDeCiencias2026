<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\MateriaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\AsignacionController;
use App\Http\Controllers\AsignacionEvaluadorController;

Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
        Route::get('/profile', function () {
                            return view('profile');
                        })->name('profile.edit');
        Route::get('/cursos', [CursoController::class, 'index'])->name('cursos.index');
        Route::get('/materias', [MateriaController::class, 'index'])->name('materias.index');
        Route::post('/cerrar-sesion', [HomeController::class, 'cerrarSesion'])->name('cerrar.sesion');

        //Docentes
        Route::get('/docentes', [DocenteController::class, 'index'])->name('docentes.index');
        Route::get('/docentes', [DocenteController::class, 'index'])
                ->name('docentes.index');
        Route::get('/docentes/create', [DocenteController::class, 'create'])
                ->name('docentes.create');
        Route::post('/docentes', [DocenteController::class, 'store'])
                ->name('docentes.store');
        Route::get('/docentes/{id}/edit', [DocenteController::class, 'edit'])
                ->name('docentes.edit');
        Route::put('/docentes/{id}', [DocenteController::class, 'update'])
                ->name('docentes.update');
        Route::delete('/docentes/{id}', [DocenteController::class, 'destroy'])
                ->name('docentes.destroy');
        //docente-asignacion
        Route::get('/asignaciones', [AsignacionController::class, 'index'])
                ->name('asignaciones.index');
        Route::get('/asignaciones/create', [AsignacionController::class, 'create'])
                ->name('asignaciones.create');
        Route::post('/asignaciones', [AsignacionController::class, 'store'])
                ->name('asignaciones.store');
        Route::get('/asignaciones/{id}/edit', [AsignacionController::class, 'edit'])
                ->name('asignaciones.edit');
        Route::put('/asignaciones/{id}', [AsignacionController::class, 'update'])
                ->name('asignaciones.update');
        Route::delete('/asignaciones/{id}', [AsignacionController::class, 'destroy'])
                ->name('asignaciones.destroy');


        Route::get('/evaluadores',[AsignacionEvaluadorController::class, 'index'])
                ->name('evaluadores.index');
        Route::post('/evaluadores',[AsignacionEvaluadorController::class, 'store'])
                ->name('evaluadores.store');
        Route::delete('/evaluadores/{id}',[AsignacionEvaluadorController::class, 'destroy'])
                ->name('evaluadores.destroy');
        //docente-materia
        Route::get('/docente-materia', [DocenteController::class, 'materiaIndex'])
                ->name('docente-materia.index');        

        //Alumnos

        Route::get('/alumnos', [AlumnoController::class, 'index'])->name('alumnos.index');
        Route::get('/alumnos/create', [AlumnoController::class, 'create'])->name('alumnos.create');
        Route::post('/alumnos', [AlumnoController::class, 'store'])->name('alumnos.store');
        Route::get('/alumnos/{id}/edit', [AlumnoController::class, 'edit'])->name('alumnos.edit');
        Route::put('/alumnos/{id}', [AlumnoController::class, 'update'])->name('alumnos.update');
        Route::delete('/alumnos/{id}', [AlumnoController::class, 'destroy'])->name('alumnos.destroy');
        
        //cursos

        Route::get('/cursos', [CursoController::class, 'index'])->name('cursos.index');
        Route::get('/cursos/create', [CursoController::class, 'create'])->name('cursos.create');
        Route::post('/cursos', [CursoController::class, 'store'])->name('cursos.store');
        Route::get('/cursos/{id}/edit', [CursoController::class, 'edit'])->name('cursos.edit');
        Route::put('/cursos/{id}', [CursoController::class, 'update'])->name('cursos.update');
        Route::delete('/cursos/{id}', [CursoController::class, 'destroy'])->name('cursos.destroy');

        //materias

        Route::get('/materias', [MateriaController::class, 'index'])->name('materias.index');
        Route::get('/materias/create', [MateriaController::class, 'create'])->name('materias.create');
        Route::post('/materias', [MateriaController::class, 'store'])->name('materias.store');
        Route::get('/materias/{id}/edit', [MateriaController::class, 'edit'])->name('materias.edit');
        Route::put('/materias/{id}', [MateriaController::class, 'update'])->name('materias.update');
        Route::delete('/materias/{id}', [MateriaController::class, 'destroy'])->name('materias.destroy');

        //Grupos

        Route::get('/grupos', [GrupoController::class, 'index'])->name('grupos.index');
        Route::get('/grupos/create', [GrupoController::class, 'create'])->name('grupos.create');
        Route::post('/grupos', [GrupoController::class, 'store'])->name('grupos.store');
        Route::get('/grupos/{id}/edit', [GrupoController::class, 'edit'])->name('grupos.edit');
        Route::put('/grupos/{id}', [GrupoController::class, 'update'])->name('grupos.update');
        Route::delete('/grupos/{id}', [GrupoController::class, 'destroy'])->name('grupos.destroy');
        Route::get('/grupos/{id}/integrantes',[GrupoController::class, 'integrantes'])->name('grupos.integrantes');
        Route::put('/grupos/{id}/integrantes',[GrupoController::class, 'guardarIntegrantes'])->name('grupos.integrantes.update');

        //evaluaciones

        Route::get('/evaluaciones', function () {
                return view('evaluaciones.index');
        })->name('evaluaciones.index');
});
require __DIR__.'/auth.php';
