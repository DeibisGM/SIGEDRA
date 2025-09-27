<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
