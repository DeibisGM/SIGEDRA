<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UsuarioRol extends Model
{
    use HasFactory;

    protected $table = 'usuario_roles';
    public $timestamps = false;

    protected $fillable = ['usuario_id', 'rol_id'];

}
