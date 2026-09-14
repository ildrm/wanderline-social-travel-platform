<?php

namespace Database\Factories;

use App\Domain\Journeys\Enums\JourneyStatus;
use App\Models\Journey;
use App\Models\JourneyTransition;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<JourneyTransition>
 */
class JourneyTransitionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'journey_id' => Journey::factory(),
            'from_status' => JourneyStatus::Draft,
            'to_status' => JourneyStatus::PrivatePreview,
            'actor_id' => User::factory(),
            'note' => null,
            'transitioned_at' => now(),
        ];
    }
}
