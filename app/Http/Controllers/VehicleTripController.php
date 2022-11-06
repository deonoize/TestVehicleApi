<?php

namespace App\Http\Controllers;

use App\Http\Resources\TripCollection;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use OpenApi\Annotations as OA;

class VehicleTripController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/vehicles/{id}/trips",
     *     tags={"Vehicles"},
     *     summary="Get list of Trip by Vehicle",
     *     @OA\Parameter(ref="#/components/parameters/Vehicle--id"),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Trips"),
     *     ),
     *     @OA\Response(response=404, description="Vehicle not found"),
     * )
     * Display a listing of the resource.
     *
     * @param  Vehicle  $vehicle
     *
     * @return TripCollection
     */
    public function index(Vehicle $vehicle): TripCollection {
        $trips = Trip::whereVehicleId($vehicle->id)->paginate();
        return new TripCollection($trips);
    }

    /**
     * @OA\Get(
     *     path="/api/vehicles/{vehicle_id}/trips/{trip_id}",
     *     tags={"Vehicles"},
     *     summary="Get Trip by Vehicle and id",
     *     @OA\Parameter(ref="#/components/parameters/Vehicle--id"),
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
     *     @OA\Response(response=404, description="Trip or Vehicle not found"),
     * )
     * Display the specified resource.
     *
     * @param  Vehicle  $vehicle
     * @param  Trip  $trip
     *
     * @return TripResource
     */
    public function show(Vehicle $vehicle, Trip $trip): TripResource {
        if ($trip->vehicle_id !== $vehicle->id) {
            throw new ModelNotFoundException();
        }
        return new TripResource($trip);
    }
}
