<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private string $apiVersion = 'v1';

    /**
     * Test registration fails if email has been taken
     *
     * @return void
     */
    public function test_registration_fails_if_email_has_been_taken(): void
    {
        $user = User::factory()->create()->toArray();

        $response = $this->postJson('/api/' . $this->apiVersion . '/register', $user);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJsonStructure([
            'errors' => [
                'email'
            ],
        ]);
    }

    /**
     * Test registration fails with insecure password
     *
     * @return void
     */
    public function test_registration_fails_with_insecure_password(): void
    {
        $response = $this->postJson('/api/' . $this->apiVersion . '/register', [
            'name' => 'Valid name',
            'email' => 'valid@email.com',
            'password' => 'password',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJsonStructure([
            'errors' => [
                'password'
            ],
        ]);
    }

    /**
     * Test registration succeeds with valid data
     *
     * @return void
     */
    public function test_registration_succeeds_with_valid_data(): void
    {
        $response = $this->postJson('/api/' . $this->apiVersion . '/register', [
            'name' => 'Valid name',
            'email' => 'valid@email.com',
            'password' => 'Password123',
        ]);

        $response->assertStatus(Response::HTTP_CREATED)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email'
            ]
        ]);
    }

    /**
     * Test protected route cannot be accessed without authentication
     *
     * @return void
     */
    public function test_protected_route_cannot_be_accessed_without_authentication(): void
    {
        $response = $this->getJson('/api/' . $this->apiVersion . '/user');

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Test protected route can be accessed by authenticated user
     *
     * @return void
     */
    public function test_protected_route_can_be_accessed_by_authenticated_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/' . $this->apiVersion . '/user');

        $response->assertStatus(Response::HTTP_OK);
    }
}
