<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoporteInterpersonal extends Model
{
    protected $table = 'soporte_interpersonal';
    protected $guarded = ['id'];

    public function estiloDeVida()
    {
        return $this->belongsTo(EstiloDeVida::class, 'id_cuestionario');
    }
}
