<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_contacts()
    {
        Contact::factory()->count(3)->create();

        $response = $this->getJson('/api/contacts');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_can_create_a_contact()
    {
        $contactData = [
            'name' => 'John Doe',
            'phone' => '123-456-7890',
        ];

        $response = $this->postJson('/api/contacts', $contactData);

        $response->assertStatus(201)
            ->assertJson($contactData);

        $this->assertDatabaseHas('contacts', $contactData);
    }

    public function test_create_contact_validation_fails()
    {
        $contactData = [
            'name' => '',
            'phone' => '',
        ];

        $response = $this->postJson('/api/contacts', $contactData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'phone']);
    }

    public function test_can_delete_a_contact()
    {
        $contact = Contact::factory()->create();

        $response = $this->deleteJson('/api/contacts/' . $contact->id);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Contact deleted']);

        $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
    }

    public function test_can_not_delete_a_nonexistent_contact()
    {
        $response = $this->deleteJson('/api/contacts/999');

        $response->assertStatus(404);
    }

    public function test_create_contact_unique_phone_fails()
    {
        Contact::factory()->create(['phone' => '123-456-7890']);

        $contactData = [
            'name' => 'Jane Doe',
            'phone' => '123-456-7890',
        ];

        $response = $this->postJson('/api/contacts', $contactData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['phone']);
    }
}
