<?php

namespace Tests\Feature\Http\Middleware;

use App\Enums\Locale;
use App\Http\Middleware\SetLocale;
use App\Models\Reference\Wilaya;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\Concerns\InteractsWithSignInCodes;
use Tests\TestCase;

class SetLocaleTest extends TestCase
{
    use InteractsWithSignInCodes, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();
    }

    public function test_root_redirects_to_the_browser_preferred_locale(): void
    {
        $response = $this->get('/', ['Accept-Language' => 'ar-DZ,ar;q=0.9,fr;q=0.8']);

        $response->assertRedirect('/ar');
    }

    public function test_root_falls_back_to_french_for_an_unsupported_browser_language(): void
    {
        $response = $this->get('/', ['Accept-Language' => 'de-DE,de;q=0.9']);

        $response->assertRedirect('/fr');
    }

    public function test_root_redirects_to_the_last_used_locale_over_the_browser_preference(): void
    {
        $this->get('/ar/login')->assertOk();

        $response = $this->get('/', ['Accept-Language' => 'fr-FR,fr;q=0.9']);

        $response->assertRedirect('/ar');
    }

    public function test_unsupported_locale_segment_returns_404(): void
    {
        $response = $this->get('/en/login');

        $response->assertNotFound();
    }

    public function test_arabic_pages_render_right_to_left_with_the_arabic_locale(): void
    {
        $response = $this->get('/ar/login');

        $response->assertOk();
        $response->assertSee('<html lang="ar" dir="rtl"', escape: false);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('auth/Login')
            ->where('locale', 'ar')
            ->where('locales', ['fr', 'ar'])
            ->where('direction', 'rtl'),
        );
    }

    public function test_french_pages_render_left_to_right_with_the_french_locale(): void
    {
        $response = $this->get('/fr/login');

        $response->assertOk();
        $response->assertSee('<html lang="fr" dir="ltr"', escape: false);
        $response->assertInertia(fn (Assert $page) => $page
            ->where('locale', 'fr')
            ->where('direction', 'ltr'),
        );
    }

    public function test_failed_login_returns_the_error_message_in_the_url_locale(): void
    {
        $user = User::factory()->create();

        $response = $this->from('/ar/login')->post('/ar/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect('/ar/login');
        $response->assertSessionHasErrors([
            'email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
        ]);
        $this->assertGuest();
    }

    public function test_validation_messages_use_translated_attribute_names(): void
    {
        $response = $this->from('/fr/register')->post('/fr/register', []);

        $response->assertRedirect('/fr/register');
        $response->assertSessionHasErrors([
            'email' => 'Veuillez remplir les champs obligatoires.',
        ]);
        $this->assertGuest();
    }

    public function test_login_continues_to_the_code_step_then_the_dashboard_in_the_url_locale(): void
    {
        $user = User::factory()->create();

        $passwordStep = $this->post('/ar/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $codeStep = $this->post('/ar/login/code', ['code' => $this->deliverSignInCode($user)]);

        $passwordStep->assertRedirect('/ar/login/code');
        $codeStep->assertRedirect('/ar/platform/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_logout_redirects_to_the_home_page_in_the_url_locale(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/ar/logout');

        $response->assertRedirect('/ar');
        $this->assertGuest();
    }

    public function test_guest_is_redirected_to_the_login_page_in_the_requested_locale(): void
    {
        $response = $this->get('/ar/platform/dashboard');

        $response->assertRedirect('/ar/login');
    }

    public function test_root_prefers_the_account_language_over_the_cookie_and_the_browser(): void
    {
        $user = User::factory()->create(['locale' => Locale::Arabic]);

        $response = $this->actingAs($user)
            ->withCookie(SetLocale::COOKIE, 'fr')
            ->get('/', ['Accept-Language' => 'fr-FR,fr;q=0.9']);

        $response->assertRedirect('/ar');
    }

    public function test_root_prefers_the_language_cookie_over_the_browser_preference(): void
    {
        $response = $this->withCookie(SetLocale::COOKIE, 'ar')->get('/', ['Accept-Language' => 'fr-FR,fr;q=0.9']);

        $response->assertRedirect('/ar');
    }

    public function test_localized_page_remembers_its_language_in_a_cookie(): void
    {
        $response = $this->get('/ar/login');

        $response->assertCookie(SetLocale::COOKIE, 'ar');
    }

    public function test_switching_language_on_the_platform_updates_the_account_language(): void
    {
        $user = User::factory()->create(['locale' => Locale::French]);

        $this->actingAs($user)->get('/ar/platform/settings/profile')->assertOk();

        $this->assertSame(Locale::Arabic, $user->fresh()->locale);
    }

    public function test_sign_in_stores_the_language_in_use_as_account_language(): void
    {
        $user = User::factory()->create(['locale' => Locale::French]);

        $this->post('/ar/login', ['email' => $user->email, 'password' => 'password']);
        $this->post('/ar/login/code', ['code' => $this->deliverSignInCode($user)]);

        $this->assertAuthenticatedAs($user);
        $this->assertSame(Locale::Arabic, $user->fresh()->locale);
    }

    public function test_registration_stores_the_language_in_use_as_account_language(): void
    {
        $wilaya = Wilaya::factory()->create();

        $this->post('/ar/register', [
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
