<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManejoEstres extends Model
{
    protected $table = 'manejo_de_estres';
    protected $guarded = ['id'];

    public function estiloDeVida()
    {
        return $this->belongsTo(EstiloDeVida::class, 'id_cuestionario');
    }
}
