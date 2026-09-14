<?php

namespace App\Domain\Journeys\Services;

use App\Domain\Journeys\Enums\JourneyStatus;
use App\Domain\Journeys\Exceptions\InvalidJourneyTransition;
use App\Events\JourneyStatusTransitioned;
use App\Models\Journey;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class TransitionJourneyStatus
{
    public function handle(
        Journey $journey,
        User $actor,
        JourneyStatus $targetStatus,
        ?string $note = null,
    ): Journey {
        return DB::transaction(function () use ($journey, $actor, $targetStatus, $note): Journey {
            $lockedJourney = Journey::query()
                ->whereKey($journey->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            Gate::forUser($actor)->authorize('transition', $lockedJourney);

            $fromStatus = $lockedJourney->status;

            if (! $fromStatus->canTransitionTo($targetStatus)) {
                throw new InvalidJourneyTransition($fromStatus, $targetStatus);
            }

            $lockedJourney->status = $targetStatus;
            $lockedJourney->save();

            $transition = $lockedJourney->transitionHistory()->create([
                'from_status' => $fromStatus,
                'to_status' => $targetStatus,
                'actor_id' => $actor->getAuthIdentifier(),
                'note' => $note,
                'transitioned_at' => now(),
            ]);

            JourneyStatusTransitioned::dispatch($lockedJourney, $transition);

            return $lockedJourney;
        }, attempts: 3);
    }
}
