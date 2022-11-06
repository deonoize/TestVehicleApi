<?php

namespace App\Http\Controllers;

use App\Http\Resources\TripCollection;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VehicleTripController extends Controller {
    /**
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
