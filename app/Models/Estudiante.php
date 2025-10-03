<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = 'estudiante';

    public $timestamps = false;

    protected $fillable = [
        'cedula',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'fecha_nacimiento',
        'direccion',
        'genero',
        'nacionalidad',
        'activo',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'activo' => 'boolean',
    ];

    /**
     * Relación para obtener los grados a los que está o ha estado asignado.
     */
    public function grados(): BelongsToMany
    {
        return $this->belongsToMany(Grado::class, 'asignacion_estudiante_grado', 'estudiante_id', 'grado_id');
    }

    // Útil para obtener solo el grado actual
    public function gradoActual()
    {
        return $this->grados()->latest('asignacion_estudiante_grado.id');
    }

    /**
     * Accesor para obtener el nombre completo del estudiante.
     */
    protected function nombreCompleto(): Attribute
    {
        return Attribute::make(
            get: fn () => trim(
                $this->primer_nombre.' '.
                ($this->segundo_nombre ? $this->segundo_nombre.' ' : '').
                $this->primer_apellido.' '.
                ($this->segundo_apellido ? $this->segundo_apellido.' ' : '')
            )
        );
    }

    /**
     * Accesor para calcular la edad del estudiante.
     */
    protected function edad(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::parse($this->fecha_nacimiento)->age
        );
    }

    /**
     * Accesor para las iniciales del avatar.
     */
    protected function avatarInitials(): Attribute
    {
        return Attribute::make(
            get: fn () => mb_substr($this->primer_nombre, 0, 1).mb_substr($this->primer_apellido, 0, 1)
        );
    }

    // Scope para estudiantes activos
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    // Scope para búsqueda por cédula
    public function scopeByCedula($query, $cedula)
    {
        return $query->where('cedula', $cedula);
    }

    // Scope para búsqueda por nombre
    public function scopeBuscar($query, $termino)
    {
        return $query->where(function ($q) use ($termino) {
            $q->where('primer_nombre', 'like', "%{$termino}%")
                ->orWhere('segundo_nombre', 'like', "%{$termino}%")
                ->orWhere('primer_apellido', 'like', "%{$termino}%")
                ->orWhere('segundo_apellido', 'like', "%{$termino}%")
                ->orWhere('cedula', 'like', "%{$termino}%");
        });
    }
}
