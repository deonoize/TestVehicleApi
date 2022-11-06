<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trip>
 */
class TripFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $startTime = $this->faker->dateTimeThisYear;
        $finishTime = \DateTime::createFromFormat('U', $startTime->getTimestamp() + $this->faker->randomNumber(3) * 60);
        return [
            'comment'    => $this->faker->sentence,
            'user_id'    => User::factory()->create(),
            'vehicle_id' => Vehicle::factory()->create(),
            'start_at'   => $startTime->format('Y-m-d H:i:s'),
            'finish_at'  => $finishTime->format('Y-m-d H:i:s'),
        ];
    }
}
