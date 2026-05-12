<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Helper to create questionnaire detail tables
        $makeDetailTable = function (Blueprint $table, string $fkTable = 'estilo_de_vida') {
            $table->id();
            $table->foreignId('id_cuestionario')->constrained($fkTable)->cascadeOnDelete();
        };

        Schema::create('nutricion', function (Blueprint $table) use ($makeDetailTable) {
            $makeDetailTable($table);
            for ($i = 1; $i <= 35; $i++) {
                $table->unsignedTinyInteger("p{$i}")->default(0);
            }
            $table->unsignedSmallInteger('total_nutricion')->default(0);
            $table->boolean('saludable')->default(false);
            $table->timestamps();
        });

        Schema::create('ejercicio', function (Blueprint $table) use ($makeDetailTable) {
            $makeDetailTable($table);
            foreach ([4,8,11,13,15,22,30,38] as $n) {
                $table->unsignedTinyInteger("p{$n}")->default(0);
            }
            $table->unsignedSmallInteger('total_ejercicio')->default(0);
            $table->boolean('saludable_ejercicio')->default(false);
            $table->timestamps();
        });

        Schema::create('salud', function (Blueprint $table) use ($makeDetailTable) {
            $makeDetailTable($table);
            foreach ([2,7,12,17,20,23,28,32,42,46] as $n) {
                $table->unsignedTinyInteger("p{$n}")->default(0);
            }
            $table->unsignedSmallInteger('total_salud')->default(0);
            $table->boolean('saludable_salud')->default(false);
            $table->timestamps();
        });

        Schema::create('soporte_interpersonal', function (Blueprint $table) use ($makeDetailTable) {
            $makeDetailTable($table);
            foreach ([10,14,18,24,25,33,36,40,47] as $n) {
                $table->unsignedTinyInteger("p{$n}")->default(0);
            }
            $table->unsignedSmallInteger('total_soporte')->default(0);
            $table->boolean('saludable_soporte')->default(false);
            $table->timestamps();
        });

        Schema::create('manejo_de_estres', function (Blueprint $table) use ($makeDetailTable) {
            $makeDetailTable($table);
            foreach ([6,9,16,21,26,29,35,39,41,45] as $n) {
                $table->unsignedTinyInteger("p{$n}")->default(0);
            }
            $table->unsignedSmallInteger('total_manejoestres')->default(0);
            $table->boolean('saludable_manejo')->default(false);
            $table->timestamps();
        });

        Schema::create('autoactualizacion', function (Blueprint $table) use ($makeDetailTable) {
            $makeDetailTable($table);
            foreach ([3,5,19,27,31,34,37,43,44,48] as $n) {
                $table->unsignedTinyInteger("p{$n}")->default(0);
            }
            $table->unsignedSmallInteger('total_autoactualizacion')->default(0);
            $table->boolean('saludable_autoactualizacion')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('autoactualizacion');
        Schema::dropIfExists('manejo_de_estres');
        Schema::dropIfExists('soporte_interpersonal');
        Schema::dropIfExists('salud');
        Schema::dropIfExists('ejercicio');
        Schema::dropIfExists('nutricion');
    }
};
