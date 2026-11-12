<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocenteAsignacion extends Model
{
    use HasFactory;

    protected $table = 'docente_asignacion';

    protected $fillable = [
        'docente_id',
        'grupo_id',
    ];

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'docente_id');
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }
}