<?php

namespace App\Services\Accounts;

use App\Enums\Locale;
use App\Enums\ProfileType;
use App\Models\Accounts\AccompagnateurProfile;
use App\Models\Accounts\CitoyenProfile;
use App\Models\Accounts\EntrepreneurProfile;
use App\Models\Accounts\TrainerProfile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class UserService
{
    /**
     * Register a visitor's account (FR-01): the user with the initial status of the role,
     * the profile of the role, the consent, the account language, then the verification e-mail.
     *
     * @param  array{role: string, name: string, email: string, password: string, organisation?: ?string, wilaya_id: int, fonction?: string, linkedin_url?: ?string, education?: string, cv?: UploadedFile}  $data
     */
    public function register(array $data, Locale $locale): User
    {
        $type = ProfileType::from($data['role']);

        $user = DB::transaction(function () use ($data, $type, $locale): User {
            $profile = match ($type) {
                ProfileType::Entrepreneur => EntrepreneurProfile::create(),
                ProfileType::Citoyen => CitoyenProfile::create(),
                ProfileType::Accompagnateur => AccompagnateurProfile::create([
                    'fonction' => $data['fonction'] ?? throw new InvalidArgumentException('An Accompagnateur needs a fonction.'),
                ]),
                ProfileType::Formateur => TrainerProfile::create([
                    'linkedin_url' => $data['linkedin_url'] ?? null,
                    'education' => $data['education'] ?? throw new InvalidArgumentException('A Formateur needs an education.'),
                ]),
                ProfileType::Admin => throw new InvalidArgumentException('Administrators are invited, not registered.'),
            };

            $user = new User([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'organisation' => $data['organisation'] ?? null,
                'wilaya_id' => $data['wilaya_id'],
            ]);

            $user->profile()->associate($profile);
            $user->forceFill([
                'status' => $type->initialStatus(),
                'locale' => $locale,
                'terms_version' => config('accounts.terms_version'),
                'terms_accepted_at' => now(),
            ])->save();

            if ($profile instanceof TrainerProfile) {
                $this->attachCv($profile, $user, $data['cv'] ?? throw new InvalidArgumentException('A Formateur needs a CV.'));
            }

            return $user;
        });

        event(new Registered($user));

        return $user;
    }

    /**
     * Store the Formateur's CV on their profile, held as « En cours de vérification » until scanned.
     */
    private function attachCv(TrainerProfile $profile, User $user, UploadedFile $cv): void
    {
        $profile->addMedia($cv)
            ->toMediaCollection(TrainerProfile::CvCollection)
            ->forceFill(['uploaded_by' => $user->id])
            ->save();
    }

    /**
     * Store the time of a completed sign-in (« Dernière connexion »).
     */
    public function recordSignIn(User $user): void
    {
        $user->forceFill(['last_login_at' => now()])->save();
    }

    /**
     * Store the language the user is using as their account language (SRS FR-06).
     */
    public function updateLocale(User $user, Locale $locale): void
    {
        if ($user->locale === $locale) {
            return;
        }

        $user->forceFill(['locale' => $locale])->save();
    }

    /**
     * Update the user's own profile, clearing the verification when the email changes.
     *
     * @param  array{name: string, email: string}  $data
     */
    public function updateProfile(User $user, array $data): void
    {
        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
    }

    /**
     * Set a new password for the user.
     */
    public function updatePassword(User $user, string $password): void
    {
        $user->forceFill(['password' => $password])->save();
    }

    /**
     * Permanently delete the user's account.
     */
    public function deleteAccount(User $user): void
    {
        $user->delete();
    }

    /**
     * List the user's passkeys for the security settings page.
     *
     * @return array<int, array{id: int, name: string, authenticator: ?string, created_at_diff: string, last_used_at_diff: ?string}>
     */
    public function passkeysFor(User $user): array
    {
        return $user->passkeys()
            ->select(['id', 'name', 'credential', 'created_at', 'last_used_at'])
            ->latest()
            ->get()
            ->map(fn ($passkey) => [
                'id' => $passkey->id,
                'name' => $passkey->name,
                'authenticator' => $passkey->authenticator,
                'created_at_diff' => $passkey->created_at->diffForHumans(),
                'last_used_at_diff' => $passkey->last_used_at?->diffForHumans(),
            ])
            ->values()
            ->all();
    }
}
