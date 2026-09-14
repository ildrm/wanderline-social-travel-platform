<?php

namespace App\Policies;

use App\Models\TransportationLeg;
use App\Models\User;

class TransportationLegPolicy
{
    public function view(User $user, TransportationLeg $leg): bool
    {
        return $leg->journey()
            ->where('owner_id', $user->getAuthIdentifier())
            ->exists();
    }

    public function update(User $user, TransportationLeg $leg): bool
    {
        return $this->view($user, $leg);
    }
}
