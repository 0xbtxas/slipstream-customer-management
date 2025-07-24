<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Customer;
use App\Models\Contact;
use App\Services\ContactService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ContactService $service;
    protected Customer $customer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ContactService();
        $this->customer = Customer::factory()->create();
    }

    public function test_create_contact_for_customer()
    {
        $data = ['first_name' => 'John', 'last_name' => 'Doe', 'customer_id' => $this->customer->id];

        $contact = $this->service->create($this->customer, $data);

        $this->assertInstanceOf(Contact::class, $contact);
        $this->assertEquals('John', $contact->first_name);
        $this->assertEquals('Doe', $contact->last_name);
        $this->assertEquals($this->customer->id, $contact->customer_id);
    }

    public function test_update_contact()
    {
        $contact = Contact::factory()->create(['first_name' => 'Old First Name', 'last_name' => 'Doe', 'customer_id' => $this->customer->id]);
        $updated = $this->service->update($contact, ['first_name' => 'New Name']);

        $this->assertEquals('New Name', $updated->first_name);
    }

    public function test_delete_contact()
    {
        $contact = Contact::create(['first_name' => 'Old First Name', 'last_name' => 'Doe', 'customer_id' => $this->customer->id]);
        $this->service->delete($contact);

        $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
    }
}
