<?php

namespace Http\Controllers\Api;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RentVehicleControllerTest extends TestCase {
    use WithFaker, DatabaseTransactions;

    public function testRentAndReleaseVehicle() {
        $vehicle = Vehicle::factory()->create();
        $user = User::factory()->create();

        $this->json('get', route('vehicles.rent', [$vehicle->id]), ['user_id' => $user->id])
             ->assertCreated()
             ->assertJsonStructure(['data']);

        $this->json('get', route('vehicles.rent', [$vehicle->id]), ['user_id' => $user->id])
             ->assertUnprocessable()
             ->assertJsonStructure(['message']);

        $this->json('get', route('vehicles.release', [$vehicle->id]))
             ->assertOk()
             ->assertJsonStructure(['data']);

        $this->json('get', route('vehicles.release', [$vehicle->id]))
             ->assertUnprocessable()
             ->assertJsonStructure(['message']);;
    }

    public function testRentForMissingVehicle() {
        $user = User::factory()->create();

        $this->json('get', route('vehicles.rent', [0]), ['user_id' => $user->id])
             ->assertNotFound()
             ->assertJsonStructure(['message']);
    }

    public function testRentForMissingUser() {
        $vehicle = Vehicle::factory()->create();

        $this->json('get', route('vehicles.rent', [$vehicle]), ['user_id' => '0'])
             ->assertUnprocessable()
             ->assertJsonStructure(['message', 'errors' => ['*' => []]]);
    }

    public function testReleaseForMissingVehicle() {
        $this->json('get', route('vehicles.release', [0]))
             ->assertNotFound()
             ->assertJsonStructure(['message']);
    }

    public function testRentWithComment() {
        $vehicle = Vehicle::factory()->create();
        $user = User::factory()->create();

        $payload = [
            'user_id' => $user->id,
            'comment' => $this->faker->sentence,
        ];

        $this->json('get', route('vehicles.rent', [$vehicle->id]), $payload)
             ->assertCreated()
             ->assertJsonStructure(['data']);
    }
}
