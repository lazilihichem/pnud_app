<?php

namespace Database\Factories\Accounts;

use App\Enums\UserRole;
use App\Models\Accounts\TrainerProfile;
use App\Models\User;
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
            'user_id' => User::factory()->role(UserRole::Formateur),
            'linkedin_url' => null,
            'education' => fake()->sentence(),
        ];
    }
}
