<?php

namespace Tests\Feature\Api\V1;

use App\Support\Health\CheckReadiness;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class HealthControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_health_endpoint_returns_200_and_preserves_valid_correlation_id(): void
    {
        $response = $this->withHeader('X-Correlation-ID', 'client-request-123')
            ->getJson('/api/v1/health');

        $response
            ->assertOk()
            ->assertHeader('X-Correlation-ID', 'client-request-123')
            ->assertExactJson([
                'data' => ['status' => 'healthy'],
            ]);
    }

    public function test_readiness_endpoint_returns_200_when_required_services_are_available(): void
    {
        $this->mock(CheckReadiness::class)
            ->shouldReceive('handle')
            ->once()
            ->andReturn([
                'database' => 'up',
                'redis' => 'up',
                'storage' => 'up',
            ]);

        $response = $this->getJson('/api/v1/readiness');

        $response
            ->assertOk()
            ->assertJsonPath('data.status', 'ready')
            ->assertJsonPath('data.checks.database', 'up')
            ->assertJsonPath('data.checks.redis', 'up')
            ->assertJsonPath('data.checks.storage', 'up');
    }

    public function test_readiness_endpoint_returns_safe_503_problem_when_a_dependency_is_unavailable(): void
    {
        $this->mock(CheckReadiness::class)
            ->shouldReceive('handle')
            ->once()
            ->andReturn([
                'database' => 'up',
                'redis' => 'down',
                'storage' => 'up',
            ]);

        $response = $this
            ->withHeader('X-Correlation-ID', 'readiness-request-123')
            ->getJson('/api/v1/readiness');

        $response
            ->assertServiceUnavailable()
            ->assertHeader('Content-Type', 'application/problem+json')
            ->assertHeader('X-Correlation-ID', 'readiness-request-123')
            ->assertJsonPath('type', 'urn:problem:journeys:service-unavailable')
            ->assertJsonPath('correlation_id', 'readiness-request-123')
            ->assertJsonPath('checks.redis', 'down')
            ->assertJsonMissingPath('exception')
            ->assertJsonMissingPath('host')
            ->assertJsonMissingPath('password');
    }

    public function test_unknown_api_route_returns_safe_problem_json_with_correlation_id(): void
    {
        $response = $this->getJson('/api/v1/not-a-real-route');

        $response
            ->assertNotFound()
            ->assertHeader('Content-Type', 'application/problem+json')
            ->assertHeader('X-Correlation-ID')
            ->assertJsonPath('type', 'urn:problem:journeys:not-found')
            ->assertJsonPath('detail', 'Not Found.')
            ->assertJsonMissingPath('exception');
    }
}
