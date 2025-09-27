<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NivelAcademico extends Model
{
    protected $table = 'nivel_academico';
    public $timestamps = false;
    protected $fillable = ['nombre', 'orden'];
}
