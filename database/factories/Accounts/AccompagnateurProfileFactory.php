<?php

namespace Database\Factories\Accounts;

use App\Enums\UserRole;
use App\Models\Accounts\AccompagnateurProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AccompagnateurProfile>
 */
class AccompagnateurProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->role(UserRole::Accompagnateur),
            'fonction' => fake()->jobTitle(),
            'capacity' => 0,
        ];
    }
}
