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
        'usuario_id',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'telefono',
        'correo',
        'nacionalidad',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

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
            get: fn () => trim($this->primer_nombre . ' ' . $this->primer_apellido)
        );
    }
}
