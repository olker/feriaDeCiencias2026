<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Docente extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'docentes';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'es_admin',
        'estado'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'id_docente');
    }
}