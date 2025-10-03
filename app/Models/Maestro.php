<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Maestro extends Model
{
    use HasFactory;

    protected $table = 'maestro';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'usuario_id',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'telefono',
        'nacionalidad',
        'nombramiento_inicio',
        'nombramiento_final',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'nombramiento_inicio' => 'date',
        'nombramiento_final' => 'date',
    ];

    public function materias()
    {
        return $this->belongsToMany(
            Materia::class,
            'maestro_competencia',
            'maestro_id',
            'materia_id'
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function cargasAcademicas(): HasMany
    {
        return $this->hasMany(CargaAcademica::class, 'maestro_id');
    }

    protected function nombreCompleto(): Attribute
    {
        return Attribute::make(
            get: fn () => trim($this->primer_nombre.' '.$this->segundo_nombre.' '.
                $this->primer_apellido.' '.$this->segundo_apellido)
        );
    }

    protected function avatarInitials(): Attribute
    {
        return Attribute::make(
            get: fn () => mb_substr($this->primer_nombre, 0, 1).mb_substr($this->primer_apellido, 0, 1)
        );
    }
}
