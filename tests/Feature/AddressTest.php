<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Unauthenticated user cannot view addresses
     */
    public function test_unauthenticated_user_cannot_view_addresses(): void
    {
        $response = $this->getJson('/api/contacts/1/addresses');

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Authenticated user can create address
     */
    public function test_authenticated_user_can_crete_address(): void
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->postJson('/api/contacts/' . $contact->id . '/addresses' , [
            'address_line_1' => fake()->streetAddress(),
            'address_line_4' => fake()->city(),
            'postcode' => fake()->postcode(),
            'country' => fake()->country(),
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * User cannot view other user's addresses
     */
    public function test_user_cannot_view_other_users_addresses(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $contact = Contact::factory()->create([
            'user_id' => $user1->id
        ]);

        $address = Address::factory()->create([
            'contact_id' => $contact->id
        ]);

        $response = $this->actingAs($user2)->getJson('/api/contacts/' . $contact->id . '/addresses');

        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $response = $this->actingAs($user2)->getJson('/api/contacts/' . $contact->id . '/addresses/' . $address->id);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * User cannot update other user's addresses
     */
    public function test_user_cannot_update_other_users_addresses(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $contact = Contact::factory()->create([
            'user_id' => $user1->id
        ]);

        $address = Address::factory()->create([
            'contact_id' => $contact->id
        ]);

        $response = $this->actingAs($user2)->postJson('/api/contacts/' . $contact->id . '/addresses/' . $address->id, [
            '_method' => 'PUT',
            'address_line_1' => 'Changed street 123',
            'address_line_4' => 'Invisible city',
            'postcode' => '123 45',
            'country' => 'Atlantis',
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * User can update their address
     */
    public function test_user_can_update_other_their_address(): void
    {
        $user = User::factory()->create();

        $contact = Contact::factory()->create([
            'user_id' => $user->id
        ]);

        $address = Address::factory()->create([
            'contact_id' => $contact->id
        ]);

        $response = $this->actingAs($user)->postJson('/api/contacts/' . $contact->id . '/addresses/' . $address->id, [
            '_method' => 'PUT',
            'address_line_1' => 'Changed street 123',
            'address_line_4' => 'Invisible city',
            'postcode' => '123 45',
            'country' => 'Atlantis',
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * User cannot update other user's addresses
     */
    public function test_user_cannot_delete_other_users_addresses(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $contact = Contact::factory()->create([
            'user_id' => $user1->id
        ]);

        $address = Address::factory()->create([
            'contact_id' => $contact->id
        ]);

        $response = $this->actingAs($user2)->postJson('/api/contacts/' . $contact->id . '/addresses/' . $address->id, [
            '_method' => 'DELETE',
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * User cannot update other user's addresses
     */
    public function test_user_can_delete_their_address(): void
    {
        $user = User::factory()->create();

        $contact = Contact::factory()->create([
            'user_id' => $user->id
        ]);

        $address = Address::factory()->create([
            'contact_id' => $contact->id
        ]);

        $response = $this->actingAs($user)->postJson('/api/contacts/' . $contact->id . '/addresses/' . $address->id, [
            '_method' => 'DELETE',
        ]);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
