<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private int $paginationPerPage = 15;

    /**
     * Get all users
     *
     * @return AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function index(): AnonymousResourceCollection
    {
        $this->authorize('manage-users');

        return UserResource::collection(User::with('contacts')->paginate($this->paginationPerPage));
    }

    /**
     * Get specific user by id
     *
     * @param User $user
     * @return UserResource
     * @throws AuthorizationException
     */
    public function show(User $user): UserResource
    {
        $this->authorize('manage-users');

        return new UserResource($user);
    }

    /**
     * Create new user
     *
     * @param StoreUserRequest $request
     * @return UserResource
     * @throws AuthorizationException
     */
    public function store(StoreUserRequest $request): UserResource
    {
        $this->authorize('manage-users');

        $user = User::create([ // TODO: refactor according to real needs
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'email_verified_at' => now(),
            'password' => Hash::make($request->get('password')),
            'remember_token' => Str::random(10),
        ]);

        return new UserResource($user);
    }

    /**
     * Update the user
     *
     * @param User $user
     * @param UpdateUserRequest $request
     * @return UserResource
     * @throws AuthorizationException
     */
    public function update(User $user, UpdateUserRequest $request): UserResource
    {
        $this->authorize('manage-users');

        $user->update($request->all());

        return new UserResource($user);
    }

    /**
     * Delete the user
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function destroy(User $user): \Illuminate\Http\Response
    {
        $this->authorize('manage-users');

        $user->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}