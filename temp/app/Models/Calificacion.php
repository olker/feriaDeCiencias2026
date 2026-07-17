<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    use HasFactory;

    protected $table = 'calificaciones';

    protected $fillable = [
        'grupo_id',
        'alumno_id',
        'docente_id',
        'dominio_tema',
        'material_apoyo',
        'expresion_defensa',
        'nota_grupal',
        'nota_individual',
        'nota_final',
        'observacion',
    ];

    protected $casts = [
        'nota_final' => 'decimal:2',
    ];

    public function grupo()
    {
        return $this->belongsTo(
            Grupo::class,
            'grupo_id'
        );
    }

    public function alumno()
    {
        return $this->belongsTo(
            Alumno::class,
            'alumno_id'
        );
    }

    public function docente()
    {
        return $this->belongsTo(
            Docente::class,
            'docente_id'
        );
    }
}