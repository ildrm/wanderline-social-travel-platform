<?php

namespace App\Policies;

use App\Models\Activity;
use App\Models\User;

class ActivityPolicy
{
    public function view(User $user, Activity $activity): bool
    {
        return $activity->stop()
            ->whereHas('day.journey', fn ($query) => $query->where('owner_id', $user->getAuthIdentifier()))
            ->exists();
    }

    public function update(User $user, Activity $activity): bool
    {
        return $this->view($user, $activity);
    }
}
