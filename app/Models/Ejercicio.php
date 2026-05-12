<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ejercicio extends Model
{
    protected $table = 'ejercicio';
    protected $guarded = ['id'];

    public function estiloDeVida()
    {
        return $this->belongsTo(EstiloDeVida::class, 'id_cuestionario');
    }
}
