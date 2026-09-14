<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Journeys\Services\CreateDraftItinerary;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Journeys\StoreJourneyItineraryRequest;
use App\Http\Resources\Api\V1\JourneyItineraryResource;
use App\Models\Journey;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class JourneyItineraryController extends Controller
{
    public function store(
        StoreJourneyItineraryRequest $request,
        Journey $journey,
        CreateDraftItinerary $createDraftItinerary,
    ): JsonResponse {
        $journey = $createDraftItinerary->handle($journey, $request->validated());

        return (new JourneyItineraryResource($journey))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Journey $journey): JourneyItineraryResource
    {
        Gate::authorize('view', $journey);

        return new JourneyItineraryResource($journey->load([
            'days.stops.location',
            'days.stops.activities',
            'transportationLegs',
        ]));
    }
}
