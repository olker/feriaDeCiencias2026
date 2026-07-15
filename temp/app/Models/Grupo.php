<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grupo extends Model
{
    use HasFactory;

    protected $table = 'grupos';

    protected $fillable = [
        'nombre_grupo',
        'tema',
        'materia_id',
        'tipo',
        'estado',
        'descripcion',
        'docente_creador_id',
        'qr_token'
    ];

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'docente_creador_id');
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
}