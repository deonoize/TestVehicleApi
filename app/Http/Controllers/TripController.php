<?php

namespace App\Http\Controllers;

use App\Http\Resources\TripCollection;
use App\Http\Resources\TripResource;
use App\Models\Trip;

class TripController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return TripCollection
     */
    public function index(): TripCollection {
        return new TripCollection(Trip::paginate());
    }

    /**
     * Display the specified resource.
     *
     * @param  Trip  $trip
     *
     * @return TripResource
     */
    public function show(Trip $trip): TripResource {
        return new TripResource($trip);
    }
}
