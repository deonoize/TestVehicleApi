<?php

namespace App\Http\Controllers;

use App\Http\Resources\TripCollection;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use OpenApi\Annotations as OA;

class TripController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/trips",
     *     tags={"Trips"},
     *     summary="Get list of Trip",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Trips"),
     *     ),
     * )
     * 
     * Display a listing of the resource.
     *
     * @return TripCollection
     */
    public function index(): TripCollection {
        return new TripCollection(Trip::paginate());
    }

    /**
     * @OA\Get(
     *     path="/api/trips/{id}",
     *     tags={"Trips"},
     *     summary="Get Trip by id",
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
     *     @OA\Response(response=404, description="Trip not found"),
     * )
     * 
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
