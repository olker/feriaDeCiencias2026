<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'nivel',
        'grado'
    ];

    public function alumnos()
    {
        return $this->hasMany(Alumno::class,'curso_id');
    }
}
