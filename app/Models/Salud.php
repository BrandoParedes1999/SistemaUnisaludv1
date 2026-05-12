<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salud extends Model
{
    protected $table = 'salud';
    protected $guarded = ['id'];

    public function estiloDeVida()
    {
        return $this->belongsTo(EstiloDeVida::class, 'id_cuestionario');
    }
}
