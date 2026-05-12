<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registro_ingresos', function (Blueprint $table) {
            $table->id();
            $table->string('usuario', 50);
            $table->string('nombre_completo', 200);
            $table->string('rol', 50);
            $table->timestamp('fecha_ingreso')->useCurrent();
            $table->timestamp('fecha_salida')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registro_ingresos');
    }
};
