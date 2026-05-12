<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patologia extends Model
{
    protected $table = 'patologias_alumnos';

    protected $fillable = [
        'matricula_alum',
        'enfermedad',
        'tratamiento',
        'fecha',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'matricula_alum', 'matricula_alum');
    }
}
