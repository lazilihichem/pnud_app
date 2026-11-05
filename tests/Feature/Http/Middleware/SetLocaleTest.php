<?php

namespace Tests\Feature\Http\Middleware;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class SetLocaleTest extends TestCase
{
    use RefreshDatabase;

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
            'email' => 'بيانات الاعتماد هذه غير متطابقة مع سجلاتنا.',
        ]);
        $this->assertGuest();
    }

    public function test_validation_messages_use_translated_attribute_names(): void
    {
        $response = $this->from('/fr/register')->post('/fr/register', []);

        $response->assertRedirect('/fr/register');
        $response->assertSessionHasErrors([
            'email' => 'Le champ adresse e-mail est obligatoire.',
        ]);
        $this->assertGuest();
    }

    public function test_login_redirects_to_the_dashboard_in_the_url_locale(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/ar/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/ar/dashboard');
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
        $response = $this->get('/ar/dashboard');

        $response->assertRedirect('/ar/login');
    }
}
