<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facultad extends Model
{
    protected $table = 'facultad';
    protected $primaryKey = 'id_facultad';

    protected $fillable = ['nombre_facultad'];

    public function carreras()
    {
        return $this->hasMany(Carrera::class, 'id_facultad', 'id_facultad');
    }

    public function alumnos()
    {
        return $this->hasMany(Alumno::class, 'id_facultad', 'id_facultad');
    }
}
