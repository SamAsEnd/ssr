<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WebsiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'domain' => $this->faker->domainName(),
            'description' => $this->faker->paragraph,
            'onboard_message' => $this->faker->paragraph,
            'farewell_message' => $this->faker->paragraph,
        ];
    }
}
