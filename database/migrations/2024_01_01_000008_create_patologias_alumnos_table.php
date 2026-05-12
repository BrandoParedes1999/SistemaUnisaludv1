<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patologias_alumnos', function (Blueprint $table) {
            $table->id();
            $table->string('matricula_alum', 20);
            $table->string('enfermedad', 200);
            $table->text('tratamiento')->nullable();
            $table->date('fecha');
            $table->timestamps();

            $table->foreign('matricula_alum')->references('matricula_alum')->on('alumnos')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patologias_alumnos');
    }
};
