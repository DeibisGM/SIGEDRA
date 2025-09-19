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
     * @var string
     */
    protected $table = 'usuario';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'cedula',
        'contrasena',
        'requiere_cambio_contrasena',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * @var array<int, string>
     */
    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    /**
     * Get the name of the password attribute for authentication.
     * @return string
     */
    public function getAuthPasswordName()
    {
        return 'contrasena';
    }

    /**
     * Get the maestro record associated with the user.
     */
    public function maestro(): HasOne
    {
        return $this->hasOne(Maestro::class, 'usuario_id');
    }

    /**
     * The roles that belong to the user.
     */
    public function roles(): BelongsToMany
    {
        // Assuming a Role model exists or will be created.
        return $this->belongsToMany(Role::class, 'usuario_roles', 'usuario_id', 'rol_id');
    }

    /**
     * Get the attributes that should be cast.
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'contrasena' => 'hashed',
            'requiere_cambio_contrasena' => 'boolean',
        ];
    }
}
