<?php

namespace Tests\Feature\Accounts;

use App\Enums\AccountStatus;
use App\Enums\Locale;
use App\Enums\ScanStatus;
use App\Enums\UserRole;
use App\Models\Accounts\TrainerProfile;
use App\Models\Reference\Wilaya;
use App\Models\User;
use App\Notifications\Accounts\VerifyEmailNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    private Wilaya $wilaya;

    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();
        Storage::fake('local');

        $this->wilaya = Wilaya::factory()->create();
    }

    /**
     * A valid registration for the given profile.
     *
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function payload(UserRole $role = UserRole::Entrepreneur, array $overrides = []): array
    {
        $profileFields = match ($role) {
            UserRole::Accompagnateur => ['fonction' => 'Chargée d\'incubation'],
            UserRole::Formateur => [
                'linkedin_url' => 'https://www.linkedin.com/in/formateur',
                'education' => 'Master en économie sociale',
                'cv' => UploadedFile::fake()->create('cv.pdf', 200, 'application/pdf'),
            ],
            default => [],
        };

        return [
            'role' => $role->value,
            'name' => 'Amina Benali',
            'email' => 'amina@example.com',
            'organisation' => 'Coopérative Tafat',
            'wilaya_id' => $this->wilaya->id,
            'password' => 'motdepasse1',
            'password_confirmation' => 'motdepasse1',
            'terms' => '1',
            ...$profileFields,
            ...$overrides,
        ];
    }

    public function test_registration_screen_lists_the_four_profiles_and_the_wilayas(): void
    {
        $response = $this->get(route('register'));

        $response->assertInertia(fn (Assert $page) => $page
            ->component('auth/Register')
            ->where('roles', fn ($roles) => collect($roles)->pluck('value')->all() === ['entrepreneur', 'accompagnateur', 'formateur', 'citoyen'])
            ->has('wilayas', 1),
        );
    }

    /**
     * @return array<string, array{UserRole, AccountStatus}>
     */
    public static function initialStatuses(): array
    {
        return [
            'entrepreneur is active' => [UserRole::Entrepreneur, AccountStatus::Active],
            'citoyen is active' => [UserRole::Citoyen, AccountStatus::Active],
            'accompagnateur is inactive' => [UserRole::Accompagnateur, AccountStatus::NotValidated],
            'formateur has qualification to pass' => [UserRole::Formateur, AccountStatus::NotQualified],
        ];
    }

    #[DataProvider('initialStatuses')]
    public function test_registration_creates_the_account_with_the_initial_status_of_the_profile(UserRole $role, AccountStatus $status): void
    {
        $this->travelTo('2026-11-05 10:00:00');

        $response = $this->post(route('register.store'), $this->payload($role));

        $user = User::query()->sole();
        $response->assertRedirect(route('platform.dashboard'));
        $this->assertAuthenticatedAs($user);
        $this->assertSame($role, $user->role);
        $this->assertSame($status, $user->status);
        $this->assertSame('Coopérative Tafat', $user->organisation);
        $this->assertSame($this->wilaya->id, $user->wilaya_id);
        $this->assertSame(Locale::French, $user->locale);
        $this->assertSame(config('accounts.terms_version'), $user->terms_version);
        $this->assertSame('2026-11-05 10:00:00', $user->terms_accepted_at->toDateTimeString());
        $this->assertNull($user->email_verified_at);
        Notification::assertSentTo($user, VerifyEmailNotification::class);
    }

    public function test_accompagnateur_registration_stores_the_function_on_its_profile(): void
    {
        $this->post(route('register.store'), $this->payload(UserRole::Accompagnateur));

        $profile = User::query()->sole()->accompagnateurProfile;
        $this->assertSame('Chargée d\'incubation', $profile->fonction);
        $this->assertSame(0, $profile->capacity);
    }

    public function test_formateur_registration_stores_the_profile_and_a_private_cv_pending_scan(): void
    {
        $this->post(route('register.store'), $this->payload(UserRole::Formateur));

        $user = User::query()->sole();
        $profile = $user->trainerProfile;
        $cv = $profile->getFirstMedia(TrainerProfile::CvCollection);
        $this->assertSame('Master en économie sociale', $profile->education);
        $this->assertSame('https://www.linkedin.com/in/formateur', $profile->linkedin_url);
        $this->assertSame('local', $cv->disk);
        $this->assertSame(ScanStatus::Pending, $cv->refresh()->scan_status);
        $this->assertSame($user->id, $cv->uploaded_by);
        Storage::disk('local')->assertExists($cv->getPathRelativeToRoot());
    }

    public function test_fields_of_another_profile_are_never_stored(): void
    {
        $this->post(route('register.store'), $this->payload(UserRole::Entrepreneur, [
            'fonction' => 'Consultant',
            'education' => 'Doctorat',
            'cv' => UploadedFile::fake()->create('cv.pdf', 10, 'application/pdf'),
        ]));

        $user = User::query()->sole();
        $this->assertNull($user->accompagnateurProfile);
        $this->assertNull($user->trainerProfile);
        $this->assertDatabaseCount('media', 0);
    }

    public function test_registered_address_is_rejected_whatever_its_case(): void
    {
        User::factory()->create(['email' => 'amina@example.com']);

        $response = $this->post(route('register.store'), $this->payload(overrides: ['email' => ' AMINA@Example.com ']));

        $response->assertSessionHasErrors(['email' => 'Un compte existe déjà avec cette adresse.']);
        $this->assertDatabaseCount('users', 1);
        $this->assertGuest();
    }

    public function test_e_mail_is_stored_in_lower_case(): void
    {
        $this->post(route('register.store'), $this->payload(overrides: ['email' => 'Amina@Example.COM']));

        $this->assertSame('amina@example.com', User::query()->sole()->email);
    }

    public function test_administrator_profiles_cannot_be_chosen(): void
    {
        $response = $this->post(route('register.store'), $this->payload(overrides: ['role' => UserRole::Admin->value]));

        $response->assertSessionHasErrors('role');
        $this->assertDatabaseCount('users', 0);
    }

    /**
     * @return array<string, array{string}>
     */
    public static function invalidPasswords(): array
    {
        return [
            'shorter than 8' => ['abcde12'],
            'longer than 64' => [str_repeat('a', 64).'1'],
            'without a digit' => ['motdepasse'],
            'without a letter' => ['12345678'],
        ];
    }

    #[DataProvider('invalidPasswords')]
    public function test_password_must_have_8_to_64_characters_with_a_letter_and_a_digit(string $password): void
    {
        $response = $this->post(route('register.store'), $this->payload(overrides: [
            'password' => $password,
            'password_confirmation' => $password,
        ]));

        $response->assertSessionHasErrors('password');
        $this->assertDatabaseCount('users', 0);
    }

    public function test_different_passwords_are_rejected_with_the_srs_message(): void
    {
        $response = $this->post(route('register.store'), $this->payload(overrides: ['password_confirmation' => 'autrechose1']));

        $response->assertSessionHasErrors(['password' => 'Les mots de passe ne correspondent pas.']);
    }

    public function test_missing_required_fields_and_terms_are_reported_with_the_srs_message(): void
    {
        $response = $this->post(route('register.store'), $this->payload(UserRole::Accompagnateur, [
            'name' => '',
            'wilaya_id' => '',
            'fonction' => '',
            'terms' => null,
        ]));

        $message = 'Veuillez remplir les champs obligatoires.';
        $response->assertSessionHasErrors(['name' => $message, 'wilaya_id' => $message, 'fonction' => $message, 'terms' => $message]);
        $this->assertDatabaseCount('users', 0);
    }

    /**
     * @return array<string, array{UploadedFile}>
     */
    public static function invalidCvs(): array
    {
        return [
            'image' => [UploadedFile::fake()->image('cv.png')],
            'over 5 MB' => [UploadedFile::fake()->create('cv.pdf', 5121, 'application/pdf')],
        ];
    }

    #[DataProvider('invalidCvs')]
    public function test_cv_must_be_a_pdf_or_word_file_of_at_most_5_mb(UploadedFile $cv): void
    {
        $response = $this->post(route('register.store'), $this->payload(UserRole::Formateur, ['cv' => $cv]));

        $response->assertSessionHasErrors(['cv' => 'Format accepté : PDF, DOC, DOCX — 5 Mo maximum.']);
        $this->assertDatabaseCount('users', 0);
    }

    public function test_signed_in_user_opening_the_registration_form_is_sent_to_their_role_home(): void
    {
        $response = $this->actingAs(User::factory()->create())->get(route('register'));

        $response->assertRedirect(route('platform.dashboard'));
    }

    public function test_verification_link_is_valid_for_24_hours(): void
    {
        $this->travelTo('2026-11-05 10:00:00');
        $user = User::factory()->unverified()->create();

        $url = (new VerifyEmailNotification)->toMail($user)->actionUrl;

        parse_str((string) parse_url($url, PHP_URL_QUERY), $query);
        $this->assertSame(strtotime('2026-11-06 10:00:00'), (int) $query['expires']);
    }

    public function test_verification_e_mail_can_be_resent_at_most_3_times_per_hour(): void
    {
        $user = User::factory()->unverified()->create();

        foreach (range(1, 3) as $attempt) {
            $this->actingAs($user)->post(route('verification.send'))->assertRedirect();
        }
        $response = $this->actingAs($user)->post(route('verification.send'));

        $response->assertTooManyRequests();
        Notification::assertSentToTimes($user, VerifyEmailNotification::class, 3);
    }
}
