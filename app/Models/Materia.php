<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Materia extends Model
{
    protected $table = 'materia';

    public $timestamps = false;

    protected $fillable = ['nombre', 'activo'];

    protected $casts = ['activo' => 'boolean'];

    public function cargasAcademicas(): HasMany
    {
        return $this->hasMany(CargaAcademica::class, 'materia_id');
    }
}
