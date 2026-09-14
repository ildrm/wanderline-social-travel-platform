<?php

namespace Database\Factories;

final class JourneyGraphFactory
{
    /** @return array<string, mixed> */
    public static function ankaraEuropeCircuit(): array
    {
        return [
            'days' => [
                self::day('2027-05-01', 'Europe/Istanbul', [
                    self::stop('ankara-out', 'Ankara departure', 'Ankara', 'TR', 'Europe/Istanbul', 39.9333650, 32.8597419, null, '2027-05-01T09:00:00+03:00'),
                ]),
                self::day('2027-05-02', 'Europe/London', [
                    self::stop('london', 'London', 'London', 'GB', 'Europe/London', 51.5073510, -0.1277580, '2027-05-01T11:00:00+01:00', '2027-05-03T09:00:00+01:00', [
                        self::activity('Westminster walking tour', '2027-05-02T10:00:00+01:00', '2027-05-02T12:00:00+01:00'),
                    ]),
                ]),
                self::day('2027-05-04', 'Europe/Rome', [
                    self::stop('rome', 'Rome', 'Rome', 'IT', 'Europe/Rome', 41.9027835, 12.4963655, '2027-05-03T13:00:00+02:00', '2027-05-05T09:00:00+02:00', [
                        self::activity('Colosseum and Forum', '2027-05-04T09:30:00+02:00', '2027-05-04T12:30:00+02:00'),
                    ]),
                ]),
                self::day('2027-05-06', 'Europe/Paris', [
                    self::stop('paris', 'Paris', 'Paris', 'FR', 'Europe/Paris', 48.8566140, 2.3522219, '2027-05-05T16:00:00+02:00', '2027-05-07T10:00:00+02:00', [
                        self::activity('Seine and Left Bank', '2027-05-06T10:00:00+02:00', '2027-05-06T13:00:00+02:00'),
                    ]),
                ]),
                self::day('2027-05-08', 'Europe/Madrid', [
                    self::stop('madrid', 'Madrid', 'Madrid', 'ES', 'Europe/Madrid', 40.4167754, -3.7037902, '2027-05-07T12:30:00+02:00', '2027-05-09T15:00:00+02:00', [
                        self::activity('Prado Museum', '2027-05-08T10:00:00+02:00', '2027-05-08T13:00:00+02:00'),
                    ]),
                ]),
                self::day('2027-05-10', 'Europe/Istanbul', [
                    self::stop('ankara-home', 'Return to Ankara', 'Ankara', 'TR', 'Europe/Istanbul', 39.9333650, 32.8597419, '2027-05-09T20:00:00+03:00', null),
                ]),
            ],
            'transportation_legs' => [
                self::leg('ankara-out', 'london', 'AIR', 'Turkish Airlines', '2027-05-01T09:00:00+03:00', '2027-05-01T11:00:00+01:00'),
                self::leg('london', 'rome', 'AIR', 'British Airways', '2027-05-03T09:00:00+01:00', '2027-05-03T13:00:00+02:00'),
                self::leg('rome', 'paris', 'RAIL', 'Trenitalia / SNCF', '2027-05-05T09:00:00+02:00', '2027-05-05T16:00:00+02:00'),
                self::leg('paris', 'madrid', 'RAIL', 'SNCF / Renfe', '2027-05-07T10:00:00+02:00', '2027-05-07T12:30:00+02:00'),
                self::leg('madrid', 'ankara-home', 'AIR', 'Pegasus', '2027-05-09T15:00:00+02:00', '2027-05-09T20:00:00+03:00'),
            ],
        ];
    }

    /**
     * @param  list<array<string, mixed>>  $stops
     * @return array<string, mixed>
     */
    private static function day(string $date, string $timezone, array $stops): array
    {
        return compact('date', 'timezone', 'stops');
    }

    /**
     * @param  list<array<string, mixed>>  $activities
     * @return array<string, mixed>
     */
    private static function stop(
        string $key,
        string $label,
        string $name,
        string $countryCode,
        string $timezone,
        float $latitude,
        float $longitude,
        ?string $arrivalAt,
        ?string $departureAt,
        array $activities = [],
    ): array {
        return [
            'key' => $key,
            'label' => $label,
            'arrival_at' => $arrivalAt,
            'departure_at' => $departureAt,
            'location' => [
                'name' => $name,
                'country_code' => $countryCode,
                'timezone' => $timezone,
                'exact_coordinates' => [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                ],
            ],
            'activities' => $activities,
        ];
    }

    /** @return array<string, mixed> */
    private static function activity(string $title, string $startsAt, string $endsAt): array
    {
        return [
            'title' => $title,
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
        ];
    }

    /** @return array<string, mixed> */
    private static function leg(
        string $originStopKey,
        string $destinationStopKey,
        string $mode,
        string $provider,
        string $departureAt,
        string $arrivalAt,
    ): array {
        return [
            'origin_stop_key' => $originStopKey,
            'destination_stop_key' => $destinationStopKey,
            'mode' => $mode,
            'provider' => $provider,
            'departure_at' => $departureAt,
            'arrival_at' => $arrivalAt,
        ];
    }
}
