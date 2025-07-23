<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    public function __construct(protected CustomerService $service) {}

    /**
     * Display a listing of all customers with their categories and contacts.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $customers = $this->service->getCustomers($request);
        return CustomerResource::collection($customers);
    }

    /**
     * Store a newly created customer in storage.
     *
     * @param  StoreCustomerRequest  $request
     * @return CustomerResource
     */
    public function store(StoreCustomerRequest $request): CustomerResource
    {
        $customer = $this->service->create($request->validated());
        return new CustomerResource($customer->load(['category', 'contacts']));
    }

    /**
     * Display the specified customer with category and contacts.
     *
     * @param  Customer  $customer
     * @return CustomerResource
     */
    public function show(Customer $customer): CustomerResource
    {
        return new CustomerResource($customer->load(['category', 'contacts']));
    }

    /**
     * Update the specified customer in storage.
     *
     * @param  UpdateCustomerRequest  $request
     * @param  Customer               $customer
     * @return CustomerResource
     */
    public function update(UpdateCustomerRequest $request, Customer $customer): CustomerResource
    {
        $customer = $this->service->update($customer, $request->validated());
        return new CustomerResource($customer->load(['category', 'contacts']));
    }

    /**
     * Remove the specified customer from storage.
     *
     * @param  Customer  $customer
     * @return Response
     */
    public function destroy(Customer $customer): Response
    {
        $this->service->delete($customer);
        return response()->noContent();
    }
}
