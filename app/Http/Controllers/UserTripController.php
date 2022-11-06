<?php

namespace App\Http\Controllers;

use App\Http\Resources\TripCollection;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use OpenApi\Annotations as OA;

class UserTripController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/users/{id}/trips",
     *     tags={"Users"},
     *     summary="Get list of Trip by User",
     *     @OA\Parameter(ref="#/components/parameters/User--id"),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Trips"),
     *     ),
     *     @OA\Response(response=404, description="User not found"),
     * )
     *
     * Display a listing of the resource.
     *
     * @param  User  $user
     *
     * @return TripCollection
     */
    public function index(User $user): TripCollection {
        $trips = Trip::whereUserId($user->id)->paginate();
        return new TripCollection($trips);
    }

    /**
     * @OA\Get(
     *     path="/api/users/{user_id}/trips/{trip_id}",
     *     tags={"Users"},
     *     summary="Get Trip by User and id",
     *     @OA\Parameter(ref="#/components/parameters/User--id"),
     *     @OA\Parameter(ref="#/components/parameters/Trip--id"),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 title="data",
     *                 property="data",
     *                 type="object",
     *                 ref="#/components/schemas/Trip"
     *             ),
     *        ),
     *     ),
     *     @OA\Response(response=404, description="Trip or User not found"),
     * )
     *
     * Display the specified resource.
     *
     * @param  User  $user
     * @param  Trip  $trip
     *
     * @return TripResource
     */
    public function show(User $user, Trip $trip): TripResource {
        if ($trip->user_id !== $user->id) {
            throw new ModelNotFoundException();
        }
        return new TripResource($trip);
    }
}
