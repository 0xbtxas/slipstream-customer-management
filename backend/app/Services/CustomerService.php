<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Service class for handling business logic related to customers.
 */
class CustomerService
{
    /**
     * Get a paginated and optionally filtered list of customers.
     * Applies search on name, reference, and related category name.
     * Eager loads category and contact count.
     *
     * @param  Request  $request  The HTTP request containing filters and pagination parameters.
     * @return LengthAwarePaginator Paginated result of customers.
     */
    public function getCustomers(Request $request): LengthAwarePaginator
    {
        $query = Customer::with(['category'])->withCount('contacts')->latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('reference', 'like', "%{$search}%")
                  ->orWhereHas('category', fn($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        $perPage = $request->input('per_page', 10);

        return $query->paginate($perPage)->appends($request->query());
    }

    /**
     * Create a new customer record.
     *
     * @param  array  $data  Validated customer data.
     * @return Customer The newly created customer model.
     */
    public function create(array $data): Customer
    {
        return Customer::create($data);
    }

    /**
     * Update the given customer with new data.
     *
     * @param  Customer  $customer  The customer model to update.
     * @param  array     $data      Validated customer data.
     * @return Customer The updated customer model.
     */
    public function update(Customer $customer, array $data): Customer
    {
        $customer->update($data);
        return $customer;
    }

    /**
     * Delete the given customer.
     *
     * @param  Customer  $customer  The customer model to delete.
     * @return void
     */
    public function delete(Customer $customer): void
    {
        $customer->delete();
    }
}
