<?php

namespace App\Http\Controllers;

use App\Http\Requests\RentVehicleRequest;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class RentVehicleController extends Controller {
    /**
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
