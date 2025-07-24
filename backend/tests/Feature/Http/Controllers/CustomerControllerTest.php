<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\Customer;
use App\Models\CustomerCategory;
use App\Http\Resources\CustomerResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_paginated_customers()
    {
        Customer::factory()->count(15)->create();

        $response = $this->getJson('/api/customers?per_page=10');

        $response->assertOk()
                 ->assertJsonStructure(['data', 'links', 'meta']);
        $this->assertCount(10, $response->json('data'));
    }

    public function test_show_returns_customer_with_relationships()
    {
        $customer = Customer::factory()->hasContacts(2)->create();

        $response = $this->getJson("/api/customers/{$customer->id}");

        $response->assertOk()
                 ->assertJsonPath('data.id', $customer->id);
        $response->assertExactJson(CustomerResource::make($customer->fresh()->load(['category', 'contacts']))->response()->getData(true));
    }

    public function test_store_validates_and_creates_customer()
    {
        $category = CustomerCategory::factory()->create();
        $payload = ['name' => 'Beta Ltd', 'reference' => 'B123', 'customer_category_id' => $category->id, 'start_date' => now()];

        $response = $this->postJson('/api/customers', $payload);

        $response->assertCreated()
                 ->assertJsonPath('data.name', 'Beta Ltd');

        $this->assertDatabaseHas('customers', ['reference' => 'B123']);
    }
}
