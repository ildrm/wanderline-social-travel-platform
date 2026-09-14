<?php

namespace App\Policies;

use App\Models\Journey;
use App\Models\User;

class JourneyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Journey $journey): bool
    {
        return (string) $journey->owner_id === (string) $user->getAuthIdentifier();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Journey $journey): bool
    {
        return $this->view($user, $journey);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Journey $journey): bool
    {
        return $this->view($user, $journey);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function transition(User $user, Journey $journey): bool
    {
        return $this->view($user, $journey);
    }
}
