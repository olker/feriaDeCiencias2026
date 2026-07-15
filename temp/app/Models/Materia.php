<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Materia extends Model
{
    use HasFactory, Notifiable ;

    protected $table = 'materias';

    protected $fillable = [
        'nombre',
    ];
    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'id_materia');
    }
}
