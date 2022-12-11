<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->catchPhrase(),
            'forms' => $this->faker->jobTitle(),
            'poster' => $this->faker->imageUrl(246, 157),
            'content' => $this->faker->paragraph(),
            'active' => $this->faker->boolean(),
        ];
    }
}
