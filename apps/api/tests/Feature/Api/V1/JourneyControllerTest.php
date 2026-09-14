<?php

namespace Tests\Feature\Api\V1;

use App\Domain\Journeys\Enums\JourneyMode;
use App\Domain\Journeys\Enums\JourneyStatus;
use App\Domain\Journeys\Enums\JourneyVisibility;
use App\Models\Journey;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class JourneyControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_returns_401_problem_when_authentication_is_missing(): void
    {
        $response = $this->getJson('/api/v1/journeys');

        $response
            ->assertUnauthorized()
            ->assertHeader('Content-Type', 'application/problem+json')
            ->assertHeader('WWW-Authenticate', 'Bearer')
            ->assertJsonPath('type', 'urn:problem:journeys:unauthenticated');
    }

    public function test_valid_payload_creates_draft_journey_for_authenticated_owner_and_returns_201(): void
    {
        $owner = User::factory()->create();

        $response = $this->actingAs($owner)->postJson('/api/v1/journeys', [
            'mode' => JourneyMode::Social->value,
            'title' => 'Baku to Tbilisi road trip',
            'capacity' => 4,
            'visibility' => JourneyVisibility::Private->value,
            'timezone' => 'Asia/Baku',
        ]);

        $response
            ->assertCreated()
            ->assertJsonPath('data.owner_id', $owner->id)
            ->assertJsonPath('data.status', JourneyStatus::Draft->value)
            ->assertJsonPath('data.title', 'Baku to Tbilisi road trip');

        $this->assertDatabaseHas('journeys', [
            'owner_id' => $owner->id,
            'title' => 'Baku to Tbilisi road trip',
            'status' => JourneyStatus::Draft->value,
        ]);
    }

    public function test_invalid_payload_returns_422_problem_and_does_not_create_journey(): void
    {
        $owner = User::factory()->create();

        $response = $this->actingAs($owner)->postJson('/api/v1/journeys', [
            'mode' => 'UNKNOWN',
            'title' => 'x',
            'capacity' => 0,
            'visibility' => JourneyVisibility::Private->value,
            'timezone' => 'Mars/Olympus_Mons',
        ]);

        $response
            ->assertUnprocessable()
            ->assertHeader('Content-Type', 'application/problem+json')
            ->assertJsonValidationErrors(['mode', 'title', 'capacity', 'timezone'])
            ->assertJsonPath('detail', 'One or more fields are invalid.');

        $this->assertDatabaseCount('journeys', 0);
    }

    public function test_protected_fields_return_422_and_cannot_be_mass_assigned(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $response = $this->actingAs($owner)->postJson('/api/v1/journeys', [
            'mode' => JourneyMode::Social->value,
            'title' => 'Attempted privilege escalation',
            'capacity' => 4,
            'visibility' => JourneyVisibility::Private->value,
            'timezone' => 'UTC',
            'owner_id' => $otherUser->id,
            'status' => JourneyStatus::Active->value,
        ]);

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['owner_id', 'status']);

        $this->assertDatabaseCount('journeys', 0);
    }

    public function test_list_returns_only_authenticated_owners_journeys(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $ownedJourney = Journey::factory()->for($owner, 'owner')->create();
        $otherJourney = Journey::factory()->for($otherUser, 'owner')->create();

        $response = $this->actingAs($owner)->getJson('/api/v1/journeys');

        $response
            ->assertOk()
            ->assertJsonPath('data.0.id', $ownedJourney->id)
            ->assertJsonMissing(['id' => $otherJourney->id])
            ->assertJsonCount(1, 'data');
    }

    public function test_non_owner_receives_403_when_viewing_journey(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $journey = Journey::factory()->for($owner, 'owner')->create();

        $response = $this->actingAs($otherUser)->getJson("/api/v1/journeys/{$journey->id}");

        $response
            ->assertForbidden()
            ->assertHeader('Content-Type', 'application/problem+json')
            ->assertJsonPath('detail', 'You are not authorized to perform this action.');
    }
}
