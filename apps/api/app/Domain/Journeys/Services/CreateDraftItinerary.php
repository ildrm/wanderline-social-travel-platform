<?php

namespace App\Domain\Journeys\Services;

use App\Domain\Journeys\Enums\JourneyStatus;
use App\Domain\Journeys\Exceptions\DraftItineraryConflict;
use App\Models\Journey;
use App\Models\Location;
use App\Models\Stop;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateDraftItinerary
{
    public function __construct(
        private readonly ValidateItineraryChronology $chronology,
    ) {}

    /** @param array<string, mixed> $itinerary */
    public function handle(Journey $journey, array $itinerary): Journey
    {
        return DB::transaction(function () use ($journey, $itinerary): Journey {
            $lockedJourney = Journey::query()
                ->whereKey($journey->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedJourney->status !== JourneyStatus::Draft) {
                throw new DraftItineraryConflict('Only draft journeys can receive an itinerary.');
            }

            if ($lockedJourney->days()->exists()) {
                throw new DraftItineraryConflict('This journey already has an itinerary.');
            }

            $this->chronology->handle($itinerary);
            $stopsByKey = $this->createDaysAndStops($lockedJourney, $itinerary);
            $this->createLegs($lockedJourney, $itinerary, $stopsByKey);

            return $lockedJourney->load([
                'days.stops.location',
                'days.stops.activities',
                'transportationLegs',
            ]);
        }, 3);
    }

    /**
     * @param  array<string, mixed>  $itinerary
     * @return array<string, Stop>
     */
    private function createDaysAndStops(Journey $journey, array $itinerary): array
    {
        $stopsByKey = [];
        /** @var list<array<string, mixed>> $days */
        $days = $itinerary['days'];

        foreach ($days as $dayIndex => $dayData) {
            $day = $journey->days()->create([
                'position' => $dayIndex + 1,
                'calendar_date' => $dayData['date'],
                'timezone' => $dayData['timezone'],
            ]);

            /** @var list<array<string, mixed>> $stops */
            $stops = $dayData['stops'];

            foreach ($stops as $stopIndex => $stopData) {
                /** @var array<string, mixed> $locationData */
                $locationData = $stopData['location'];
                $location = $this->createLocation($journey, $locationData);
                $stop = $day->stops()->create([
                    'location_id' => $location->getKey(),
                    'position' => $stopIndex + 1,
                    'label' => $stopData['label'] ?? null,
                    'arrival_at' => $stopData['arrival_at'] ?? null,
                    'departure_at' => $stopData['departure_at'] ?? null,
                ]);

                /** @var list<array<string, mixed>> $activities */
                $activities = $stopData['activities'] ?? [];

                foreach ($activities as $activityIndex => $activityData) {
                    $stop->activities()->create([
                        'position' => $activityIndex + 1,
                        'title' => $activityData['title'],
                        'description' => $activityData['description'] ?? null,
                        'starts_at' => $activityData['starts_at'],
                        'ends_at' => $activityData['ends_at'],
                    ]);
                }

                $stopsByKey[(string) $stopData['key']] = $stop;
            }
        }

        return $stopsByKey;
    }

    /**
     * @param  array<string, mixed>  $itinerary
     * @param  array<string, Stop>  $stopsByKey
     */
    private function createLegs(Journey $journey, array $itinerary, array $stopsByKey): void
    {
        /** @var list<array<string, mixed>> $legs */
        $legs = $itinerary['transportation_legs'];

        foreach ($legs as $legIndex => $legData) {
            $origin = $stopsByKey[(string) $legData['origin_stop_key']];
            $destination = $stopsByKey[(string) $legData['destination_stop_key']];

            $journey->transportationLegs()->create([
                'origin_stop_id' => $origin->getKey(),
                'destination_stop_id' => $destination->getKey(),
                'position' => $legIndex + 1,
                'mode' => $legData['mode'],
                'provider' => $legData['provider'] ?? null,
                'departure_at' => $legData['departure_at'],
                'arrival_at' => $legData['arrival_at'],
            ]);
        }
    }

    /** @param array<string, mixed> $data */
    private function createLocation(Journey $journey, array $data): Location
    {
        /** @var array{latitude: float|int|string, longitude: float|int|string} $exact */
        $exact = $data['exact_coordinates'];
        $exactLatitude = (float) $exact['latitude'];
        $exactLongitude = (float) $exact['longitude'];
        $publicLatitude = round($exactLatitude, 2);
        $publicLongitude = round($exactLongitude, 2);
        $id = (string) Str::ulid();
        $timestamp = now();
        $attributes = [
            'id' => $id,
            'journey_id' => $journey->getKey(),
            'name' => $data['name'],
            'country_code' => $data['country_code'],
            'timezone' => $data['timezone'],
            'public_latitude' => $publicLatitude,
            'public_longitude' => $publicLongitude,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ];

        if (DB::getDriverName() === 'pgsql') {
            DB::insert(
                <<<'SQL'
                    INSERT INTO locations (
                        id, journey_id, name, country_code, timezone,
                        public_latitude, public_longitude,
                        public_coordinates, restricted_exact_coordinates,
                        created_at, updated_at
                    ) VALUES (
                        ?, ?, ?, ?, ?, ?, ?,
                        ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography,
                        ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography,
                        ?, ?
                    )
                    SQL,
                [
                    $id, $journey->getKey(), $data['name'], $data['country_code'], $data['timezone'],
                    $publicLatitude, $publicLongitude,
                    $publicLongitude, $publicLatitude,
                    $exactLongitude, $exactLatitude,
                    $timestamp, $timestamp,
                ],
            );
        } else {
            DB::table('locations')->insert([
                ...$attributes,
                'restricted_exact_latitude' => $exactLatitude,
                'restricted_exact_longitude' => $exactLongitude,
            ]);
        }

        return Location::query()->findOrFail($id);
    }
}
