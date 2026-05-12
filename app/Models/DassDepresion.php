<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DassDepresion extends Model
{
    protected $table = 'dass_depresion';
    protected $fillable = ['id_cuestionario', 'p3', 'p5', 'p10', 'p13', 'p16', 'p17', 'p21', 'total_depresion', 'severidad'];

    public function evaluacion()
    {
        return $this->belongsTo(DassEvaluacion::class, 'id_cuestionario');
    }
}
