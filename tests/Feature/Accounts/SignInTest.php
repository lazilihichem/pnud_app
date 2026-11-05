<?php

namespace Tests\Feature\Accounts;

use App\Enums\AccountStatus;
use App\Enums\UserRole;
use App\Models\User;
use App\Notifications\Accounts\SignInCodeNotification;
use App\Notifications\Accounts\SignInThrottledNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Inertia\Testing\AssertableInertia as Assert;
use Laravel\Fortify\Features;
use Laravel\Passkeys\Contracts\PasskeyLoginResponse;
use Tests\Concerns\InteractsWithSignInCodes;
use Tests\TestCase;

class SignInTest extends TestCase
{
    use InteractsWithSignInCodes, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();
        $this->travelTo('2026-11-05 10:00:00');
    }

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk();
    }

    public function test_correct_password_only_opens_the_code_step_and_sends_a_code(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('login.store'), ['email' => $user->email, 'password' => 'password']);

        $response->assertRedirect(route('login.code'));
        $this->assertGuest();
        Notification::assertSentTo($user, SignInCodeNotification::class);
        $this->assertMatchesRegularExpression('/^\d{6}$/', $this->lastSignInCodeNotification($user)->code);
    }

    public function test_code_page_shows_the_masked_address_and_the_resend_delay(): void
    {
        $user = User::factory()->create(['email' => 'amina@exemple.dz']);
        $this->post(route('login.store'), ['email' => $user->email, 'password' => 'password']);

        $response = $this->get(route('login.code'));

        $response->assertInertia(fn (Assert $page) => $page
            ->component('auth/SignInCode')
            ->where('email', 'a•••@exemple.dz')
            ->where('deliveryPending', true)
            ->where('resendAvailableIn', 60),
        );
    }

    public function test_valid_code_signs_in_to_the_role_home_and_records_the_sign_in(): void
    {
        $user = User::factory()->create();

        $response = $this->signInWithCode($user);

        $response->assertRedirect(route('platform.dashboard'));
        $this->assertAuthenticatedAs($user);
        $this->assertSame('2026-11-05 10:00:00', $user->fresh()->last_login_at->toDateTimeString());
    }

    public function test_sign_in_returns_to_the_platform_page_originally_requested(): void
    {
        $user = User::factory()->create();
        $this->get(route('platform.profile.edit'))->assertRedirect(route('login'));

        $response = $this->signInWithCode($user);

        $response->assertRedirect(route('platform.profile.edit'));
    }

    public function test_e_mail_address_is_case_insensitive_at_sign_in(): void
    {
        $user = User::factory()->create(['email' => 'amina@exemple.dz']);

        $response = $this->post(route('login.store'), ['email' => 'Amina@Exemple.DZ', 'password' => 'password']);

        $response->assertRedirect(route('login.code'));
    }

    public function test_wrong_password_and_unknown_address_get_the_same_generic_message(): void
    {
        $user = User::factory()->create();

        $wrongPassword = $this->post(route('login.store'), ['email' => $user->email, 'password' => 'wrong-password1']);
        $unknownAddress = $this->post(route('login.store'), ['email' => 'nobody@exemple.dz', 'password' => 'password']);

        $wrongPassword->assertSessionHasErrors(['email' => 'Adresse e-mail ou mot de passe incorrect.']);
        $unknownAddress->assertSessionHasErrors(['email' => 'Adresse e-mail ou mot de passe incorrect.']);
        $this->assertGuest();
        Notification::assertNothingSent();
    }

    public function test_after_3_failures_attempts_wait_30_seconds_doubling_up_to_15_minutes(): void
    {
        $user = User::factory()->create();
        $fail = fn () => $this->post(route('login.store'), ['email' => $user->email, 'password' => 'wrong-password1']);

        $fail();
        $fail();
        $fail();
        $this->post(route('login.store'), ['email' => $user->email, 'password' => 'password'])
            ->assertSessionHasErrors(['email' => 'Trop de tentatives. Patientez 30 secondes avant de réessayer.']);

        $this->travel(31)->seconds();
        $fail();
        $fail()->assertSessionHasErrors(['email' => 'Trop de tentatives. Patientez 60 secondes avant de réessayer.']);

        foreach (range(1, 6) as $round) {
            $this->travel(16)->minutes();
            $fail();
        }
        $fail()->assertSessionHasErrors(['email' => 'Trop de tentatives. Patientez 900 secondes avant de réessayer.']);
    }

    public function test_slow_down_applies_to_the_device_not_the_account_and_alerts_its_holder_once(): void
    {
        $user = User::factory()->create();
        foreach (range(1, 4) as $attempt) {
            $this->post(route('login.store'), ['email' => $user->email, 'password' => 'wrong-password1']);
        }

        $fromAnotherDevice = $this->withServerVariables(['REMOTE_ADDR' => '10.0.0.9'])
            ->post(route('login.store'), ['email' => $user->email, 'password' => 'password']);

        $fromAnotherDevice->assertRedirect(route('login.code'));
        Notification::assertSentToTimes($user, SignInThrottledNotification::class, 1);
    }

    public function test_successful_password_step_clears_the_failure_count(): void
    {
        $user = User::factory()->create();
        $fail = fn () => $this->post(route('login.store'), ['email' => $user->email, 'password' => 'wrong-password1']);
        $fail();
        $fail();
        $this->post(route('login.store'), ['email' => $user->email, 'password' => 'password']);

        $response = $fail();

        $response->assertSessionHasErrors(['email' => 'Adresse e-mail ou mot de passe incorrect.']);
    }

    public function test_suspended_account_is_refused_before_any_code_is_sent(): void
    {
        $user = User::factory()->status(AccountStatus::Suspended)->create();

        $response = $this->post(route('login.store'), ['email' => $user->email, 'password' => 'password']);

        $response->assertSessionHasErrors(['email' => 'Votre compte est suspendu. Contactez l\'équipe de la plateforme.']);
        Notification::assertNothingSent();
    }

    public function test_refused_account_is_refused_with_its_reason(): void
    {
        $user = User::factory()->status(AccountStatus::Refused)->create(['status_reason' => 'Dossier incomplet.']);

        $response = $this->post(route('login.store'), ['email' => $user->email, 'password' => 'password']);

        $response->assertSessionHasErrors(['email' => 'Votre inscription n\'a pas été retenue. Dossier incomplet.']);
        Notification::assertNothingSent();
    }

    public function test_inactive_accompagnateur_can_sign_in(): void
    {
        $user = User::factory()->role(UserRole::Accompagnateur)->create();

        $this->signInWithCode($user);

        $this->assertAuthenticatedAs($user);
        $this->assertSame(AccountStatus::NotValidated, $user->status);
    }

    public function test_wrong_code_is_rejected_and_3_wrong_codes_invalidate_it(): void
    {
        $user = User::factory()->create();
        $this->post(route('login.store'), ['email' => $user->email, 'password' => 'password']);
        $code = $this->deliverSignInCode($user);
        $wrong = $code === '000000' ? '111111' : '000000';

        $this->post(route('login.code.verify'), ['code' => $wrong])->assertSessionHasErrors(['code' => 'Code incorrect.']);
        $this->post(route('login.code.verify'), ['code' => $wrong]);
        $this->post(route('login.code.verify'), ['code' => $wrong]);
        $response = $this->post(route('login.code.verify'), ['code' => $code]);

        $response->assertSessionHasErrors('code');
        $this->assertGuest();
    }

    public function test_code_expires_5_minutes_after_its_delivery_not_its_creation(): void
    {
        $user = User::factory()->create();
        $this->post(route('login.store'), ['email' => $user->email, 'password' => 'password']);
        $this->travel(4)->minutes();
        $code = $this->deliverSignInCode($user);

        $this->travel(4)->minutes();
        $this->post(route('login.code.verify'), ['code' => $code])->assertRedirect(route('platform.dashboard'));
    }

    public function test_expired_code_is_rejected(): void
    {
        $user = User::factory()->create();
        $this->post(route('login.store'), ['email' => $user->email, 'password' => 'password']);
        $code = $this->deliverSignInCode($user);
        $this->travel(301)->seconds();

        $response = $this->post(route('login.code.verify'), ['code' => $code]);

        $response->assertSessionHasErrors(['code' => 'Code expiré.']);
        $this->assertGuest();
    }

    public function test_code_not_yet_delivered_reports_the_delay(): void
    {
        $user = User::factory()->create();
        $this->post(route('login.store'), ['email' => $user->email, 'password' => 'password']);

        $response = $this->post(route('login.code.verify'), ['code' => $this->lastSignInCodeNotification($user)->code]);

        $response->assertSessionHasErrors(['code' => 'L\'envoi du code prend plus de temps que prévu.']);
    }

    public function test_code_is_single_use(): void
    {
        $user = User::factory()->create();
        $this->signInWithCode($user);
        $code = $this->lastSignInCodeNotification($user)->code;
        Auth::logout();
        $this->withSession(['sign_in.user_id' => $user->id]);

        $response = $this->post(route('login.code.verify'), ['code' => $code]);

        $response->assertSessionHasErrors(['code' => 'Code expiré.']);
    }

    public function test_resend_is_available_after_60_seconds_and_replaces_the_previous_code(): void
    {
        $user = User::factory()->create();
        $this->post(route('login.store'), ['email' => $user->email, 'password' => 'password']);
        $firstCode = $this->deliverSignInCode($user);

        $this->post(route('login.code.resend'))
            ->assertSessionHasErrors(['code' => 'Vous pourrez renvoyer le code dans 60 secondes.']);

        $this->travel(61)->seconds();
        $this->post(route('login.code.resend'))->assertRedirect(route('login.code'));
        $secondCode = $this->deliverSignInCode($user);
        Notification::assertSentToTimes($user, SignInCodeNotification::class, 2);

        if ($firstCode !== $secondCode) {
            $this->post(route('login.code.verify'), ['code' => $firstCode])->assertSessionHasErrors('code');
        }
        $this->post(route('login.code.verify'), ['code' => $secondCode])->assertRedirect(route('platform.dashboard'));
    }

    public function test_at_most_3_codes_are_sent_per_15_minutes(): void
    {
        $user = User::factory()->create();
        $this->post(route('login.store'), ['email' => $user->email, 'password' => 'password']);
        $this->travel(61)->seconds();
        $this->post(route('login.code.resend'));
        $this->travel(61)->seconds();
        $this->post(route('login.code.resend'));
        $this->travel(61)->seconds();

        $response = $this->post(route('login.code.resend'));

        $response->assertSessionHasErrors('code');
        Notification::assertSentToTimes($user, SignInCodeNotification::class, 3);
        $this->travel(13)->minutes();
        $this->post(route('login.code.resend'))->assertSessionHasNoErrors();
    }

    public function test_valid_code_verifies_the_e_mail_address(): void
    {
        $user = User::factory()->unverified()->create();

        $this->signInWithCode($user);

        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }

    public function test_remember_me_keeps_members_signed_in_but_never_administrators(): void
    {
        $member = User::factory()->create();
        $admin = User::factory()->role(UserRole::Admin)->status(AccountStatus::Active)->create();
        $recaller = Auth::guard()->getRecallerName();

        $this->signInWithCode($member, remember: true)->assertCookie($recaller);
        Auth::logout();
        $this->flushSession();
        $this->signInWithCode($admin, remember: true)->assertCookieMissing($recaller);
    }

    public function test_account_with_an_authenticator_app_continues_to_the_totp_challenge_after_the_code(): void
    {
        $this->skipUnlessFortifyHas(Features::twoFactorAuthentication());
        $user = User::factory()->withTwoFactor()->create();

        $response = $this->signInWithCode($user);

        $response->assertRedirect(route('two-factor.login'));
        $response->assertSessionHas('login.id', $user->id);
        $this->assertGuest();
    }

    public function test_passkey_sign_in_still_requires_the_e_mail_code(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $request = request();
        $request->setLaravelSession($this->app['session.store']);
        $request->headers->set('Accept', 'application/json');

        $response = $this->app->make(PasskeyLoginResponse::class)->toResponse($request);

        $this->assertGuest();
        $this->assertSame(route('login.code'), $response->getData(true)['redirect']);
        $this->assertSame($user->id, session('sign_in.user_id'));
        Notification::assertSentTo($user, SignInCodeNotification::class);
    }

    public function test_code_step_without_a_pending_sign_in_returns_to_the_sign_in_page(): void
    {
        $response = $this->get(route('login.code'));

        $response->assertRedirect(route('login'));
    }

    public function test_using_another_account_drops_the_pending_sign_in(): void
    {
        $user = User::factory()->create();
        $this->post(route('login.store'), ['email' => $user->email, 'password' => 'password']);

        $response = $this->delete(route('login.code.cancel'));

        $response->assertRedirect(route('login'));
        $response->assertSessionMissing('sign_in.user_id');
    }

    public function test_signed_in_user_opening_the_sign_in_page_is_sent_to_their_role_home(): void
    {
        $response = $this->actingAs(User::factory()->create())->get(route('login'));

        $response->assertRedirect(route('platform.dashboard'));
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('logout'));

        $response->assertRedirect('/fr');
        $this->assertGuest();
    }
}
