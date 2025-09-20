<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Estudiante extends Model
{
    protected $table = 'estudiante';
    public $timestamps = false;

    /**
     * Define la relación para obtener los grados a los que está asignado un estudiante.
     * Se usa BelongsToMany porque la tabla 'asignacion_estudiante_grado' es una tabla pivote
     * que conecta estudiantes y grados.
     */
    public function grados(): BelongsToMany
    {
        return $this->belongsToMany(Grado::class, 'asignacion_estudiante_grado', 'estudiante_id', 'grado_id');
    }

    /**
     * Accesor para obtener el nombre completo del estudiante.
     * Esto permite usar `$estudiante->nombre_completo` en cualquier parte.
     */
    protected function nombreCompleto(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => trim(
                $attributes['primer_nombre'] . ' ' .
                ($attributes['segundo_nombre'] ?? '') . ' ' .
                $attributes['primer_apellido'] . ' ' .
                ($attributes['segundo_apellido'] ?? '')
            )
        );
    }

    /**
     * Accesor para calcular la edad del estudiante dinámicamente.
     * Esto permite usar `$estudiante->edad` y siempre estará actualizado.
     */
    protected function edad(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => Carbon::parse($attributes['fecha_nacimiento'])->age
        );
    }
}
