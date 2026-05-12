<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('administradores', function (Blueprint $table) {
            $table->id();
            $table->string('usuario', 50)->unique();
            $table->string('contraseña', 255);
            $table->string('nombre_admi', 100);
            $table->string('apellidos_admi', 150);
            $table->string('rol', 50)->default('admin');
            $table->string('foto', 255)->nullable();
            $table->unsignedSmallInteger('intentos_fallidos')->default(0);
            $table->timestamp('ultimo_intento')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('administradores');
    }
};
