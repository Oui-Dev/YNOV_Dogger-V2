<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = fake()->unique()->company();

        return [
            'name' => $name,
            'key' =>  bin2hex(random_bytes(16)) . '/' . Str::slug($name),
            'organization_id' => Organization::first()->id,
        ];
    }
}
