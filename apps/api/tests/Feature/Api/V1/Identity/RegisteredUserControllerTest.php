<?php

namespace Tests\Feature\Api\V1\Identity;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisteredUserControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_valid_registration_creates_and_authenticates_user_with_a_rotated_session(): void
    {
        $this->withSession(['pre_auth_marker' => true]);
        $originalSessionId = session()->getId();

        $response = $this
            ->withHeaders($this->statefulHeaders())
            ->postJson('/api/v1/auth/register', [
                'name' => 'Ada Lovelace',
                'email' => '  ADA@Example.COM ',
                'password' => 'VerySecure1!',
                'password_confirmation' => 'VerySecure1!',
            ]);

        $response
            ->assertCreated()
            ->assertJsonPath('data.name', 'Ada Lovelace')
            ->assertJsonPath('data.email', 'ada@example.com')
            ->assertJsonMissingPath('data.password');

        $user = User::query()->where('email', 'ada@example.com')->firstOrFail();

        $this->assertAuthenticatedAs($user);
        $this->assertTrue(Hash::check('VerySecure1!', $user->password));
        $this->assertNotSame($originalSessionId, session()->getId());
    }

    public function test_duplicate_email_returns_422_problem_without_creating_another_user(): void
    {
        User::factory()->create(['email' => 'ada@example.com']);

        $response = $this
            ->withHeaders($this->statefulHeaders())
            ->postJson('/api/v1/auth/register', [
                'name' => 'Another Ada',
                'email' => 'ADA@EXAMPLE.COM',
                'password' => 'VerySecure1!',
                'password_confirmation' => 'VerySecure1!',
            ]);

        $response
            ->assertUnprocessable()
            ->assertHeader('Content-Type', 'application/problem+json')
            ->assertJsonValidationErrors('email')
            ->assertJsonPath('detail', 'One or more fields are invalid.');

        $this->assertDatabaseCount('users', 1);
        $this->assertGuest();
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
