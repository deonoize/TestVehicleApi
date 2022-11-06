<?php

namespace Http\Controllers\Api;

use App\Models\Vehicle;
use Tests\TestCase;

class VehicleControllerTest extends TestCase {
    public function testIndexReturnsDataInValidFormat() {
        Vehicle::factory(2)->create();
        $this->json('get', 'api/vehicles')
             ->assertOk()
             ->assertJsonStructure(
                 [
                     'data' => [
                         '*' => [
                             'id',
                             'model',
                             'number',
                             'created_at',
                             'updated_at',
                         ],
                     ],
                 ]
             );
    }

    public function testVehicleIsCreatedSuccessfully() {
        $payload = Vehicle::factory()->make()->getAttributes();
        $this->json('post', 'api/vehicles', $payload)
             ->assertCreated()
             ->assertJsonStructure(
                 [
                     'data' => [
                         'id',
                         'model',
                         'number',
                         'created_at',
                         'updated_at',
                     ],
                 ]
             );
        $this->assertDatabaseHas('vehicles', $payload);
    }

    public function testVehicleIsShownCorrectly() {
        $vehicle = Vehicle::factory()->create();
        $this->json('get', "api/vehicles/$vehicle->id")
             ->assertOk()
             ->assertExactJson(
                 [
                     'data' => [
                         'id'         => $vehicle->id,
                         'model'      => $vehicle->model,
                         'number'     => $vehicle->number,
                         'created_at' => (string) $vehicle->created_at,
                         'updated_at' => (string) $vehicle->updated_at,
                     ],
                 ]
             );
    }

    public function testVehicleIsDestroyed() {
        $data = Vehicle::factory()->make()->getAttributes();
        $vehicle = Vehicle::create($data);
        $this->json('delete', "api/vehicles/$vehicle->id")
             ->assertNoContent();
        $this->assertDatabaseMissing('vehicles', $data);
    }

    public function testUpdateVehicleReturnsCorrectData() {
        $vehicle = Vehicle::factory()->create();
        $payload = Vehicle::factory()->make()->getAttributes();
        $this->json('put', "api/vehicles/$vehicle->id", $payload)
             ->assertOk()
             ->assertExactJson(
                 [
                     'data' => [
                         'id'         => $vehicle->id,
                         'model'      => $payload['model'],
                         'number'     => $payload['number'],
                         'created_at' => (string) $vehicle->created_at,
                         'updated_at' => (string) $vehicle->refresh()->updated_at,
                     ],
                 ]
             );
    }

    public function testShowForMissingVehicle() {
        $this->json('get', "api/vehicles/0")
             ->assertNotFound()
             ->assertJsonStructure(['message']);
    }

    public function testUpdateForMissingVehicle() {
        $payload = Vehicle::factory()->make()->getAttributes();
        $this->json('put', 'api/vehicles/0', $payload)
             ->assertNotFound()
             ->assertJsonStructure(['message']);
    }

    public function testDestroyForMissingVehicle() {
        $this->json('delete', 'api/vehicles/0')
             ->assertNotFound()
             ->assertJsonStructure(['message']);
    }

    public function testStoreWithMissingData() {
        $payload = Vehicle::factory()->make()->getAttributes();
        unset($payload['number']);
        $this->json('post', 'api/vehicles', $payload)
             ->assertUnprocessable()
             ->assertJsonStructure(['message', 'errors' => ['*' => []]]);
    }
}
