<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Grado extends Model
{
    use HasFactory;

    protected $table = 'grado';

    public $timestamps = false;

    protected $fillable = [
        'anio_lectivo_id',
        'nivel_academico_id',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function anioAcademico(): BelongsTo
    {
        return $this->belongsTo(AnioAcademico::class, 'anio_lectivo_id');
    }

    public function nivelAcademico(): BelongsTo
    {
        return $this->belongsTo(NivelAcademico::class, 'nivel_academico_id');
    }

    /**
     * Relación muchos a muchos con Estudiante
     * Un grado puede tener muchos estudiantes
     */
    public function estudiantes(): BelongsToMany
    {
        return $this->belongsToMany(
            Estudiante::class,
            'asignacion_estudiante_grado',  // Tabla pivote
            'grado_id',                      // FK de grado en la pivote
            'estudiante_id'                  // FK de estudiante en la pivote
        );
    }
}
