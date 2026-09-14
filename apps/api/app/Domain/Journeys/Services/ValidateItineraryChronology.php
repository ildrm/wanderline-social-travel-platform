<?php

namespace App\Domain\Journeys\Services;

use Carbon\CarbonImmutable;
use Illuminate\Validation\ValidationException;

class ValidateItineraryChronology
{
    /** @param array<string, mixed> $itinerary */
    public function handle(array $itinerary): void
    {
        /** @var array<string, list<string>> $errors */
        $errors = [];
        /** @var list<array<string, mixed>> $stops */
        $stops = [];
        $previousDate = null;
        $days = $itinerary['days'] ?? [];

        if (! is_array($days)) {
            return;
        }

        foreach (array_values($days) as $dayIndex => $day) {
            if (! is_array($day)) {
                continue;
            }

            $date = $this->time((string) ($day['date'] ?? ''));

            if ($date !== null && $previousDate !== null && $date->lessThanOrEqualTo($previousDate)) {
                $errors["days.{$dayIndex}.date"][] = 'Journey days must be ordered by a strictly increasing date.';
            }

            $previousDate = $date ?? $previousDate;
            $dayStops = $day['stops'] ?? [];

            if (! is_array($dayStops)) {
                continue;
            }

            foreach (array_values($dayStops) as $stopIndex => $stop) {
                if (! is_array($stop)) {
                    continue;
                }

                $stop['_path'] = "days.{$dayIndex}.stops.{$stopIndex}";
                $stops[] = $stop;
                $this->validateStop($stop, $errors);
            }
        }

        $this->validateConnectedPath($stops, $itinerary['transportation_legs'] ?? [], $errors);

        if ($errors !== []) {
            throw ValidationException::withMessages($errors);
        }
    }

    /**
     * @param  array<string, mixed>  $stop
     * @param  array<string, list<string>>  $errors
     */
    private function validateStop(array $stop, array &$errors): void
    {
        $path = (string) $stop['_path'];
        $arrival = $this->time($stop['arrival_at'] ?? null);
        $departure = $this->time($stop['departure_at'] ?? null);

        if ($arrival !== null && $departure !== null && $departure->lessThan($arrival)) {
            $errors["{$path}.departure_at"][] = 'Departure must not be earlier than arrival.';
        }

        $activities = $stop['activities'] ?? [];

        if (! is_array($activities)) {
            return;
        }

        $previousEnd = null;

        foreach (array_values($activities) as $activityIndex => $activity) {
            if (! is_array($activity)) {
                continue;
            }

            $startsAt = $this->time($activity['starts_at'] ?? null);
            $endsAt = $this->time($activity['ends_at'] ?? null);
            $activityPath = "{$path}.activities.{$activityIndex}";

            if ($startsAt === null || $endsAt === null) {
                continue;
            }

            if ($endsAt->lessThanOrEqualTo($startsAt)) {
                $errors["{$activityPath}.ends_at"][] = 'Activity end must be later than its start.';
            }

            if ($previousEnd !== null && $startsAt->lessThan($previousEnd)) {
                $errors["{$activityPath}.starts_at"][] = 'Activities at a stop must not overlap.';
            }

            if ($arrival !== null && $startsAt->lessThan($arrival)) {
                $errors["{$activityPath}.starts_at"][] = 'Activity must start after the stop arrival.';
            }

            if ($departure !== null && $endsAt->greaterThan($departure)) {
                $errors["{$activityPath}.ends_at"][] = 'Activity must end before the stop departure.';
            }

            $previousEnd = $endsAt;
        }
    }

    /**
     * @param  list<array<string, mixed>>  $stops
     * @param  array<string, list<string>>  $errors
     */
    private function validateConnectedPath(array $stops, mixed $legsValue, array &$errors): void
    {
        $legs = is_array($legsValue) ? array_values($legsValue) : [];
        $expectedLegCount = max(count($stops) - 1, 0);

        if (count($legs) !== $expectedLegCount) {
            $errors['transportation_legs'][] = 'A complete itinerary requires exactly one leg between each consecutive stop.';

            return;
        }

        foreach ($legs as $legIndex => $leg) {
            if (! is_array($leg)) {
                continue;
            }

            $origin = $stops[$legIndex];
            $destination = $stops[$legIndex + 1];
            $path = "transportation_legs.{$legIndex}";

            if (($leg['origin_stop_key'] ?? null) !== ($origin['key'] ?? null)) {
                $errors["{$path}.origin_stop_key"][] = 'Leg origin must be the preceding stop.';
            }

            if (($leg['destination_stop_key'] ?? null) !== ($destination['key'] ?? null)) {
                $errors["{$path}.destination_stop_key"][] = 'Leg destination must be the next stop.';
            }

            $originDeparture = $this->time($origin['departure_at'] ?? null);
            $destinationArrival = $this->time($destination['arrival_at'] ?? null);
            $legDeparture = $this->time($leg['departure_at'] ?? null);
            $legArrival = $this->time($leg['arrival_at'] ?? null);

            if ($originDeparture === null) {
                $errors[(string) $origin['_path'].'.departure_at'][] = 'Every non-final stop requires a departure time.';
            }

            if ($destinationArrival === null) {
                $errors[(string) $destination['_path'].'.arrival_at'][] = 'Every non-origin stop requires an arrival time.';
            }

            if ($legDeparture !== null && $legArrival !== null && $legArrival->lessThanOrEqualTo($legDeparture)) {
                $errors["{$path}.arrival_at"][] = 'Leg arrival must be later than departure.';
            }

            if ($originDeparture !== null && $legDeparture !== null && ! $originDeparture->equalTo($legDeparture)) {
                $errors["{$path}.departure_at"][] = 'Leg departure must match its origin stop departure.';
            }

            if ($destinationArrival !== null && $legArrival !== null && ! $destinationArrival->equalTo($legArrival)) {
                $errors["{$path}.arrival_at"][] = 'Leg arrival must match its destination stop arrival.';
            }
        }
    }

    private function time(mixed $value): ?CarbonImmutable
    {
        if (! is_string($value) || $value === '') {
            return null;
        }

        try {
            return CarbonImmutable::parse($value);
        } catch (\Throwable) {
            return null;
        }
    }
}
