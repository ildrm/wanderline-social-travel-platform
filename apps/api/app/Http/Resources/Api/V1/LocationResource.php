<?php

namespace App\Http\Resources\Api\V1;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Location */
class LocationResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getKey(),
            'name' => $this->name,
            'country_code' => $this->country_code,
            'timezone' => $this->timezone,
            'approximate_coordinates' => [
                'latitude' => $this->public_latitude,
                'longitude' => $this->public_longitude,
                'precision' => 'CITY',
            ],
        ];
    }
}
