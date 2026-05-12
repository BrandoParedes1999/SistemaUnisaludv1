<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nutricion extends Model
{
    protected $table = 'nutricion';
    protected $guarded = ['id'];

    public function estiloDeVida()
    {
        return $this->belongsTo(EstiloDeVida::class, 'id_cuestionario');
    }
}
