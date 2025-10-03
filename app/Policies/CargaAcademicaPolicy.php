<?php

namespace App\Policies;

use App\Models\CargaAcademica;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CargaAcademicaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CargaAcademica  $cargaAcademica
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, CargaAcademica $cargaAcademica)
    {
        if ($user->hasRole('Maestro')) {
            return $user->maestro->id === $cargaAcademica->maestro_id;
        }

        // Admins or other roles can view any academic load.
        return $user->hasRole(['Admin', 'Coordinador']);
    }
}
