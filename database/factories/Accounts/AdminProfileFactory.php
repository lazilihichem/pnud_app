<?php

namespace Database\Factories\Accounts;

use App\Models\Accounts\AdminProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AdminProfile>
 */
class AdminProfileFactory extends Factory
{
    /**
     * Define the model's default state: an administrator.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_super_admin' => false,
        ];
    }

    /**
     * A super administrator.
     */
    public function superAdmin(): static
    {
        return $this->state(fn (array $attributes) => ['is_super_admin' => true]);
    }
}
