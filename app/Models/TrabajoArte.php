<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrabajoArte extends Model
{
    protected $table = 'trabajos_artes';

    protected $fillable = [
        'docente_id', 'alumno_id', 'curso', 'titulo_trabajo', 'qr_token',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }

    public function calificaciones()
    {
        return $this->hasMany(CalificacionInvitado::class, 'trabajo_arte_id');
    }

    public function getPromedioEstrellasAttribute()
    {
        return round((float) $this->calificaciones()->avg('estrellas'), 1);
    }
}
