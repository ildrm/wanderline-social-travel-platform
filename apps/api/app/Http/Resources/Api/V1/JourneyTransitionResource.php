<?php

namespace App\Http\Resources\Api\V1;

use App\Models\JourneyTransition;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin JourneyTransition */
class JourneyTransitionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getKey(),
            'from_status' => $this->from_status->value,
            'to_status' => $this->to_status->value,
            'actor_id' => $this->actor_id,
            'note' => $this->note,
            'transitioned_at' => $this->transitioned_at->toISOString(),
        ];
    }
}
