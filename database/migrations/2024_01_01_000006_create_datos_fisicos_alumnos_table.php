<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('datos_fisicos_alumnos', function (Blueprint $table) {
            $table->id();
            $table->string('matricula_alum', 20);
            $table->date('fecha');
            $table->decimal('cintura', 5, 2)->nullable();
            $table->decimal('cadera', 5, 2)->nullable();
            $table->decimal('icc', 5, 4)->nullable();
            $table->string('clasificacion_icc', 50)->nullable();
            $table->decimal('peso', 5, 2)->nullable();
            $table->decimal('talla', 5, 2)->nullable();
            $table->decimal('imc', 5, 2)->nullable();
            $table->string('clasificacion_imc', 50)->nullable();
            $table->decimal('ice', 5, 4)->nullable();
            $table->string('clasificacion_ice', 50)->nullable();
            $table->decimal('mb', 6, 2)->nullable()->comment('Metabolismo basal');
            $table->decimal('glucosa', 6, 2)->nullable();
            $table->string('clasificacion_glucosa', 50)->nullable();
            $table->decimal('trigliceridos', 6, 2)->nullable();
            $table->string('clasificacion_trigliceridos', 50)->nullable();
            $table->decimal('colesterol', 6, 2)->nullable();
            $table->string('clasificacion_colesterol', 50)->nullable();
            $table->string('tension_arterial', 20)->nullable();
            $table->string('clasificacion_ta', 50)->nullable();
            $table->decimal('porcentaje_masa_grasa', 5, 2)->nullable();
            $table->string('clasificacion_grasa', 50)->nullable();
            $table->decimal('agua_total', 5, 2)->nullable();
            $table->string('clasificacion_agua', 50)->nullable();
            $table->decimal('masa_muscular', 5, 2)->nullable();
            $table->string('clasificacion_muscular', 50)->nullable();
            $table->decimal('masa_osea', 5, 2)->nullable();
            $table->decimal('grasa_visceral', 5, 2)->nullable();
            $table->string('clasificacion_visceral', 50)->nullable();
            $table->timestamps();

            $table->foreign('matricula_alum')->references('matricula_alum')->on('alumnos')->cascadeOnDelete();
            $table->index(['matricula_alum', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('datos_fisicos_alumnos');
    }
};
