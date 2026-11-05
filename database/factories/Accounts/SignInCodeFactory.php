<?php

namespace Database\Factories\Accounts;

use App\Models\Accounts\SignInCode;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<SignInCode>
 */
class SignInCodeFactory extends Factory
{
    /**
     * Define the model's default state: a delivered code « 123456 ».
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'code_hash' => Hash::make('123456'),
            'delivered_at' => now(),
            'expires_at' => now()->addMinutes(SignInCode::LifetimeMinutes),
            'failed_attempts' => 0,
        ];
    }
}
