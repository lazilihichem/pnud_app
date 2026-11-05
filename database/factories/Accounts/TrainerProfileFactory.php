<?php

namespace Database\Factories\Accounts;

use App\Models\Accounts\TrainerProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TrainerProfile>
 */
class TrainerProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'linkedin_url' => null,
            'education' => fake()->sentence(),
        ];
    }
}
