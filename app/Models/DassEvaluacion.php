<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DassEvaluacion extends Model
{
    protected $table = 'dass';

    protected $fillable = [
        'matricula_alum',
        'total_depresion',
        'total_ansiedad',
        'total_estres',
        'total_general',
    ];

    protected $casts = [
        'total_depresion' => 'integer',
        'total_ansiedad' => 'integer',
        'total_estres' => 'integer',
        'total_general' => 'integer',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'matricula_alum', 'matricula_alum');
    }

    public function depresion()
    {
        return $this->hasOne(DassDepresion::class, 'id_cuestionario');
    }

    public function ansiedad()
    {
        return $this->hasOne(DassAnsiedad::class, 'id_cuestionario');
    }

    public function estres()
    {
        return $this->hasOne(DassEstres::class, 'id_cuestionario');
    }

    public static function severidadDepresion(int $total): string
    {
        return match (true) {
            $total <= 9  => 'Normal',
            $total <= 13 => 'Leve',
            $total <= 20 => 'Moderada',
            $total <= 27 => 'Severa',
            default      => 'Extremadamente severa',
        };
    }

    public static function severidadAnsiedad(int $total): string
    {
        return match (true) {
            $total <= 7  => 'Normal',
            $total <= 9  => 'Leve',
            $total <= 14 => 'Moderada',
            $total <= 19 => 'Severa',
            default      => 'Extremadamente severa',
        };
    }

    public static function severidadEstres(int $total): string
    {
        return match (true) {
            $total <= 14 => 'Normal',
            $total <= 18 => 'Leve',
            $total <= 25 => 'Moderado',
            $total <= 33 => 'Severo',
            default      => 'Extremadamente severo',
        };
    }
}
