<?php

namespace Tests\Feature\Api\V1\Identity;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticatedSessionControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_valid_credentials_authenticate_user_and_rotate_the_session(): void
    {
        $user = User::factory()->create([
            'email' => 'traveller@example.com',
            'password' => Hash::make('VerySecure1!'),
        ]);
        $this->withSession(['pre_auth_marker' => true]);
        $originalSessionId = session()->getId();

        $response = $this
            ->withHeaders($this->statefulHeaders())
            ->postJson('/api/v1/auth/login', [
                'email' => ' TRAVELLER@EXAMPLE.COM ',
                'password' => 'VerySecure1!',
            ]);

        $response
            ->assertOk()
            ->assertJsonPath('data.id', $user->id)
            ->assertJsonPath('data.email', 'traveller@example.com')
            ->assertJsonMissingPath('data.password');

        $this->assertAuthenticatedAs($user);
        $this->assertNotSame($originalSessionId, session()->getId());

        $this
            ->withHeaders($this->statefulHeaders())
            ->getJson('/api/v1/auth/user')
            ->assertOk()
            ->assertJsonPath('data.id', $user->id);
    }

    public function test_invalid_credentials_return_generic_422_problem_and_leave_user_unauthenticated(): void
    {
        User::factory()->create([
            'email' => 'traveller@example.com',
            'password' => Hash::make('VerySecure1!'),
        ]);

        $response = $this
            ->withHeaders($this->statefulHeaders())
            ->postJson('/api/v1/auth/login', [
                'email' => 'traveller@example.com',
                'password' => 'Incorrect1!',
            ]);

        $response
            ->assertUnprocessable()
            ->assertHeader('Content-Type', 'application/problem+json')
            ->assertJsonPath('errors.email.0', 'The provided credentials are incorrect.');

        $this->assertGuest();
    }

    public function test_authenticated_user_can_logout_and_session_cannot_be_reused(): void
    {
        $user = User::factory()->create([
            'email' => 'traveller@example.com',
            'password' => Hash::make('VerySecure1!'),
        ]);

        $this
            ->withHeaders($this->statefulHeaders())
            ->postJson('/api/v1/auth/login', [
                'email' => 'traveller@example.com',
                'password' => 'VerySecure1!',
            ])
            ->assertOk();

        $this
            ->withHeaders($this->statefulHeaders())
            ->postJson('/api/v1/auth/logout')
            ->assertNoContent();

        $this->assertGuest('web');
        Auth::forgetGuards();

        $this
            ->withHeaders($this->statefulHeaders())
            ->getJson('/api/v1/auth/user')
            ->assertUnauthorized();
    }

    public function test_login_is_throttled_by_normalized_email_and_ip(): void
    {
        User::factory()->create([
            'email' => 'traveller@example.com',
            'password' => Hash::make('VerySecure1!'),
        ]);

        for ($attempt = 1; $attempt <= 5; $attempt++) {
            $this
                ->withHeaders($this->statefulHeaders())
                ->postJson('/api/v1/auth/login', [
                    'email' => 'TRAVELLER@example.com',
                    'password' => 'Incorrect1!',
                ])
                ->assertUnprocessable();
        }

        $this
            ->withHeaders($this->statefulHeaders())
            ->postJson('/api/v1/auth/login', [
                'email' => 'traveller@example.com',
                'password' => 'Incorrect1!',
            ])
            ->assertTooManyRequests()
            ->assertHeader('Content-Type', 'application/problem+json')
            ->assertHeader('Retry-After')
            ->assertJsonPath('status', 429);
    }

    /** @return array<string, string> */
    private function statefulHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Origin' => 'http://localhost:3000',
            'Referer' => 'http://localhost:3000/',
        ];
    }
}
