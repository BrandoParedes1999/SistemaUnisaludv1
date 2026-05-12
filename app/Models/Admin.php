<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'administradores';

    protected $fillable = [
        'usuario',
        'contraseña',
        'nombre_admi',
        'apellidos_admi',
        'rol',
        'foto',
    ];

    protected $hidden = [
        'contraseña',
        'remember_token',
    ];

    protected $casts = [
        'intentos_fallidos' => 'integer',
        'ultimo_intento' => 'datetime',
    ];

    // Laravel auth uses 'password' field name by default
    public function getAuthPassword(): string
    {
        return $this->contraseña;
    }

    public function getNombreCompletoAttribute(): string
    {
        return trim("{$this->nombre_admi} {$this->apellidos_admi}");
    }

    public function registrosIngresos()
    {
        return $this->hasMany(RegistroIngreso::class, 'usuario', 'usuario');
    }

    public function esBloqueado(): bool
    {
        $bloqueos = [120, 300, 1800, 3600, 86400];
        $intentos = $this->intentos_fallidos;

        if ($intentos >= count($bloqueos) * 3) {
            return true;
        }

        if ($intentos >= 3 && ($intentos % 3) === 0) {
            $indice = min((int) floor($intentos / 3) - 1, count($bloqueos) - 1);
            $tiempoEspera = $bloqueos[$indice];
            $segundosDesde = now()->diffInSeconds($this->ultimo_intento, false) * -1;
            return $segundosDesde < $tiempoEspera;
        }

        return false;
    }

    public function tiempoRestanteBoqueo(): int
    {
        $bloqueos = [120, 300, 1800, 3600, 86400];
        $intentos = $this->intentos_fallidos;
        $indice = min((int) floor($intentos / 3) - 1, count($bloqueos) - 1);
        $tiempoEspera = $bloqueos[$indice];
        $segundosDesde = now()->diffInSeconds($this->ultimo_intento, false) * -1;
        return max(0, $tiempoEspera - $segundosDesde);
    }
}
