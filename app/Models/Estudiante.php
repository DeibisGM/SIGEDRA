<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute; // Import Attribute
use Illuminate\Database\Eloquent\Relations\HasMany; // Import HasMany

class Estudiante extends Model
{
    protected $table = 'estudiante'; // Set the correct table name
    public $timestamps = false; // Disable timestamps

    /**
     * Get the student's full name.
     */
    protected function nombreCompleto(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => // Changed string to mixed
                trim(
                    $attributes['primer_nombre'] . ' ' .
                    ($attributes['segundo_nombre'] ?? '') . ' ' .
                    $attributes['primer_apellido'] . ' ' .
                    ($attributes['segundo_apellido'] ?? '')
                )
        );
    }

    /**
     * Get the grade assignments for the student.
     */
    public function asignacionesGrado(): HasMany
    {
        return $this->hasMany(AsignacionEstudianteGrado::class, 'estudiante_id');
    }
}
