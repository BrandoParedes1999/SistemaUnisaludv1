<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $table = 'carrera';
    protected $primaryKey = 'id_carrera';

    protected $fillable = ['nombre_carrera', 'id_facultad'];

    public function facultad()
    {
        return $this->belongsTo(Facultad::class, 'id_facultad', 'id_facultad');
    }

    public function alumnos()
    {
        return $this->hasMany(Alumno::class, 'id_carrera', 'id_carrera');
    }
}
