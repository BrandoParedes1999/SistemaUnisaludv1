<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroIngreso extends Model
{
    protected $table = 'registro_ingresos';
    public $timestamps = false;

    protected $fillable = [
        'usuario',
        'nombre_completo',
        'rol',
        'fecha_ingreso',
        'fecha_salida',
    ];

    protected $casts = [
        'fecha_ingreso' => 'datetime',
        'fecha_salida' => 'datetime',
    ];
}
