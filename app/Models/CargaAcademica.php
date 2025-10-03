<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CargaAcademica extends Model
{
    protected $table = 'carga_academica';

    public $timestamps = false;

    protected $fillable = ['maestro_id', 'materia_id', 'grado_id', 'activo'];

    protected $casts = ['activo' => 'boolean'];

    public function maestro(): BelongsTo
    {
        return $this->belongsTo(Maestro::class, 'maestro_id');
    }

    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function grado(): BelongsTo
    {
        return $this->belongsTo(Grado::class, 'grado_id');
    }
}
