<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carrera', function (Blueprint $table) {
            $table->id('id_carrera');
            $table->string('nombre_carrera', 150);
            $table->foreignId('id_facultad')->constrained('facultad', 'id_facultad')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carrera');
    }
};
