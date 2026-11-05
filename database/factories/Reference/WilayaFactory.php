<?php

namespace Database\Factories\Reference;

use App\Models\Reference\Wilaya;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Wilaya>
 */
class WilayaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $position = fake()->unique()->numberBetween(1, 999);

        return [
            'code' => str_pad((string) $position, 2, '0', STR_PAD_LEFT),
            'name' => ['fr' => fake()->city(), 'ar' => fake()->city()],
            'position' => $position,
        ];
    }
}
