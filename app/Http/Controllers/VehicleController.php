<?php

namespace App\Http\Controllers;

use App\Http\Resources\VehicleCollection;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

class VehicleController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/vehicles",
     *     tags={"Vehicles"},
     *     summary="Get list of Vehicle",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Vehicles"),
     *     ),
     * )
     *
     * Display a listing of the resource.
     *
     * @return VehicleCollection
     */
    public function index(): VehicleCollection {
        return new VehicleCollection(Vehicle::paginate());
    }

    /**
     * @OA\Post(
     *     summary="Insert a new Vehicle",
     *     tags={"Vehicles"},
     *     path="/api/vehicles",
     *     @OA\RequestBody(
     *         description="Vehicle to create",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/Vehicle")
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
     *                 ref="#/components/schemas/Vehicle"
     *             ),
     *         ),
     *     ),
     *     @OA\Response(response=422, description="Validation exception"),
     * )
     *
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVehicleRequest  $request
     *
     * @return VehicleResource
     */
    public function store(StoreVehicleRequest $request): VehicleResource {
        $vehicle = Vehicle::create($request->validated());
        return new VehicleResource($vehicle);
    }

    /**
     * @OA\Get(
     *     path="/api/vehicles/{id}",
     *     tags={"Vehicles"},
     *     summary="Get Vehicle by id",
     *     @OA\Parameter(ref="#/components/parameters/Vehicle--id"),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 title="data",
     *                 property="data",
     *                 type="object",
     *                 ref="#/components/schemas/Vehicle"
     *             ),
     *        ),
     *     ),
     *     @OA\Response(response=404, description="Vehicle not found"),
     * )
     * 
     * Display the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     *
     * @return VehicleResource
     */
    public function show(Vehicle $vehicle): VehicleResource {
        return new VehicleResource($vehicle);
    }

    /**
     * @OA\Put(
     *     path="/api/vehicles/{id}",
     *     tags={"Vehicles"},
     *     summary="Updates a Vehicle",
     *     @OA\Parameter(ref="#/components/parameters/Vehicle--id"),
     *     @OA\RequestBody(
     *         description="Vehicle to create",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/Vehicle")
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
     *                 ref="#/components/schemas/Vehicle"
     *             ),
     *        ),
     *     ),
     *     @OA\Response(response=404, description="Vehicle not found"),
     *     @OA\Response(response=422, description="Validation exception"),
     * )
     *
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVehicleRequest  $request
     * @param  \App\Models\Vehicle  $vehicle
     *
     * @return VehicleResource
     */
    public function update(UpdateVehicleRequest $request, Vehicle $vehicle): VehicleResource {
        $vehicle->update($request->validated());
        return new VehicleResource($vehicle);
    }

    /**
     * @OA\Delete(
     *     path="/api/vehicles/{id}",
     *     tags={"Vehicles"},
     *     summary="Delete a Vehicle",
     *     @OA\Parameter(ref="#/components/parameters/Vehicle--id"),
     *     @OA\Response(response=204,description="No content"),
     *     @OA\Response(response=404, description="Vehicle not found"),
     * )
     *
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehicle  $vehicle
     *
     * @return Response
     */
    public function destroy(Vehicle $vehicle): Response {
        $vehicle->delete();
        return response(null, 204);
    }
}
