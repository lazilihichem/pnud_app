<?php

namespace Tests\Feature\Accounts;

use App\Enums\ProfileType;
use App\Models\Accounts\AdminProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, array{ProfileType}>
     */
    public static function profileTypes(): array
    {
        return array_combine(
            array_column(ProfileType::cases(), 'value'),
            array_map(fn (ProfileType $type): array => [$type], ProfileType::cases()),
        );
    }

    #[DataProvider('profileTypes')]
    public function test_profile_resolves_to_the_model_of_the_account_type_stored_by_its_alias(ProfileType $type): void
    {
        $user = User::factory()->profile($type)->create();

        $fresh = User::query()->findOrFail($user->id);

        $this->assertSame($type, $fresh->type);
        $this->assertInstanceOf($type->modelClass(), $fresh->profile);
        $this->assertTrue($fresh->profile->user->is($fresh));
        $this->assertDatabaseHas('users', ['id' => $user->id, 'profilable_type' => $type->value]);
    }

    public function test_setting_the_type_points_the_account_at_that_profile_table(): void
    {
        $user = User::factory()->make();

        $user->type = ProfileType::Citoyen;
        $citoyen = $user->profilable_type;
        $user->type = 'formateur';

        $this->assertSame('citoyen', $citoyen);
        $this->assertSame('formateur', $user->profilable_type);
        $this->assertSame(ProfileType::Formateur, $user->type);
    }

    public function test_administrators_and_super_administrators_share_the_admin_profile(): void
    {
        $admin = User::factory()->admin()->create();
        $superAdmin = User::factory()->admin(super: true)->create();
        $member = User::factory()->create();

        $this->assertInstanceOf(AdminProfile::class, $superAdmin->profile);
        $this->assertTrue($admin->isAdministrator());
        $this->assertFalse($admin->isSuperAdmin());
        $this->assertTrue($superAdmin->isSuperAdmin());
        $this->assertFalse($member->isAdministrator());
        $this->assertFalse($member->isSuperAdmin());
    }
}
