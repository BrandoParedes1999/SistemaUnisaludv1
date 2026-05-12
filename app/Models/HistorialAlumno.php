<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialAlumno extends Model
{
    protected $table = 'historial_alumnos';

    protected $fillable = [
        'matricula_alum', 'fecha_historial',
        'sobrepeso', 'diabetes', 'hipertension', 'trigliceridos',
        'colesterol', 'hepatitis', 'higado_graso', 'cardiopatias',
        'nefropatias', 'cancer', 'artritis', 'asma', 'alergias',
        'depresion', 'ansiedad',
        'otras_enfermedades', 'medicamentos', 'observaciones',
    ];

    protected $casts = [
        'fecha_historial' => 'date',
        'sobrepeso' => 'boolean', 'diabetes' => 'boolean',
        'hipertension' => 'boolean', 'trigliceridos' => 'boolean',
        'colesterol' => 'boolean', 'hepatitis' => 'boolean',
        'higado_graso' => 'boolean', 'cardiopatias' => 'boolean',
        'nefropatias' => 'boolean', 'cancer' => 'boolean',
        'artritis' => 'boolean', 'asma' => 'boolean',
        'alergias' => 'boolean', 'depresion' => 'boolean',
        'ansiedad' => 'boolean',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'matricula_alum', 'matricula_alum');
    }
}
