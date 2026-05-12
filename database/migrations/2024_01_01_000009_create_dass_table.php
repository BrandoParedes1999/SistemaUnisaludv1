<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dass', function (Blueprint $table) {
            $table->id();
            $table->string('matricula_alum', 20);
            $table->unsignedTinyInteger('total_depresion')->default(0);
            $table->unsignedTinyInteger('total_ansiedad')->default(0);
            $table->unsignedTinyInteger('total_estres')->default(0);
            $table->unsignedTinyInteger('total_general')->default(0);
            $table->timestamps();

            $table->foreign('matricula_alum')->references('matricula_alum')->on('alumnos')->cascadeOnDelete();
            $table->index('matricula_alum');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dass');
    }
};
