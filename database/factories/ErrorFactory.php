<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Error>
 */
class ErrorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'project_id' => Project::first()->id,
            'code' => fake()->numberBetween(100, 527),
            'message' => fake()->sentence(),
            'path' => fake()->url(),
            'line' => fake()->numberBetween(1, 500),
            'status' => fake()->numberBetween(0, 2),
            'assigned_to' => null,
            'timestamp' => now(),
            'viewed_at' => null,
        ];
    }
}
