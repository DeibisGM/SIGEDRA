<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SesionAsistencia extends Model
{
    protected $table = 'sesion_asistencia';

    public $timestamps = false;

    protected $fillable = ['carga_academica_id', 'ciclo_id', 'fecha'];

    protected $casts = ['fecha' => 'date'];

    public function cargaAcademica(): BelongsTo
    {
        return $this->belongsTo(CargaAcademica::class, 'carga_academica_id');
    }

    public function asistencias(): HasMany
    {
        return $this->hasMany(Asistencia::class, 'sesion_asistencia_id');
    }
}
