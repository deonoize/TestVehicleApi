<?php

namespace App\Http\Controllers;

use App\Http\Resources\VehicleCollection;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use Illuminate\Http\Response;

class VehicleController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return VehicleCollection
     */
    public function index(): VehicleCollection {
        return new VehicleCollection(Vehicle::paginate());
    }

    /**
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
