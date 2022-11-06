<?php

namespace App\Http\Controllers;

use App\Http\Requests\RentVehicleRequest;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use OpenApi\Annotations as OA;

class RentVehicleController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/vehicles/{id}/rent",
     *     tags={"Vehicles"},
     *     summary="Rent a vehicle",
     *     @OA\Parameter(ref="#/components/parameters/Vehicle--id"),
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="Id of User",
     *         required=true,
     *         example=1,
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="comment",
     *         in="query",
     *         description="Trip comment",
     *         required=false,
     *         example="Grocery shopping trip",
     *         @OA\Schema(
     *             type="string",
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 title="data",
     *                 property="data",
     *                 type="object",
     *                 ref="#/components/schemas/Trip",
     *             ),
     *        ),
     *     ),
     *     @OA\Response(response=422, description="Validation exception"),
     *     @OA\Response(response=404, description="Vehicle not found"),
     * )
     *
     * Display a listing of the resource.
     *
     * @param  Vehicle  $vehicle
     * @param  RentVehicleRequest  $request
     *
     * @return TripResource
     * @throws ValidationException
     */
    public function rent(Vehicle $vehicle, RentVehicleRequest $request): TripResource {
        $validated = $request->validated();

        $user = User::find($validated['user_id']);
        if ($vehicle->unFinishedTrips()->count() || $user->unFinishedTrips()->count())
            throw ValidationException::withMessages(['vehicle' => "Can't rent the vehicle"]);

        $trip = Trip::create([
            'comment'    => $validated['comment'] ?? '',
            'user_id'    => $user->id,
            'vehicle_id' => $vehicle->id,
            'start_at'   => Carbon::now(),
            'finish_at'  => null,
        ]);
        return new TripResource($trip);
    }

    /**
     * @OA\Get(
     *     path="/api/vehicles/{id}/release",
     *     tags={"Vehicles"},
     *     summary="Release a vehicle",
     *     @OA\Parameter(ref="#/components/parameters/Vehicle--id"),
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
     *     @OA\Response(response=422, description="Validation exception"),
     *     @OA\Response(response=404, description="Vehicle not found"),
     * )
     * Display a listing of the resource.
     *
     * @param  Vehicle  $vehicle
     *
     * @return TripResource
     * @throws ValidationException
     */
    public function release(Vehicle $vehicle): TripResource {
        if (!$vehicle->unFinishedTrips()->count())
            throw ValidationException::withMessages(['vehicle' => "The vehicle is not rented"]);

        $trip = $vehicle->unFinishedTrips()->first();
        $trip->finish_at = Carbon::now();
        $trip->save();
        return new TripResource($trip);
    }
}
