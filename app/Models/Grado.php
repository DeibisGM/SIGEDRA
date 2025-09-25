<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grado extends Model
{
    protected $table = 'grado';
    public $timestamps = false;

    /**
     * Obtiene el Nivel Académico (ej: "Primer Grado") al que pertenece este grado.
     */
    public function nivelAcademico(): BelongsTo
    {
        return $this->belongsTo(NivelAcademico::class, 'nivel_academico_id');
    }

    /**
     * Obtiene el Año Académico (ej: "2024") al que pertenece este grado.
     */
    public function anioAcademico(): BelongsTo
    {
        return $this->belongsTo(AnioAcademico::class, 'anio_academico_id');
    }
}
