<?php

namespace App\Http\Resources\Api\V1;

use App\Models\TransportationLeg;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin TransportationLeg */
class TransportationLegResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getKey(),
            'position' => $this->position,
            'origin_stop_id' => $this->origin_stop_id,
            'destination_stop_id' => $this->destination_stop_id,
            'mode' => $this->mode->value,
            'provider' => $this->provider,
            'departure_at' => $this->departure_at->toIso8601String(),
            'arrival_at' => $this->arrival_at->toIso8601String(),
        ];
    }
}
