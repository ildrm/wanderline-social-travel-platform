<?php

namespace App\Http\Resources\Api\V1;

use App\Models\Journey;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Journey */
class JourneyItineraryResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'journey_id' => $this->resource->getKey(),
            'title' => $this->title,
            'status' => $this->status->value,
            'timezone' => $this->timezone,
            'days' => JourneyDayResource::collection($this->whenLoaded('days')),
            'transportation_legs' => TransportationLegResource::collection(
                $this->whenLoaded('transportationLegs'),
            ),
        ];
    }
}
