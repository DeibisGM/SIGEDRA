<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'cedula',
        'email',
        'password',
        'activo',
        'requiere_cambio_contrasena',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'boolean',
            'requiere_cambio_contrasena' => 'boolean',
        ];
    }

    public function maestro(): HasOne
    {
        return $this->hasOne(Maestro::class, 'usuario_id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'usuario_roles', 'usuario_id', 'rol_id');
    }

    public function hasRole(string $roleName): bool
    {
        return $this->roles()->where('nombre', $roleName)->exists();
    }
}
