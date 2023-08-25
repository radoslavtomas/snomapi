<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Unauthenticated user cannot create a contact
     */
    public function test_unauthenticated_user_cannot_crete_contact(): void
    {
        $response = $this->postJson('/api/contacts', [
            'first_names' => 'Test',
            'last_name' => 'Test',
            'date_of_birth' => '05/05/1972',
            'email' => 'test@test.com',
            'phone' => '01612233445',
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Authenticated user can create a contact
     */
    public function test_authenticated_user_can_crete_contact(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/contacts', [
            'first_names' => 'Test',
            'last_name' => 'Test',
            'date_of_birth' => '05/05/1972',
            'email' => 'test@test.com',
            'phone' => '01612233445',
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * User can view their own contacts
     */
    public function test_user_can_view_their_own_contacts(): void
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->getJson('/api/contacts/' . $contact->id);

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
    * User cannot view other user's contacts
    */
    public function test_user_cannot_view_other_users_contacts(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $contact = Contact::factory()->create([
            'user_id' => $user1->id
        ]);

        $response = $this->actingAs($user2)->getJson('/api/contacts/' . $contact->id);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * User cannot update other user's contact
     */
    public function test_user_cannot_update_other_users_contact(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $contact = Contact::factory()->create([
            'user_id' => $user1->id
        ]);

        $response = $this->actingAs($user2)->postJson('/api/contacts/' . $contact->id, [
            '_method' => 'PUT',
            'first_names' => 'Test Changed',
            'last_name' => 'Test Changed',
            'date_of_birth' => '01/01/1970',
            'email' => 'test2@test.com',
            'phone' => '01612233445',
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * User cannot delete other user's contacts
     */
    public function test_user_cannot_delete_other_users_contacts(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $contact = Contact::factory()->create([
            'user_id' => $user1->id
        ]);

        $response = $this->actingAs($user2)->postJson('/api/contacts/' . $contact->id, [
            '_method' => 'DELETE'
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
