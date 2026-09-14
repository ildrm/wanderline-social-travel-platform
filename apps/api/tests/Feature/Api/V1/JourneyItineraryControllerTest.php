<?php

namespace Tests\Feature\Api\V1;

use App\Domain\Journeys\Enums\JourneyStatus;
use App\Domain\Journeys\Services\CreateDraftItinerary;
use App\Models\Activity;
use App\Models\Journey;
use App\Models\JourneyDay;
use App\Models\Location;
use App\Models\Stop;
use App\Models\TransportationLeg;
use App\Models\User;
use Database\Factories\JourneyGraphFactory;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Tests\TestCase;

class JourneyItineraryControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_owner_transactionally_creates_and_reads_complete_draft_itinerary(): void
    {
        $owner = User::factory()->create();
        $journey = Journey::factory()->for($owner, 'owner')->create();

        $createResponse = $this
            ->actingAs($owner)
            ->postJson("/api/v1/journeys/{$journey->id}/itinerary", JourneyGraphFactory::ankaraEuropeCircuit());

        $createResponse
            ->assertCreated()
            ->assertJsonPath('data.journey_id', $journey->id)
            ->assertJsonPath('data.days.0.stops.0.location.name', 'Ankara')
            ->assertJsonPath('data.days.1.stops.0.location.name', 'London')
            ->assertJsonPath('data.days.5.stops.0.location.name', 'Ankara')
            ->assertJsonPath('data.days.0.stops.0.location.approximate_coordinates.latitude', 39.93)
            ->assertJsonCount(6, 'data.days')
            ->assertJsonCount(5, 'data.transportation_legs');

        $this->assertTrue(Str::isUlid((string) $createResponse->json('data.days.0.id')));
        $this->assertDatabaseCount('journey_days', 6);
        $this->assertDatabaseCount('locations', 6);
        $this->assertDatabaseCount('stops', 6);
        $this->assertDatabaseCount('transportation_legs', 5);
        $this->assertDatabaseCount('activities', 4);

        $readResponse = $this
            ->actingAs($owner)
            ->getJson("/api/v1/journeys/{$journey->id}/itinerary")
            ->assertOk()
            ->assertJsonPath('data.days.2.stops.0.location.name', 'Rome')
            ->assertJsonPath('data.days.3.stops.0.location.name', 'Paris')
            ->assertJsonPath('data.days.4.stops.0.location.name', 'Madrid');

        $this->assertPayloadDoesNotContainRestrictedCoordinates($createResponse->json());
        $this->assertPayloadDoesNotContainRestrictedCoordinates($readResponse->json());
        $this->assertStringNotContainsString('39.933365', $readResponse->getContent());
    }

    public function test_unauthenticated_and_non_owner_requests_cannot_create_or_read_itinerary(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $journey = Journey::factory()->for($owner, 'owner')->create();

        $this
            ->postJson("/api/v1/journeys/{$journey->id}/itinerary", JourneyGraphFactory::ankaraEuropeCircuit())
            ->assertUnauthorized();

        $this
            ->actingAs($otherUser)
            ->postJson("/api/v1/journeys/{$journey->id}/itinerary", JourneyGraphFactory::ankaraEuropeCircuit())
            ->assertForbidden()
            ->assertHeader('Content-Type', 'application/problem+json');

        $this->assertDatabaseCount('journey_days', 0);

        app(CreateDraftItinerary::class)->handle($journey, JourneyGraphFactory::ankaraEuropeCircuit());

        $this
            ->actingAs($otherUser)
            ->getJson("/api/v1/journeys/{$journey->id}/itinerary")
            ->assertForbidden();
    }

    public function test_non_draft_or_existing_itinerary_returns_409_problem(): void
    {
        $owner = User::factory()->create();
        $nonDraft = Journey::factory()
            ->for($owner, 'owner')
            ->withStatus(JourneyStatus::Recruiting)
            ->create();

        $this
            ->actingAs($owner)
            ->postJson("/api/v1/journeys/{$nonDraft->id}/itinerary", JourneyGraphFactory::ankaraEuropeCircuit())
            ->assertConflict()
            ->assertJsonPath('type', 'urn:problem:journeys:draft-itinerary-conflict');

        $draft = Journey::factory()->for($owner, 'owner')->create();
        app(CreateDraftItinerary::class)->handle($draft, JourneyGraphFactory::ankaraEuropeCircuit());

        $this
            ->actingAs($owner)
            ->postJson("/api/v1/journeys/{$draft->id}/itinerary", JourneyGraphFactory::ankaraEuropeCircuit())
            ->assertConflict();

        $this->assertDatabaseCount('journey_days', 6);
    }

    public function test_invalid_chronology_returns_422_without_partial_graph(): void
    {
        $owner = User::factory()->create();
        $journey = Journey::factory()->for($owner, 'owner')->create();
        $payload = JourneyGraphFactory::ankaraEuropeCircuit();
        $payload['transportation_legs'][0]['arrival_at'] = '2027-05-01T08:00:00+03:00';

        $this
            ->actingAs($owner)
            ->postJson("/api/v1/journeys/{$journey->id}/itinerary", $payload)
            ->assertUnprocessable()
            ->assertJsonValidationErrors('transportation_legs.0.arrival_at');

        $this->assertDatabaseCount('journey_days', 0);
        $this->assertDatabaseCount('locations', 0);
        $this->assertDatabaseCount('stops', 0);
        $this->assertDatabaseCount('transportation_legs', 0);
    }

    public function test_persistence_failure_rolls_back_every_graph_table(): void
    {
        $journey = Journey::factory()->create();
        $payload = JourneyGraphFactory::ankaraEuropeCircuit();
        $payload['transportation_legs'][0]['mode'] = 'INVALID';

        try {
            app(CreateDraftItinerary::class)->handle($journey, $payload);
            $this->fail('The database should reject an invalid transportation mode.');
        } catch (\ValueError) {
            $this->assertDatabaseCount('journey_days', 0);
            $this->assertDatabaseCount('locations', 0);
            $this->assertDatabaseCount('stops', 0);
            $this->assertDatabaseCount('transportation_legs', 0);
            $this->assertDatabaseCount('activities', 0);
        }
    }

    public function test_every_graph_policy_is_scoped_to_the_journey_owner(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $journey = Journey::factory()->for($owner, 'owner')->create();
        app(CreateDraftItinerary::class)->handle($journey, JourneyGraphFactory::ankaraEuropeCircuit());

        $models = [
            JourneyDay::query()->firstOrFail(),
            Location::query()->firstOrFail(),
            Stop::query()->firstOrFail(),
            TransportationLeg::query()->firstOrFail(),
            Activity::query()->firstOrFail(),
        ];

        foreach ($models as $model) {
            $this->assertTrue(Gate::forUser($owner)->allows('view', $model));
            $this->assertFalse(Gate::forUser($otherUser)->allows('view', $model));
        }
    }

    private function assertPayloadDoesNotContainRestrictedCoordinates(mixed $value): void
    {
        if (! is_array($value)) {
            return;
        }

        $this->assertArrayNotHasKey('exact_coordinates', $value);
        $this->assertArrayNotHasKey('restricted_exact_coordinates', $value);
        $this->assertArrayNotHasKey('restricted_exact_latitude', $value);
        $this->assertArrayNotHasKey('restricted_exact_longitude', $value);

        foreach ($value as $nestedValue) {
            $this->assertPayloadDoesNotContainRestrictedCoordinates($nestedValue);
        }
    }
}
