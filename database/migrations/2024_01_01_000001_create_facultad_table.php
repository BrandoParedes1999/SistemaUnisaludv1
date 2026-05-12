<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facultad', function (Blueprint $table) {
            $table->id('id_facultad');
            $table->string('nombre_facultad', 150);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facultad');
    }
};
