<?php

namespace App\Http\Resources\Api\V1;

use App\Models\Journey;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Journey */
class JourneyResource extends JsonResource
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
            'owner_id' => $this->owner_id,
            'mode' => $this->mode->value,
            'title' => $this->title,
            'status' => $this->status->value,
            'capacity' => $this->capacity,
            'visibility' => $this->visibility->value,
            'timezone' => $this->timezone,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
            'transition_history' => JourneyTransitionResource::collection(
                $this->whenLoaded('transitionHistory'),
            ),
        ];
    }
}
