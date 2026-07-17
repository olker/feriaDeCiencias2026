<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $table = 'grupos';

    protected $fillable = [
        'nombre_grupo',
        'tema',
        'materia_id',
        'curso_id',
        'tipo',
        'qr_token',
        'estado',
        'descripcion',
        'docente_creador_id',
    ];

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    public function docente()
    {
        return $this->belongsTo(
            Docente::class,
            'docente_creador_id'
        );
    }

    public function alumnos()
    {
        return $this->belongsToMany(
            Alumno::class,
            'grupo_alumno',
            'grupo_id',
            'alumno_id'
        );
    }
   public function calificaciones()
    {
        return $this->hasMany(
            Calificacion::class,
            'grupo_id'
        );
    }

    public function asignacionesEvaluadores()
    {
        return $this->hasMany(
            DocenteAsignacion::class,
            'grupo_id'
        );
    }
}