<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
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
     */
    public function show(Contact $contact): ContactResource
    {
        if (auth()->user()->cannot('view', $contact)) {
            abort(Response::HTTP_FORBIDDEN);
        }

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
     */
    public function update(Contact $contact, StoreContactRequest $request): ContactResource
    {
        if (auth()->user()->cannot('update', $contact)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $contact->update($request->all());

        return new ContactResource($contact);
    }

    /**
     * Delete the contact
     *
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact): \Illuminate\Http\Response
    {
        if (auth()->user()->cannot('delete', $contact)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $contact->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
