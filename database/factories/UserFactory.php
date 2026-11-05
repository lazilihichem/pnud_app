<?php

namespace Database\Factories;

use App\Enums\AccountStatus;
use App\Enums\Locale;
use App\Enums\ProfileType;
use App\Models\Accounts\AdminProfile;
use App\Models\Accounts\EntrepreneurProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'profilable_type' => ProfileType::Entrepreneur->value,
            'profilable_id' => EntrepreneurProfile::factory(),
            'status' => AccountStatus::Active,
            'locale' => Locale::French,
            'terms_version' => config('accounts.terms_version'),
            'terms_accepted_at' => now(),
            'remember_token' => Str::random(10),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the model has two-factor authentication configured.
     */
    public function withTwoFactor(): static
    {
        return $this->state(fn (array $attributes) => [
            'two_factor_secret' => encrypt('secret'),
            'two_factor_recovery_codes' => encrypt(json_encode(['recovery-code-1'])),
            'two_factor_confirmed_at' => now(),
        ]);
    }

    /**
     * Give the account the given profile (a fresh profile row) and its initial status.
     *
     * @param  array<string, mixed>  $profileAttributes
     */
    public function profile(ProfileType $type, array $profileAttributes = []): static
    {
        return $this->state(fn (array $attributes) => [
            'profilable_type' => $type->value,
            'profilable_id' => $type->modelClass()::factory()->state($profileAttributes),
            'status' => $type->initialStatus(),
        ]);
    }

    /**
     * An active administrator, or super administrator.
     */
    public function admin(bool $super = false): static
    {
        return $this->state(fn (array $attributes) => [
            'profilable_type' => ProfileType::Admin->value,
            'profilable_id' => AdminProfile::factory()->state(['is_super_admin' => $super]),
            'status' => AccountStatus::Active,
        ]);
    }

    /**
     * Give the account the given status.
     */
    public function status(AccountStatus $status): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => $status,
        ]);
    }
}
