<?php

namespace App\Http\Resources\Api\V1;

use App\Models\Stop;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Stop */
class StopResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getKey(),
            'position' => $this->position,
            'label' => $this->label,
            'arrival_at' => $this->arrival_at?->toIso8601String(),
            'departure_at' => $this->departure_at?->toIso8601String(),
            'location' => new LocationResource($this->whenLoaded('location')),
            'activities' => ActivityResource::collection($this->whenLoaded('activities')),
        ];
    }
}
