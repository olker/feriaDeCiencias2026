<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alumno extends Model
{
    use HasFactory;

    protected $table = 'alumnos';

    protected $fillable = [
        'nombre',
        'id_curso'
    ];
     public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso');
    }
    public function grupos()
    {
        return $this->belongsToMany(
            Grupo::class,
            'grupo_alumno',
            'alumno_id',
            'grupo_id'
        );
    }
    public function calificaciones()
    {
        return $this->hasMany(
            Calificacion::class,
            'alumno_id'
        );
    }
}