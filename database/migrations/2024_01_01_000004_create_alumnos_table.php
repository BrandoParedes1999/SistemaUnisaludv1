<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->string('matricula_alum', 20)->primary();
            $table->string('nombres_alum', 100);
            $table->string('ape_paterno_alum', 80);
            $table->string('ape_materno_alum', 80)->nullable();
            $table->unsignedTinyInteger('edad_alum')->nullable();
            $table->enum('sexo', ['Masculino', 'Femenino', 'Otro'])->nullable();
            $table->string('correo_alum', 150)->unique();
            $table->date('fe_nacimiento_alum')->nullable();
            $table->foreignId('id_carrera')->nullable()->constrained('carrera', 'id_carrera')->nullOnDelete();
            $table->foreignId('id_facultad')->nullable()->constrained('facultad', 'id_facultad')->nullOnDelete();
            $table->string('generacion', 20)->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->string('password', 255);
            $table->string('tipo_sangre', 5)->nullable();
            $table->string('nss', 20)->nullable();
            $table->text('enfermedades')->nullable();
            $table->string('emergencia', 200)->nullable();
            $table->string('foto', 255)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
