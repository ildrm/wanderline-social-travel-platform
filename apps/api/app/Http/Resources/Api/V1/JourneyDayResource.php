<?php

namespace App\Http\Resources\Api\V1;

use App\Models\JourneyDay;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin JourneyDay */
class JourneyDayResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getKey(),
            'position' => $this->position,
            'date' => $this->calendar_date->toDateString(),
            'timezone' => $this->timezone,
            'stops' => StopResource::collection($this->whenLoaded('stops')),
        ];
    }
}
