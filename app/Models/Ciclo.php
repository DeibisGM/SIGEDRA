<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ciclo extends Model
{
    protected $table = 'ciclo';

    public $timestamps = false;

    public function tipoCiclo(): BelongsTo
    {
        return $this->belongsTo(TipoCiclo::class, 'tipo_ciclo_id');
    }
}
