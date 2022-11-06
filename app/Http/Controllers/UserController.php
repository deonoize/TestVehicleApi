<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

class UserController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/users",
     *     tags={"Users"},
     *     summary="Get list of User",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Users"),
     *     ),
     * )
     *
     * Display a listing of the resource.
     *
     * @return UserCollection
     */
    public function index(): UserCollection {
        return new UserCollection(User::paginate());
    }

    /**
     * @OA\Post(
     *     summary="Insert a new User",
     *     tags={"Users"},
     *     path="/api/users",
     *     @OA\RequestBody(
     *         description="User to create",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Product created",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 title="data",
     *                 property="data",
     *                 type="object",
     *                 ref="#/components/schemas/User"
     *             ),
     *         ),
     *     ),
     *     @OA\Response(response=422, description="Validation exception"),
     * )
     *
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
     * @OA\Get(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Get User by id",
     *     @OA\Parameter(ref="#/components/parameters/User--id"),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 title="data",
     *                 property="data",
     *                 type="object",
     *                 ref="#/components/schemas/User"
     *             ),
     *        ),
     *     ),
     *     @OA\Response(response=404, description="User not found"),
     * )
     *
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
     * @OA\Put(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Updates a User",
     *     @OA\Parameter(ref="#/components/parameters/User--id"),
     *     @OA\RequestBody(
     *         description="User to create",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 title="data",
     *                 property="data",
     *                 type="object",
     *                 ref="#/components/schemas/User"
     *             ),
     *        ),
     *     ),
     *     @OA\Response(response=404, description="User not found"),
     *     @OA\Response(response=422, description="Validation exception"),
     * )
     *
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
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Delete a User",
     *     @OA\Parameter(ref="#/components/parameters/User--id"),
     *     @OA\Response(response=204,description="No content"),
     *     @OA\Response(response=404, description="User not found"),
     * )
     *
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
