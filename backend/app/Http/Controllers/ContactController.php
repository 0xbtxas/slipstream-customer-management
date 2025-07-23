<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\ContactResource;
use App\Services\ContactService;
use Illuminate\Http\Response;

class ContactController extends Controller
{
    public function __construct(protected ContactService $service) {}

    /**
     * Store a newly created contact for the specified customer.
     *
     * @param  StoreContactRequest  $request
     * @param  Customer             $customer
     * @return ContactResource
     */
    public function store(StoreContactRequest $request, Customer $customer): ContactResource
    {
        $contact = $this->service->create($customer, $request->validated());

        return new ContactResource($contact);
    }

    /**
     * Display the specified contact for the given customer.
     *
     * @param  Customer  $customer
     * @param  Contact   $contact
     * @return ContactResource
     */
    public function show(Customer $customer, Contact $contact): ContactResource
    {
        if ($contact->customer_id !== $customer->id) {
            abort(403, 'This contact does not belong to the specified customer.');
        }

        return new ContactResource($contact);
    }

    /**
     * Update the specified contact for the given customer.
     *
     * @param  UpdateContactRequest  $request
     * @param  Customer              $customer
     * @param  Contact               $contact
     * @return ContactResource
     */
    public function update(UpdateContactRequest $request, Customer $customer, Contact $contact): ContactResource
    {
        if ($contact->customer_id !== $customer->id) {
            abort(403, 'Contact does not belong to this customer.');
        }

        $updated = $this->service->update($contact, $request->validated());

        return new ContactResource($updated);
    }

    /**
     * Remove the specified contact from storage for the given customer.
     *
     * @param  Customer  $customer
     * @param  Contact   $contact
     * @return Response
     */
    public function destroy(Customer $customer, Contact $contact): Response
    {
        if ($contact->customer_id !== $customer->id) {
            abort(403, 'Contact does not belong to this customer.');
        }

        $this->service->delete($contact);

        return response()->noContent();
    }
}