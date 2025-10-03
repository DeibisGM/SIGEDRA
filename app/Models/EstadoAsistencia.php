<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoAsistencia extends Model
{
    protected $table = 'estado_asistencia';

    public $timestamps = false;

    protected $fillable = ['nombre'];
}
