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

    /**
     * The table associated with the model.
     * Ya no es necesario, Laravel usará 'users' por defecto.
     * protected $table = 'usuario';
     */

    /**
     * Indicates if the model should be timestamped.
     * Ya no es necesario, la tabla 'users' tiene timestamps (created_at, updated_at).
     * public $timestamps = false;
     */

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'cedula',
        'email',
        'password',
        'activo',
        'requiere_cambio_contrasena',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the maestro record associated with the user.
     * NOTA: La clave foránea se actualizará a 'user_id' en un paso posterior.
     */
    public function maestro(): HasOne
    {
        return $this->hasOne(Maestro::class, 'user_id');
    }

    /**
     * The roles that belong to the user.
     * NOTA: La clave foránea y la tabla pivot se actualizarán en pasos posteriores.
     */
    public function roles(): BelongsToMany
    {
        // Asumiendo que existe un modelo Role
        return $this->belongsToMany(Role::class, 'usuario_roles', 'user_id', 'rol_id');
    }

    /**
     * Check if the user has a specific role.
     *
     * @param string $roleName
     * @return bool
     */
    public function hasRole(string $roleName): bool
    {
        foreach ($this->roles as $role) {
            if ($role->nombre === $roleName) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the attributes that should be cast.
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'boolean',
            'requiere_cambio_contrasena' => 'boolean',
        ];
    }
}
