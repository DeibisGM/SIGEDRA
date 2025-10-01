<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('estudiante', function (Blueprint $table) {
            // Índice para cédula (búsquedas frecuentes)
            $table->index('cedula');

            // Índice para fecha de nacimiento (cálculo de edad)
            $table->index('fecha_nacimiento');

            // Índice para estudiantes activos
            $table->index('activo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estudiante', function (Blueprint $table) {
            $table->dropIndex(['cedula']);
            $table->dropIndex(['fecha_nacimiento']);
            $table->dropIndex(['activo']);
        });
    }
};
