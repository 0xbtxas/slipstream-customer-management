<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Contact;

/**
 * Service class for handling business logic related to customer contacts.
 */
class ContactService
{
    /**
     * Create a new contact for the given customer.
     *
     * @param  Customer  $customer  The customer to associate the contact with.
     * @param  array     $data      Validated contact data.
     * @return Contact              The newly created contact.
     */
    public function create(Customer $customer, array $data): Contact
    {
        return $customer->contacts()->create($data);
    }

    /**
     * Update the given contact with new data.
     *
     * @param  Contact  $contact  The contact to update.
     * @param  array    $data     Validated contact data.
     * @return Contact            The updated contact.
     */
    public function update(Contact $contact, array $data): Contact
    {
        $contact->update($data);
        return $contact;
    }

    /**
     * Delete the specified contact.
     *
     * @param  Contact  $contact  The contact to delete.
     * @return void
     */
    public function delete(Contact $contact): void
    {
        $contact->delete();
    }
}
