<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo

class Grado extends Model
{
    protected $table = 'grado'; // Set the correct table name
    public $timestamps = false; // Disable timestamps

    /**
     * Get the academic level that owns the grade.
     */
    public function nivelAcademico(): BelongsTo
    {
        return $this->belongsTo(NivelAcademico::class, 'nivel_academico_id');
    }
}
