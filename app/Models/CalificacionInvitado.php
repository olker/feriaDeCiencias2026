<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalificacionInvitado extends Model
{
    protected $table = 'calificaciones_invitados';

    protected $fillable = ['trabajo_arte_id', 'estrellas', 'ip_invitado'];

    public function trabajo()
    {
        return $this->belongsTo(TrabajoArte::class, 'trabajo_arte_id');
    }
}
