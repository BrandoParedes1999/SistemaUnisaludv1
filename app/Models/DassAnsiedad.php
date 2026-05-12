<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DassAnsiedad extends Model
{
    protected $table = 'dass_ansiedad';
    protected $fillable = ['id_cuestionario', 'p2', 'p4', 'p7', 'p9', 'p15', 'p19', 'p20', 'total_ansiedad', 'severidad'];

    public function evaluacion()
    {
        return $this->belongsTo(DassEvaluacion::class, 'id_cuestionario');
    }
}
