<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Journeys\IndexJourneyRequest;
use App\Http\Requests\Api\V1\Journeys\StoreJourneyRequest;
use App\Http\Resources\Api\V1\JourneyResource;
use App\Models\Journey;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class JourneyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexJourneyRequest $request): AnonymousResourceCollection
    {
        $owner = $request->user();
        assert($owner instanceof User);

        $journeys = $owner->journeys()
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate($request->integer('per_page', 20));

        return JourneyResource::collection($journeys);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJourneyRequest $request): JsonResponse
    {
        $owner = $request->user();
        assert($owner instanceof User);

        $journey = $owner->journeys()->create(
            $request->safe()->only(['mode', 'title', 'capacity', 'visibility', 'timezone']),
        );

        return (new JourneyResource($journey))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Journey $journey): JourneyResource
    {
        Gate::authorize('view', $journey);

        return new JourneyResource($journey->load('transitionHistory'));
    }
}
