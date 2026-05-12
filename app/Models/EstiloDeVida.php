<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstiloDeVida extends Model
{
    protected $table = 'estilo_de_vida';

    protected $fillable = [
        'matricula_alum', 'total', 'fecha', 'estado_saludable',
    ];

    protected $casts = [
        'fecha' => 'date',
        'estado_saludable' => 'boolean',
        'total' => 'integer',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'matricula_alum', 'matricula_alum');
    }

    public function nutricion()
    {
        return $this->hasOne(Nutricion::class, 'id_cuestionario');
    }

    public function ejercicio()
    {
        return $this->hasOne(Ejercicio::class, 'id_cuestionario');
    }

    public function salud()
    {
        return $this->hasOne(Salud::class, 'id_cuestionario');
    }

    public function soporteInterpersonal()
    {
        return $this->hasOne(SoporteInterpersonal::class, 'id_cuestionario');
    }

    public function manejoEstres()
    {
        return $this->hasOne(ManejoEstres::class, 'id_cuestionario');
    }

    public function autoactualizacion()
    {
        return $this->hasOne(Autoactualizacion::class, 'id_cuestionario');
    }
}
