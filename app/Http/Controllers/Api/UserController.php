<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    /**
     * Get all users
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(User::with('contacts')->paginate(15));
    }

    /**
     * Get specific user by id
     *
     * @param User $user
     * @return UserResource
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * Create new user
     *
     * @param StoreUserRequest $request
     * @return UserResource
     */
    public function store(StoreUserRequest $request): UserResource
    {
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
     */
    public function update(User $user, UpdateUserRequest $request): UserResource
    {
        $user->update($request->all());

        return new UserResource($user);
    }

    /**
     * Delete the user
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user): \Illuminate\Http\Response
    {
        $user->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
