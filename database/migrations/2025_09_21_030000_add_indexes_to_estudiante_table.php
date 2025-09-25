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
                        
                        // Índice compuesto para búsquedas múltiples (opcional pero recomendado)
                                            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estudiante', function (Blueprint $table) {
            // No indexes were created in the up() method, so nothing to drop here.
        });
    }
};
