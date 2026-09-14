<?php

namespace App\Policies;

use App\Models\JourneyDay;
use App\Models\User;

class JourneyDayPolicy
{
    public function view(User $user, JourneyDay $day): bool
    {
        return $day->journey()
            ->where('owner_id', $user->getAuthIdentifier())
            ->exists();
    }

    public function update(User $user, JourneyDay $day): bool
    {
        return $this->view($user, $day);
    }
}
