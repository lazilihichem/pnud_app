<?php

namespace Tests\Feature\Accounts;

use App\Enums\ProfileType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, array{ProfileType, string, string}>
     */
    public static function homes(): array
    {
        return [
            'entrepreneur' => [ProfileType::Entrepreneur, 'platform.entrepreneur.home', 'platform/entrepreneur/Home'],
            'accompagnateur' => [ProfileType::Accompagnateur, 'platform.accompagnateur.home', 'platform/accompagnateur/Home'],
            'formateur' => [ProfileType::Formateur, 'platform.formateur.home', 'platform/formateur/Home'],
            'citoyen' => [ProfileType::Citoyen, 'platform.citoyen.home', 'platform/citoyen/Home'],
        ];
    }

    #[DataProvider('homes')]
    public function test_each_member_profile_is_sent_to_its_own_home(ProfileType $type, string $route, string $component): void
    {
        $user = User::factory()->profile($type)->create();

        $redirect = $this->actingAs($user)->get(route('platform.home'));
        $home = $this->actingAs($user)->get(route($route));

        $redirect->assertRedirect(route($route));
        $home->assertInertia(fn (Assert $page) => $page->component($component));
    }

    public function test_administrators_are_sent_to_the_back_office_home(): void
    {
        $admin = User::factory()->admin(super: true)->create();

        $redirect = $this->actingAs($admin)->get(route('platform.home'));
        $home = $this->actingAs($admin)->get(route('admin.home'));

        $redirect->assertRedirect(route('admin.home'));
        $home->assertInertia(fn (Assert $page) => $page->component('admin/Home'));
    }

    /**
     * Every (signed-in profile, other profile's home) pair, administrators included.
     *
     * @return array<string, array{ProfileType, string}>
     */
    public static function foreignHomes(): array
    {
        $cases = [];

        foreach (ProfileType::cases() as $type) {
            foreach (self::homes() as $owner => [$ownerType, $route]) {
                if ($ownerType !== $type) {
                    $cases["{$type->value} on {$owner}"] = [$type, $route];
                }
            }
        }

        return $cases;
    }

    #[DataProvider('foreignHomes')]
    public function test_a_profile_cannot_open_another_profile_member_space(ProfileType $type, string $route): void
    {
        $user = $type === ProfileType::Admin
            ? User::factory()->admin(super: true)->create()
            : User::factory()->profile($type)->create();

        $response = $this->actingAs($user)->get(route($route));

        $response->assertForbidden();
    }

    public function test_members_cannot_open_the_back_office(): void
    {
        $response = $this->actingAs(User::factory()->create())->get(route('admin.home'));

        $response->assertForbidden();
    }

    public function test_guests_opening_the_back_office_are_sent_to_sign_in(): void
    {
        $response = $this->get(route('admin.home'));

        $response->assertRedirect(route('login'));
    }
}
