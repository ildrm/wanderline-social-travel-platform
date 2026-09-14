<?php

namespace App\Policies;

use App\Models\Location;
use App\Models\User;

class LocationPolicy
{
    public function view(User $user, Location $location): bool
    {
        return $location->journey()
            ->where('owner_id', $user->getAuthIdentifier())
            ->exists();
    }

    public function update(User $user, Location $location): bool
    {
        return $this->view($user, $location);
    }
}
