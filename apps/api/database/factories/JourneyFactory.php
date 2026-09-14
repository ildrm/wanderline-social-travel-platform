<?php

namespace Database\Factories;

use App\Domain\Journeys\Enums\JourneyMode;
use App\Domain\Journeys\Enums\JourneyStatus;
use App\Domain\Journeys\Enums\JourneyVisibility;
use App\Models\Journey;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Journey>
 */
class JourneyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'owner_id' => User::factory(),
            'mode' => fake()->randomElement(JourneyMode::cases()),
            'title' => fake()->sentence(4),
            'status' => JourneyStatus::Draft,
            'capacity' => fake()->numberBetween(2, 40),
            'visibility' => JourneyVisibility::Private,
            'timezone' => 'UTC',
        ];
    }

    public function withStatus(JourneyStatus $status): static
    {
        return $this->state(fn (): array => ['status' => $status]);
    }
}
