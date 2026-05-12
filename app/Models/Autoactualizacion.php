<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autoactualizacion extends Model
{
    protected $table = 'autoactualizacion';
    protected $guarded = ['id'];

    public function estiloDeVida()
    {
        return $this->belongsTo(EstiloDeVida::class, 'id_cuestionario');
    }
}
