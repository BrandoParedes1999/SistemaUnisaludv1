<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatosFisicos extends Model
{
    protected $table = 'datos_fisicos_alumnos';

    protected $fillable = [
        'matricula_alum', 'fecha',
        'cintura', 'cadera', 'icc', 'clasificacion_icc',
        'peso', 'talla', 'imc', 'clasificacion_imc',
        'ice', 'clasificacion_ice', 'mb',
        'glucosa', 'clasificacion_glucosa',
        'trigliceridos', 'clasificacion_trigliceridos',
        'colesterol', 'clasificacion_colesterol',
        'tension_arterial', 'clasificacion_ta',
        'porcentaje_masa_grasa', 'clasificacion_grasa',
        'agua_total', 'clasificacion_agua',
        'masa_muscular', 'clasificacion_muscular',
        'masa_osea', 'grasa_visceral', 'clasificacion_visceral',
    ];

    protected $casts = [
        'fecha' => 'date',
        'cintura' => 'float', 'cadera' => 'float', 'icc' => 'float',
        'peso' => 'float', 'talla' => 'float', 'imc' => 'float',
        'ice' => 'float', 'mb' => 'float',
        'glucosa' => 'float', 'trigliceridos' => 'float', 'colesterol' => 'float',
        'porcentaje_masa_grasa' => 'float', 'agua_total' => 'float',
        'masa_muscular' => 'float', 'masa_osea' => 'float', 'grasa_visceral' => 'float',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'matricula_alum', 'matricula_alum');
    }

    // Calculates BMI classification
    public static function clasificarIMC(float $imc): string
    {
        return match (true) {
            $imc < 18.5 => 'Bajo peso',
            $imc < 25.0 => 'Normal',
            $imc < 30.0 => 'Sobrepeso',
            $imc < 35.0 => 'Obesidad I',
            $imc < 40.0 => 'Obesidad II',
            default     => 'Obesidad III',
        };
    }

    public static function clasificarGlucosa(float $valor): string
    {
        return match (true) {
            $valor < 70  => 'Hipoglucemia',
            $valor < 100 => 'Normal',
            $valor < 126 => 'Prediabetes',
            default      => 'Diabetes',
        };
    }

    public static function clasificarColesterol(float $valor): string
    {
        return match (true) {
            $valor < 200 => 'Deseable',
            $valor < 240 => 'Límite alto',
            default      => 'Alto',
        };
    }

    public static function clasificarTrigliceridos(float $valor): string
    {
        return match (true) {
            $valor < 150 => 'Normal',
            $valor < 200 => 'Límite alto',
            $valor < 500 => 'Alto',
            default      => 'Muy alto',
        };
    }
}
