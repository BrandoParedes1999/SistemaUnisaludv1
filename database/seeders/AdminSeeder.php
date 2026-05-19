<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::firstOrCreate(
            ['usuario' => 'admin'],
            [
                'contraseña'     => Hash::make('Admin2025!'),
                'nombre_admi'    => 'Administrador',
                'apellidos_admi' => 'General',
                'rol'            => 'admin',
            ]
        );
    }
}
