<?php

namespace Tests\Feature\Operations;

use App\Enums\Locale;
use App\Models\Reference\Wilaya;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class LocaleTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_redirects_a_new_visitor_to_the_french_portal(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/public/fr');
    }

    public function test_url_without_locale_redirects_to_the_cookie_language_keeping_path_and_query(): void
    {
        $response = $this->withCookie(Locale::Cookie, 'ar')->get('/public/projets?secteur=agriculture');

        $response->assertRedirect('/public/ar/projets?secteur=agriculture');
    }

    public function test_account_language_takes_precedence_over_the_cookie(): void
    {
        $user = User::factory()->create(['locale' => Locale::Arabic]);

        $response = $this->actingAs($user)
            ->withCookie(Locale::Cookie, 'fr')
            ->get('/platform/settings/profile');

        $response->assertRedirect('/platform/ar/settings/profile');
    }

    public function test_unsupported_locale_is_treated_as_a_path_of_the_preferred_language(): void
    {
        $response = $this->get('/public/en');

        $response->assertRedirect('/public/fr/en');
    }

    public function test_localized_page_renders_in_its_language_and_remembers_it_in_a_cookie(): void
    {
        $response = $this->get('/public/ar');

        $response->assertOk();
        $response->assertInertia(fn (Assert $page) => $page->where('locale', 'ar'));
        $response->assertSee('dir="rtl"', escape: false);
        $response->assertCookie(Locale::Cookie, 'ar');
    }

    public function test_switching_language_on_the_platform_updates_the_account_language(): void
    {
        $user = User::factory()->create(['locale' => Locale::French]);

        $this->actingAs($user)->get('/platform/ar/settings/profile')->assertOk();

        $this->assertSame(Locale::Arabic, $user->fresh()->locale);
    }

    public function test_sign_in_stores_the_language_in_use_as_account_language(): void
    {
        $user = User::factory()->create(['locale' => Locale::French]);

        $this->withCookie(Locale::Cookie, 'ar')->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
        $this->assertSame(Locale::Arabic, $user->fresh()->locale);
    }

    public function test_registration_stores_the_language_in_use_as_account_language(): void
    {
        $wilaya = Wilaya::factory()->create();

        $this->withCookie(Locale::Cookie, 'ar')->post(route('register.store'), [
            'role' => 'citoyen',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'wilaya_id' => $wilaya->id,
            'password' => 'password1',
            'password_confirmation' => 'password1',
            'terms' => '1',
        ]);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com', 'locale' => 'ar']);
    }
}
