<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => $this->faker->userName(),
            'data' => ['input 1' => $this->faker->randomFloat(2), 'input 2' => $this->faker->randomFloat(2)],
            'bonus' => $this->faker->randomNumber(3, true),
            'ip_address' => $this->faker->ipv4(),
            'status' => $this->faker->randomElement(['pending', 'accepted', 'rejected']),
            'handler_id' => 1,
            'created_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
        ];
    }
}
