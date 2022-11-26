<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
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
            'name' => $this->faker->unique()->name(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'status' => $this->faker->boolean(),
            'login_count' => $this->faker->random_int(1, 999),
            'last_login' => $this->faker->dateTimeBetween('-1 month'),
            'last_login_ip' => $this->faker->ipv4(),
            'group_id' => 1,
            'remember_token' => Str::random(10),
        ];
    }
}
