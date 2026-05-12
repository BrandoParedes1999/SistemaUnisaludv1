<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estilo_de_vida', function (Blueprint $table) {
            $table->id();
            $table->string('matricula_alum', 20);
            $table->unsignedSmallInteger('total')->default(0);
            $table->date('fecha');
            $table->boolean('estado_saludable')->default(false);
            $table->timestamps();

            $table->foreign('matricula_alum')->references('matricula_alum')->on('alumnos')->cascadeOnDelete();
            $table->index('matricula_alum');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estilo_de_vida');
    }
};
