<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asistencia extends Model
{
    protected $table = 'asistencia';

    public $timestamps = false;

    protected $fillable = [
        'sesion_asistencia_id',
        'estudiante_id',
        'estado_asistencia_id',
        'observaciones',
    ];

    public function sesionAsistencia(): BelongsTo
    {
        return $this->belongsTo(SesionAsistencia::class, 'sesion_asistencia_id');
    }

    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function estadoAsistencia(): BelongsTo
    {
        return $this->belongsTo(EstadoAsistencia::class, 'estado_asistencia_id');
    }
}
