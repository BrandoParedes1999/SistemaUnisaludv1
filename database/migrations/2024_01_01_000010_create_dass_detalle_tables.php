<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dass_depresion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_cuestionario')->constrained('dass')->cascadeOnDelete();
            // Preguntas de depresión: 3,5,10,13,16,17,21
            $table->unsignedTinyInteger('p3')->default(0);
            $table->unsignedTinyInteger('p5')->default(0);
            $table->unsignedTinyInteger('p10')->default(0);
            $table->unsignedTinyInteger('p13')->default(0);
            $table->unsignedTinyInteger('p16')->default(0);
            $table->unsignedTinyInteger('p17')->default(0);
            $table->unsignedTinyInteger('p21')->default(0);
            $table->unsignedTinyInteger('total_depresion')->default(0);
            $table->string('severidad', 30)->nullable();
            $table->timestamps();
        });

        Schema::create('dass_ansiedad', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_cuestionario')->constrained('dass')->cascadeOnDelete();
            // Preguntas de ansiedad: 2,4,7,9,15,19,20
            $table->unsignedTinyInteger('p2')->default(0);
            $table->unsignedTinyInteger('p4')->default(0);
            $table->unsignedTinyInteger('p7')->default(0);
            $table->unsignedTinyInteger('p9')->default(0);
            $table->unsignedTinyInteger('p15')->default(0);
            $table->unsignedTinyInteger('p19')->default(0);
            $table->unsignedTinyInteger('p20')->default(0);
            $table->unsignedTinyInteger('total_ansiedad')->default(0);
            $table->string('severidad', 30)->nullable();
            $table->timestamps();
        });

        Schema::create('dass_estres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_cuestionario')->constrained('dass')->cascadeOnDelete();
            // Preguntas de estrés: 1,6,8,11,12,14,18
            $table->unsignedTinyInteger('p1')->default(0);
            $table->unsignedTinyInteger('p6')->default(0);
            $table->unsignedTinyInteger('p8')->default(0);
            $table->unsignedTinyInteger('p11')->default(0);
            $table->unsignedTinyInteger('p12')->default(0);
            $table->unsignedTinyInteger('p14')->default(0);
            $table->unsignedTinyInteger('p18')->default(0);
            $table->unsignedTinyInteger('total_estres')->default(0);
            $table->string('severidad', 30)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dass_estres');
        Schema::dropIfExists('dass_ansiedad');
        Schema::dropIfExists('dass_depresion');
    }
};
