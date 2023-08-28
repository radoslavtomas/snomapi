<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Models\Contact;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddressesController extends Controller
{
    /**
     * Get all addresses for authenticated user's contact
     *
     * @throws AuthorizationException
     */
    public function index(Contact $contact)
    {
        // note: passing Contact model so it maps to ContactPolicy
        $this->authorize('viewAny', $contact);

        return AddressResource::collection($contact->addresses);
    }

    /**
     * Get specific address by id
     *
     * @param Contact $contact
     * @param Address $address
     * @return AddressResource
     * @throws AuthorizationException
     */
    public function show(Contact $contact, Address $address): AddressResource
    {
        // note: passing Address model first, so it maps to AddressPolicy
        $this->authorize('view', [$address, $contact]);

        return new AddressResource($address);
    }

    /**
     * Create new address for user's contact
     *
     * @param Contact $contact
     * @param StoreAddressRequest $request
     * @return AddressResource
     * @throws AuthorizationException
     */
    public function store(Contact $contact, StoreAddressRequest $request): AddressResource
    {
        // note: passing Contact model so it maps to ContactPolicy
        $this->authorize('create', $contact);

        $contact = $contact->addresses()->create($request->all());

        return new AddressResource($contact);
    }

    /**
     * Update the address
     *
     * @param Contact $contact
     * @param Address $address
     * @param StoreAddressRequest $request
     * @return AddressResource
     * @throws AuthorizationException
     */
    public function update(Contact $contact, Address $address, StoreAddressRequest $request): AddressResource
    {
        $this->authorize('update', [$address, $contact]);

        $address->update($request->all());

        return new AddressResource($address);
    }

    /**
     * Delete the address
     *
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function destroy(Contact $contact, Address $address): \Illuminate\Http\Response
    {
        $this->authorize('delete', [$address, $contact]);

        $address->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
