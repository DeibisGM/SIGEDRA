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
            // Índice compuesto para búsquedas por nombre y apellido
            $table->index(['primer_apellido', 'segundo_apellido', 'primer_nombre']);

            // Índice compuesto para filtrar activos por fecha
            $table->index(['activo', 'fecha_nacimiento']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estudiante', function (Blueprint $table) {
            $table->dropIndex(['primer_apellido', 'segundo_apellido', 'primer_nombre']);
            $table->dropIndex(['activo', 'fecha_nacimiento']);
        });
    }
};
