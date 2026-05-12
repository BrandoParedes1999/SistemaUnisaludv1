<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Alumno extends Authenticatable
{
    use Notifiable;

    protected $table = 'alumnos';
    protected $primaryKey = 'matricula_alum';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'matricula_alum',
        'nombres_alum',
        'ape_paterno_alum',
        'ape_materno_alum',
        'edad_alum',
        'sexo',
        'correo_alum',
        'fe_nacimiento_alum',
        'id_carrera',
        'id_facultad',
        'generacion',
        'fecha_ingreso',
        'password',
        'tipo_sangre',
        'nss',
        'enfermedades',
        'emergencia',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'fe_nacimiento_alum' => 'date',
        'fecha_ingreso' => 'date',
    ];

    public function getNombreCompletoAttribute(): string
    {
        return trim("{$this->nombres_alum} {$this->ape_paterno_alum} {$this->ape_materno_alum}");
    }

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'id_carrera', 'id_carrera');
    }

    public function facultad()
    {
        return $this->belongsTo(Facultad::class, 'id_facultad', 'id_facultad');
    }

    public function datosFisicos()
    {
        return $this->hasMany(DatosFisicos::class, 'matricula_alum', 'matricula_alum')
            ->orderByDesc('fecha');
    }

    public function historial()
    {
        return $this->hasMany(HistorialAlumno::class, 'matricula_alum', 'matricula_alum');
    }

    public function patologias()
    {
        return $this->hasMany(Patologia::class, 'matricula_alum', 'matricula_alum');
    }

    public function evaluacionesDass()
    {
        return $this->hasMany(DassEvaluacion::class, 'matricula_alum', 'matricula_alum')
            ->orderByDesc('created_at');
    }

    public function estilosDeVida()
    {
        return $this->hasMany(EstiloDeVida::class, 'matricula_alum', 'matricula_alum')
            ->orderByDesc('fecha');
    }

    public function ultimosDatosFisicos()
    {
        return $this->hasOne(DatosFisicos::class, 'matricula_alum', 'matricula_alum')
            ->latestOfMany('fecha');
    }

    public function ultimaEvaluacionDass()
    {
        return $this->hasOne(DassEvaluacion::class, 'matricula_alum', 'matricula_alum')
            ->latestOfMany();
    }

    public function ultimoEstiloDeVida()
    {
        return $this->hasOne(EstiloDeVida::class, 'matricula_alum', 'matricula_alum')
            ->latestOfMany('fecha');
    }
}
