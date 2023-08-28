<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ContactsController extends Controller
{
    /**
     * Get all contacts for authenticated user
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $contacts = auth()->user()->contacts;

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
        $contact = auth()->user()->contacts()->create($request->all());

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

        $contact->update($request->all());

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
