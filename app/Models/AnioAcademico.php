<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AnioAcademico extends Model
{
    use HasFactory;

    protected $table = 'anio_lectivo';
    public $timestamps = false;

    protected $fillable = [
        'anio',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function grados(): HasMany
    {
        return $this->hasMany(Grado::class, 'anio_lectivo_id');
    }
}
