<?php

namespace Tests\Feature\Api\V1\Identity;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class CurrentUserControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_authenticated_request_returns_only_safe_user_fields(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->getJson('/api/v1/auth/user');

        $response
            ->assertOk()
            ->assertJsonPath('data.id', $user->id)
            ->assertJsonPath('data.email', $user->email)
            ->assertJsonMissingPath('data.password')
            ->assertJsonMissingPath('data.remember_token');
    }

    public function test_unauthenticated_current_user_and_logout_requests_return_401_problems(): void
    {
        $this
            ->getJson('/api/v1/auth/user')
            ->assertUnauthorized()
            ->assertHeader('Content-Type', 'application/problem+json')
            ->assertJsonPath('type', 'urn:problem:journeys:unauthenticated');

        $this
            ->postJson('/api/v1/auth/logout')
            ->assertUnauthorized()
            ->assertHeader('Content-Type', 'application/problem+json')
            ->assertJsonPath('type', 'urn:problem:journeys:unauthenticated');
    }
}
