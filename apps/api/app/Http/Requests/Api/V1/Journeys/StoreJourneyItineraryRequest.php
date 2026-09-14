<?php

namespace App\Http\Requests\Api\V1\Journeys;

use App\Domain\Journeys\Enums\TransportationMode;
use App\Models\Journey;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJourneyItineraryRequest extends FormRequest
{
    public function authorize(): bool
    {
        $journey = $this->route('journey');

        return $journey instanceof Journey
            && ($this->user()?->can('update', $journey) ?? false);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $timestamp = 'date_format:Y-m-d\TH:i:sP';

        return [
            'days' => ['required', 'array', 'min:1', 'max:90'],
            'days.*.date' => ['required', 'date_format:Y-m-d', 'distinct:strict'],
            'days.*.timezone' => ['required', 'string', 'timezone:all'],
            'days.*.stops' => ['required', 'array', 'min:1', 'max:50'],
            'days.*.stops.*.key' => ['required', 'string', 'max:64', 'regex:/^[a-z0-9][a-z0-9_-]*$/', 'distinct:strict'],
            'days.*.stops.*.label' => ['nullable', 'string', 'max:120'],
            'days.*.stops.*.arrival_at' => ['nullable', $timestamp],
            'days.*.stops.*.departure_at' => ['nullable', $timestamp],
            'days.*.stops.*.location' => ['required', 'array:name,country_code,timezone,exact_coordinates'],
            'days.*.stops.*.location.name' => ['required', 'string', 'max:120'],
            'days.*.stops.*.location.country_code' => ['required', 'string', 'size:2', 'regex:/^[A-Z]{2}$/'],
            'days.*.stops.*.location.timezone' => ['required', 'string', 'timezone:all'],
            'days.*.stops.*.location.exact_coordinates' => ['required', 'array:latitude,longitude'],
            'days.*.stops.*.location.exact_coordinates.latitude' => ['required', 'numeric', 'between:-90,90'],
            'days.*.stops.*.location.exact_coordinates.longitude' => ['required', 'numeric', 'between:-180,180'],
            'days.*.stops.*.activities' => ['sometimes', 'array', 'max:100'],
            'days.*.stops.*.activities.*.title' => ['required', 'string', 'max:160'],
            'days.*.stops.*.activities.*.description' => ['nullable', 'string', 'max:5000'],
            'days.*.stops.*.activities.*.starts_at' => ['required', $timestamp],
            'days.*.stops.*.activities.*.ends_at' => ['required', $timestamp],
            'transportation_legs' => ['required', 'array', 'max:4499'],
            'transportation_legs.*.origin_stop_key' => ['required', 'string', 'max:64'],
            'transportation_legs.*.destination_stop_key' => ['required', 'string', 'max:64'],
            'transportation_legs.*.mode' => ['required', Rule::enum(TransportationMode::class)],
            'transportation_legs.*.provider' => ['nullable', 'string', 'max:120'],
            'transportation_legs.*.departure_at' => ['required', $timestamp],
            'transportation_legs.*.arrival_at' => ['required', $timestamp],
            'id' => ['prohibited'],
            'journey_id' => ['prohibited'],
            'owner_id' => ['prohibited'],
        ];
    }
}
