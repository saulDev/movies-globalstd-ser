<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory{

    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'release_date' => fake()->date(),
            'is_active' => fake()->boolean(),
            'picture_file_path' => fake()->filePath(),
            'minutes_length' => fake()->numerify(),
        ];
    }
}
