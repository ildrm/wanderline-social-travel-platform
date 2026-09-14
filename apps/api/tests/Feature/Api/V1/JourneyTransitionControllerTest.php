<?php

namespace Tests\Feature\Api\V1;

use App\Domain\Journeys\Enums\JourneyStatus;
use App\Models\Journey;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class JourneyTransitionControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_owner_can_make_valid_transition_and_history_is_persisted(): void
    {
        $owner = User::factory()->create();
        $journey = Journey::factory()->for($owner, 'owner')->create();

        $response = $this->actingAs($owner)->postJson("/api/v1/journeys/{$journey->id}/transitions", [
            'status' => JourneyStatus::PrivatePreview->value,
            'note' => 'Ready for invited reviewers.',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('data.status', JourneyStatus::PrivatePreview->value)
            ->assertJsonPath('data.transition_history.0.from_status', JourneyStatus::Draft->value)
            ->assertJsonPath('data.transition_history.0.to_status', JourneyStatus::PrivatePreview->value)
            ->assertJsonPath('data.transition_history.0.actor_id', $owner->id);

        $this->assertDatabaseHas('journeys', [
            'id' => $journey->id,
            'status' => JourneyStatus::PrivatePreview->value,
        ]);
        $this->assertDatabaseHas('journey_transitions', [
            'journey_id' => $journey->id,
            'from_status' => JourneyStatus::Draft->value,
            'to_status' => JourneyStatus::PrivatePreview->value,
            'actor_id' => $owner->id,
            'note' => 'Ready for invited reviewers.',
        ]);
    }

    public function test_invalid_transition_returns_409_without_changing_journey_or_history(): void
    {
        $owner = User::factory()->create();
        $journey = Journey::factory()->for($owner, 'owner')->create();

        $response = $this->actingAs($owner)->postJson("/api/v1/journeys/{$journey->id}/transitions", [
            'status' => JourneyStatus::Active->value,
        ]);

        $response
            ->assertConflict()
            ->assertHeader('Content-Type', 'application/problem+json')
            ->assertJsonPath('type', 'urn:problem:journeys:invalid-journey-transition')
            ->assertJsonPath('detail', 'A journey cannot transition from DRAFT to ACTIVE.');

        $this->assertDatabaseHas('journeys', [
            'id' => $journey->id,
            'status' => JourneyStatus::Draft->value,
        ]);
        $this->assertDatabaseCount('journey_transitions', 0);
    }

    public function test_non_owner_receives_403_and_cannot_transition_journey(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $journey = Journey::factory()->for($owner, 'owner')->create();

        $response = $this->actingAs($otherUser)->postJson("/api/v1/journeys/{$journey->id}/transitions", [
            'status' => JourneyStatus::PrivatePreview->value,
        ]);

        $response
            ->assertForbidden()
            ->assertJsonPath('type', 'urn:problem:journeys:forbidden');

        $this->assertDatabaseHas('journeys', [
            'id' => $journey->id,
            'status' => JourneyStatus::Draft->value,
        ]);
        $this->assertDatabaseCount('journey_transitions', 0);
    }

    public function test_returns_401_when_transition_authentication_is_missing(): void
    {
        $journey = Journey::factory()->create();

        $response = $this->postJson("/api/v1/journeys/{$journey->id}/transitions", [
            'status' => JourneyStatus::PrivatePreview->value,
        ]);

        $response->assertUnauthorized();
    }
}
