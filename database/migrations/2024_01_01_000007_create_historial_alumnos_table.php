<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historial_alumnos', function (Blueprint $table) {
            $table->id();
            $table->string('matricula_alum', 20);
            $table->date('fecha_historial');
            $table->boolean('sobrepeso')->default(false);
            $table->boolean('diabetes')->default(false);
            $table->boolean('hipertension')->default(false);
            $table->boolean('trigliceridos')->default(false);
            $table->boolean('colesterol')->default(false);
            $table->boolean('hepatitis')->default(false);
            $table->boolean('higado_graso')->default(false);
            $table->boolean('cardiopatias')->default(false);
            $table->boolean('nefropatias')->default(false);
            $table->boolean('cancer')->default(false);
            $table->boolean('artritis')->default(false);
            $table->boolean('asma')->default(false);
            $table->boolean('alergias')->default(false);
            $table->boolean('depresion')->default(false);
            $table->boolean('ansiedad')->default(false);
            $table->text('otras_enfermedades')->nullable();
            $table->text('medicamentos')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->foreign('matricula_alum')->references('matricula_alum')->on('alumnos')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historial_alumnos');
    }
};
