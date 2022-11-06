<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Response;

class UserController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return UserCollection
     */
    public function index(): UserCollection {
        return new UserCollection(User::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     *
     * @return UserResource
     */
    public function store(StoreUserRequest $request): UserResource {
        $user = User::create($request->validated());
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     *
     * @return UserResource
     */
    public function show(User $user): UserResource {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     *
     * @return UserResource
     */
    public function update(UpdateUserRequest $request, User $user): UserResource {
        $user->update($request->validated());
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     *
     * @return Response
     */
    public function destroy(User $user): Response {
        $user->delete();
        return response(null, 204);
    }
}
