<?php

namespace App\Policies;

use App\Models\Maestro;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaestroPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Anyone can view the list of teachers
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Maestro $maestro): bool
    {
        return true; // Anyone can view a teacher's profile
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only non-teachers (admins) can create teachers
        return !$user->roles->contains('id', 2);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Maestro $maestro): bool
    {
        // An admin can update any profile, or a teacher can update their own
        return !$user->roles->contains('id', 2) || $user->id === $maestro->usuario_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Maestro $maestro): bool
    {
        // Only non-teachers (admins) can delete teachers
        return !$user->roles->contains('id', 2);
    }
}
