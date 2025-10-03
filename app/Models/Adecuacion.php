<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Adecuacion extends Model
{
    protected $table = 'adecuacion';

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    public $timestamps = true;

    /**
     * Estudiantes que tienen esta adecuación
     */
    public function estudiantes(): BelongsToMany
    {
        return $this->belongsToMany(Estudiante::class, 'estudiante_adecuacion')
            ->withPivot('nivel', 'fecha_asignacion', 'activo');
    }
}
