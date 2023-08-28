<?php

namespace App\Policies;

use App\Models\Address;
use App\Models\User;
use App\Models\Contact;

class AddressPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Contact $contact): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Address $address, Contact $contact)
    {
        return $user->id === $contact->user_id && $contact->id == $address->contact_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Address $address, Contact $contact)
    {
        return $user->id === $contact->user_id && $contact->id == $address->contact_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Address $address, Contact $contact)
    {
        return $user->id === $contact->user_id && $contact->id == $address->contact_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Address $address): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Address $address): bool
    {
        //
    }
}
