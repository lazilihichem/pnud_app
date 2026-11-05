<?php

namespace Database\Factories\Accounts;

use App\Models\Accounts\AccompagnateurProfile;
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
            'fonction' => fake()->jobTitle(),
            'capacity' => 0,
        ];
    }
}
