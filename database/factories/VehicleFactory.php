<?php

namespace Database\Factories;

use Faker\Provider\Fakecar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() {
        $this->faker->addProvider(new Fakecar($this->faker));
        return [
            'model'  => $this->faker->vehicle,
            'number' => $this->faker->unique()->vehicleRegistration,
        ];
    }
}
