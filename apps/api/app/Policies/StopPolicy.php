<?php

namespace App\Policies;

use App\Models\Stop;
use App\Models\User;

class StopPolicy
{
    public function view(User $user, Stop $stop): bool
    {
        return $stop->day()
            ->whereHas('journey', fn ($query) => $query->where('owner_id', $user->getAuthIdentifier()))
            ->exists();
    }

    public function update(User $user, Stop $stop): bool
    {
        return $this->view($user, $stop);
    }
}
