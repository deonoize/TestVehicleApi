<?php

namespace App\Http\Controllers;

use App\Http\Resources\TripCollection;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserTripController extends Controller {
    /**
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
