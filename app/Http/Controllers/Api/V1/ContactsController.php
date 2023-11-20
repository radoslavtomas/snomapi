<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class ContactsController extends Controller
{
    /**
     * Get all contacts for authenticated user
     *
     */
    public function index()
    {

        $contacts = auth()->user()->contacts->sortBy('last_name');

        return ContactResource::collection($contacts);
    }

    /**
     * Get specific contact by id
     *
     * @param Contact $contact
     * @return ContactResource
     * @throws AuthorizationException
     */
    public function show(Contact $contact): ContactResource
    {
        $this->authorize('view', $contact);

        return new ContactResource($contact);
    }

    /**
     * Create new contact for authenticated user
     *
     * @param StoreContactRequest $request
     * @return ContactResource
     */
    public function store(StoreContactRequest $request): ContactResource
    {
        $data = $request->validated();

        $contact = auth()->user()->contacts()->create([
            'first_names' => $data['first_names'],
            'last_name' => $data['last_name'],
            'date_of_birth' => $data['date_of_birth'] ?? '',
            'email' => $data['email'] ?? '',
            'phone' => $data['phone'] ?? '',
        ]);

        return new ContactResource($contact);
    }

    /**
     * Update the contact
     *
     * @param Contact $contact
     * @param StoreContactRequest $request
     * @return ContactResource
     * @throws AuthorizationException
     */
    public function update(Contact $contact, StoreContactRequest $request): ContactResource
    {
        $this->authorize('update', $contact);

        $data = $request->validated();

        $contact->update([
            'first_names' => $data['first_names'],
            'last_name' => $data['last_name'],
            'date_of_birth' => $data['date_of_birth'] ?? '',
            'email' => $data['email'] ?? '',
            'phone' => $data['phone'] ?? '',
        ]);

        return new ContactResource($contact);
    }

    /**
     * Delete the contact
     *
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function destroy(Contact $contact): \Illuminate\Http\Response
    {
        $this->authorize('delete', $contact);

        $contact->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
