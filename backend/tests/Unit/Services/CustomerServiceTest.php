<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Customer;
use App\Models\CustomerCategory;
use App\Services\CustomerService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

class CustomerServiceTest extends TestCase
{
    use RefreshDatabase;

    protected CustomerService $service;
    protected CustomerCategory $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CustomerService();
        $this->category = CustomerCategory::factory()->create();
    }

    public function test_create_customer()
    {
        $data = ['name' => 'Acme Inc', 'reference' => 'ACME123', 'customer_category_id' => $this->category->id];
        $customer = $this->service->create($data);

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertEquals('Acme Inc', $customer->name);
    }

    public function test_update_customer()
    {
        $customer = Customer::factory()->create(['name' => 'Old']);
        $updated = $this->service->update($customer, ['name' => 'New']);

        $this->assertEquals('New', $updated->name);
    }

    public function test_delete_customer()
    {
        $customer = Customer::factory()->create();
        $this->service->delete($customer);

        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
    }

    public function test_get_customers_with_search_and_contacts_count()
    {
        $customer = Customer::factory()->create([
            'name' => 'Alpha Inc',
            'reference' => 'A123',
            'customer_category_id' => $this->category->id,
        ]);
        $customer->contacts()->create(['first_name' => 'Test', 'last_name' => 'Contact', 'customer_id' => $customer->id]);

        $request = Request::create('/api/customers?search=Alpha', 'GET');
        $result = $this->service->getCustomers($request);

        $this->assertEquals(1, $result->total());
        $this->assertEquals(1, $result->items()[0]->contacts_count);
    }
}
