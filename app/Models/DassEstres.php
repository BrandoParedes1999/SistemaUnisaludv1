<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DassEstres extends Model
{
    protected $table = 'dass_estres';
    protected $fillable = ['id_cuestionario', 'p1', 'p6', 'p8', 'p11', 'p12', 'p14', 'p18', 'total_estres', 'severidad'];

    public function evaluacion()
    {
        return $this->belongsTo(DassEvaluacion::class, 'id_cuestionario');
    }
}
