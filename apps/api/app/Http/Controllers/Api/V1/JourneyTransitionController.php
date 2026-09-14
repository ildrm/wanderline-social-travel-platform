<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Journeys\Services\TransitionJourneyStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Journeys\TransitionJourneyRequest;
use App\Http\Resources\Api\V1\JourneyResource;
use App\Models\Journey;
use App\Models\User;

class JourneyTransitionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        TransitionJourneyRequest $request,
        Journey $journey,
        TransitionJourneyStatus $transitionJourneyStatus,
    ): JourneyResource {
        $actor = $request->user();
        assert($actor instanceof User);

        $transitionedJourney = $transitionJourneyStatus->handle(
            $journey,
            $actor,
            $request->targetStatus(),
            $request->validated('note'),
        );

        return new JourneyResource($transitionedJourney->load('transitionHistory'));
    }
}
